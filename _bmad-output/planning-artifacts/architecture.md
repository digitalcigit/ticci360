---
stepsCompleted: [1, 2, 3, 4, 5, 6, 7]
inputDocuments: 
  - _bmad-output/2-planning/prd.md
  - _bmad-output/1-analysis/technical_decision_headless.md
  - docs/architecture.md
  - docs/project-overview.md
  - docs/technology-stack.md
workflowType: 'architecture'
project_name: 'ticci360'
user_name: 'TICCI'
date: '2026-01-14'
---

# Architecture Decision Document

_This document builds collaboratively through step-by-step discovery. Sections are appended as we work through each architectural decision together._

## Project Context Analysis

### Requirements Overview

**Functional Requirements:**
- **Hybrid Core:** Coexistence d'un Backend monolithique (Laravel/Botble) servant d'API et d'un Frontend découplé (Showroom).
- **Parcours Hybride:** Le Showroom gère la découverte et la navigation, mais le checkout reste sur le Legacy (redirection avec maintien de session/panier).
- **API Exposition:** Le monolithe doit exposer ses données (produits, catégories, attributs) via une API sécurisée.

**Non-Functional Requirements:**
- **Souveraineté & Contrôle:** Hébergement 100% maîtrisé sur VPS Debian (pas de PaaS type Vercel).
- **Performance:** LCP < 1.5s pour le Showroom (rendu SSR) et temps de réponse < 500ms pour 95% des requêtes de navigation.
- **Déploiement:** Conteneurisation (Docker) pour garantir la reproductibilité entre Staging et Prod.
- **SEO URL Preservation:** Le Showroom Next.js DOIT conserver strictement la structure d'URL actuelle (ex: `/products/{slug}`) pour ne pas perdre le référencement Google existant.

**Scale & Complexity:**
- **Primary Domain:** E-commerce (Hybrid Monolith/Headless).
- **Complexity Level:** High (Gestion de la dualité Legacy/Moderne, synchro d'états, contraintes SEO strictes).
- **Architectural Components:**
  - Reverse Proxy (Nginx) - point critique pour le routing SEO
  - Legacy App (PHP-FPM)
  - Showroom App (Node.js)
  - Database (MySQL/MariaDB)
  - Redis (Cache/Session shared)

### Technical Constraints & Dependencies

- **Infrastructure:** VPS Debian unique (Staging puis Prod par bascule DNS).
- **Migration Progressive sur VPS:**
  - Phase initiale: clonage du site actuel (Laravel/Botble) sur VPS (Staging)
  - Développement: construire l'API et déployer le Showroom (Docker) sur VPS
  - Bascule: après validation, bascule DNS pour faire du VPS la nouvelle Production
- **Legacy:** Le code Botble existant ne doit pas être cassé par l'ajout de l'API.
- **SEO Staging:** L'environnement de staging doit être interdit aux robots (noindex) pour éviter le duplicate content.

### Cross-Cutting Concerns Identified

- **Routing & Reverse Proxy (Zero Broken Links):** Le reverse proxy doit router les URL historiques vers le bon service.
- **Canonical Strategy:** Pendant la phase hybride (ex: Showroom sur `app.tic.ci`), les pages équivalentes doivent gérer les balises canonical de manière cohérente.
- **Session Sharing:** Continuité de session entre Showroom et Checkout legacy (cookies domaine racine + store session commun).
- **Assets:** Images et médias (hébergés côté legacy) doivent être accessibles depuis le Showroom.

## Starter Template Evaluation

### Selected Starter

- **Starter:** `create-next-app@latest` (App Router)
- **Language:** TypeScript
- **Linter:** ESLint
- **Styling:** Tailwind CSS
- **Project structure:** `src/` directory
- **Import alias:** `@/*`

### Initialization Command

```bash
npx create-next-app@latest ticci-showroom --typescript --eslint --tailwind --app --src-dir --import-alias "@/*"
```

## VPS Existing Ecosystem Constraints (Strict)

### Reverse Proxy (Nginx Central)

- **Nginx exists already:** conteneur central `digitalcloud360-nginx-1` (reverse proxy unique pour tous les projets).
- **Strict constraint:** ne pas créer un nouveau Nginx frontal.
- **Integration point:** ajouter une config `ticci.conf` dans `/opt/digitalcloud360/nginx/sites-available/` (puis activer via symlink dans `sites-enabled`).
- **Note:** ce répertoire est bind-mount dans le conteneur Nginx (ex: `./nginx/sites-available` -> `/etc/nginx/sites-available`).
- **SSL/TLS:** géré par Certbot via volumes partagés dans le conteneur Nginx:
  - `/etc/letsencrypt` (certificats)
  - `/var/www/certbot` (ACME challenge)

### Backend Strategy (Legacy/Botble via PHP-FPM Host)

- **PHP-FPM host:** PHP-FPM 8.2 sur l’hôte, socket `unix:/run/php/php8.2-fpm.sock` (déjà utilisé par les autres sites).
- **Deployment location:** déployer le code Botble sur l’hôte dans `/var/www/ticci`.
- **Nginx execution model:** Nginx (dans le conteneur) proxifie l’exécution PHP vers l’upstream `php_fpm`.
- **Required mount for Nginx container:** `/var/www/ticci` doit être monté dans le conteneur Nginx (même logique que `/var/www/dolibarr/...` et `/var/www/laravel`).

### Frontend Strategy (Next.js via Docker)

- **Deployment:** conteneur Next.js (Node) sur le VPS.
- **Internal port:** à définir (référence: `3005`).
- **Nginx upstream strategy:** ajouter un upstream pointant vers le Docker bridge:
  - `ticci_showroom` -> `172.17.0.1:3005`

### Routing & Cutover Strategy

- **Staging validation:** `staging.tic.ci` (ou sous-domaine temporaire) pointe vers la config `ticci.conf` pour valider l’architecture hybride.
- **Production cutover:** à terme, `www.tic.ci` doit pointer vers le Showroom Next.js (sans casser les URLs historiques).
- **API access pattern (target):** exposer le Legacy via `api.tic.ci` (recommandé) ou via un path interne, consommé par Next.js.

## Core Architectural Decisions

### Decision Priority Analysis

**Critical Decisions (Block Implementation):**
- DB + Redis dédiés (staging isolé inclus)
- Modèle de session partagée (Sanctum stateful + Redis)
- Contrat API versionné `/api/v1` + format d’erreurs stable
- Stratégie SEO (URLs strictes + canonicals)

**Important Decisions (Shape Architecture):**
- ISR / tag-based revalidation + mécanisme d’invalidation depuis Botble
- Monitoring centralisé (Prometheus/Grafana)
- Rate limiting au Nginx central

**Deferred Decisions (Post-MVP):**
- Optimisations avancées de performance (CDN, edge caching)
- Exposition API avancée (API partners / mobile durcie)

### Data Architecture

- **System of Record:** MySQL (Botble) reste la source de vérité.
- **Database Runtime:** MySQL en Docker via une stack dédiée `ticci-db`.
- **Database Version (verified):** MySQL 8.4 (LTS release line).
- **Redis Runtime:** Redis en Docker via une instance dédiée `ticci-redis` (isolation stricte des caches/sessions e-commerce).
- **Sessions Cross-App (Legacy ↔ Showroom):** store commun Redis.
  - Laravel configuré avec `SESSION_DRIVER=redis`.
  - Cookie de session partagé au niveau du domaine racine (`.tic.ci`).
  - Next.js interroge l’API Laravel (Sanctum) qui valide la session via Redis.
- **Rationale:** alignement avec l’infra VPS existante (services conteneurisés), meilleure isolation, et continuité panier/session entre Showroom et Checkout legacy.

### Authentication & Security

- **Auth Model:** Laravel Sanctum en mode "stateful" (SPA auth) avec cookies partagés sur le domaine racine.
- **Cookie Policy:** `SameSite=Lax` (cookies valides pour `app.tic.ci` ↔ `www.tic.ci` ↔ `api.tic.ci`).
- **API Exposure:** `api.tic.ci` public (catalogue public + debug + préparation multi-canaux).
- **Rate Limiting:** appliqué au niveau du Nginx central (avant PHP-FPM), via la configuration dédiée (ex: `rate-limiting.conf`).

### API & Communication Patterns

- **API Style:** REST JSON.
- **Namespace Strategy:** namespace unifié sous `/api/v1/...`.
  - Endpoints catalogue accessibles sans authentification.
  - Endpoints sensibles (panier, compte) protégés via middleware Sanctum (stateful).
- **Versioning:** par path (`/api/v1/`) pour permettre l’évolution sans casser le frontend.
- **Error Handling Standard:** format JSON d’erreur standardisé pour distinguer clairement validation (ex: 422) et erreurs serveur (5xx) côté Next.js.
  - Shape cible: `{ "error": { "code": string, "message": string, "fields"?: object } }`.

### Frontend Architecture

- **Data Fetching Strategy:** hybride.
  - Catalogue (produits / catégories): Server Components (SSR) pour SEO + performance initiale.
  - Interactions (panier / compte): Client Components (lecture/écriture via API, cookies de session Laravel), avec `useEffect` ou SWR selon besoins UI.
- **Caching Strategy:** ISR / tag-based revalidation.
  - Invalidation on-demand via tags (ex: revalidate par produit/catégorie) déclenchée par webhook/API depuis Botble.
  - **Next.js Cache Invalidation API:** `revalidateTag(tag, profile)` avec `profile="max"` (stale-while-revalidate recommandé).
- **Client State Management:** Zustand.
  - **Version (verified):** Zustand v5.0.10.
  - Usage: état "optimiste" du panier (UI immédiate) puis synchronisation avec l’API (source de vérité = session Laravel/Redis).
- **SEO Canonical (Phase Hybride):** canonical vers `www.tic.ci` (Legacy) pour éviter duplicate content.
  - **Post-cutover (Phase 4):** canonical "self" (domaine de prod).

### Infrastructure & Deployment

- **Orchestration:** stack Docker dédiée `ticci/` (référence: installation sous `/opt/ticci`) avec son propre `docker-compose.yml`.
- **Networking (Nginx ↔ Containers):** upstream via Docker bridge `172.17.0.1` (aligné avec la convention VPS existante).
- **Staging Strategy:** stack staging complète sur `staging.tic.ci`, avec DB/Redis dédiés et base clonée (validation sans risque pour la prod actuelle).
- **Monitoring:** centralisation via Prometheus/Grafana (infrastructure déjà présente sur le VPS).
- **Backups:** mix "dump SQL + snapshot".

### Decision Impact Analysis

**Implementation Sequence:**
1. Déployer la stack staging (DB/Redis dédiés) et synchroniser Botble dans `/var/www/ticci` (host).
2. Publier l’API `/api/v1` côté Laravel/Botble + Sanctum stateful + sessions Redis.
3. Déployer Next.js (Docker) + Nginx central `ticci.conf` + upstream `ticci_showroom`.
4. Implémenter ISR/tagging + endpoint sécurisé d’invalidation (revalidateTag) et wiring webhook.
5. Valider SEO: URLs strictes + canonical vers `www.tic.ci` (hybride) + noindex sur staging.
6. Cutover production: bascule DNS vers le Showroom, puis canonical self.

**Cross-Component Dependencies:**
- Le panier/session dépend du triptyque: cookies `.tic.ci` + Sanctum stateful + Redis partagé.
- L’ISR dépend d’un contrat d’invalidation stable (tags) et d’un déclencheur depuis Botble.
- Le rate limiting (Nginx) doit précéder PHP-FPM pour protéger le legacy.

## Implementation Patterns & Consistency Rules

### Pattern Categories Defined

**Critical Conflict Points Identified:**
- Conventions JSON (snake_case) et mapping TypeScript côté frontend
- Format de réponse API (wrapper `{ data, meta }` + format d’erreurs standardisé)
- Convention de tags ISR (par ID) et mécanisme d’invalidation
- Organisation du code Next.js (structure `src/features/*`)

### Naming Patterns

**API & JSON Naming Conventions:**
- Les champs JSON exposés par l’API doivent être en `snake_case`.
- Les types et interfaces TypeScript du Showroom doivent refléter cette convention (ex: `price_ht`, `created_at`).

**ISR Tag Naming Conventions:**
- Les tags ISR doivent être basés sur des identifiants immuables.
- Convention cible (exemples):
  - `product:{id}`
  - `category:{id}`
  - `catalog`

### Structure Patterns

**Next.js Project Organization (Showroom):**
- Organisation par domaine fonctionnel sous `src/features/`.
- Chaque feature regroupe son API client, ses types, son store, et ses composants locaux.
- Exemple de structure attendue (non exhaustive):
  - `src/features/catalog/api.ts`
  - `src/features/catalog/types.ts`
  - `src/features/cart/api.ts`
  - `src/features/cart/store.ts`

### Format Patterns

**API Success Response Format:**
- Réponses réussies doivent utiliser un wrapper `{ data, meta }`.
- `meta` sert notamment à la pagination et à l’évolutivité des réponses.
- Exemple (shape):
  - `{ "data": ..., "meta": ... }`

**API Error Response Format:**
- Les erreurs doivent suivre un format stable pour permettre au frontend de distinguer 4xx/5xx de manière fiable.
- Shape cible:
  - `{ "error": { "code": string, "message": string, "fields"?: object } }`

**Status Code Conventions:**
- Les erreurs de validation doivent utiliser 422 avec `fields` pour le détail.

### Communication Patterns

**Cache Invalidation (Botble → Next.js):**
- L’invalidation doit être déclenchée par l’ID immuable (ex: webhook Botble qui transmet `product_id`).
- Next.js invalide les tags correspondants (ex: `product:{id}`) et les pages rechargent au prochain hit.
- API Next.js recommandée:
  - `revalidateTag(tag, profile)` avec `profile="max"`.

### Process Patterns

**SSR vs Client Components:**
- Catalogue (produits/catégories): SSR / Server Components.
- Panier/compte: Client Components (interaction via API, session via cookies `.tic.ci`).

**Optimistic UI (Panier):**
- Le store Zustand peut mettre à jour l’UI immédiatement.
- La source de vérité reste la session Laravel (Redis) via l’API.

### Enforcement Guidelines

**All AI Agents MUST:**
- Respecter `snake_case` sur tous les payloads JSON de l’API.
- Respecter le wrapper `{ data, meta }` sur les réponses de succès.
- Respecter le format `{ error: { code, message, fields? } }` sur les erreurs.
- Respecter les tags ISR par ID (ex: `product:{id}`) et ne pas baser les tags sur les slugs.
- Organiser le code Showroom par feature sous `src/features/*`.

**Pattern Examples**

**Good Examples:**
- JSON: `{ "created_at": "2026-01-15T00:00:00Z", "price_ht": 10000 }`
- Success: `{ "data": [ ... ], "meta": { "page": 1 } }`
- Error 422: `{ "error": { "code": "validation_error", "message": "Invalid input", "fields": { "email": ["required"] } } }`
- Tag: `product:1234`

**Anti-Patterns:**
- Mélanger `camelCase` et `snake_case` dans l’API
- Réponses success non wrapper (ex: `{ ... }` sans `data/meta`)
- Tags ISR basés sur slug (ex: `product:laptop-hp-15`)
- Un seul fichier API global qui grossit sans structure de features

## Project Structure & Boundaries

### Complete Project Directory Structure

```bash
ticci360/
├── README.md
├── docs/
│   ├── architecture.md
│   ├── prd.md
│   ├── migration-plan.md
│   └── vps/
│       ├── nginx.md
│       ├── certbot.md
│       └── operations.md
├── infra/
│   ├── nginx/
│   │   ├── sites-available/
│   │   │   ├── ticci.conf
│   │   │   └── ticci-staging.conf
│   │   └── conf.d/
│   │       ├── upstream.conf
│   │       └── rate-limiting.conf
│   ├── docker/
│   │   ├── prod/
│   │   │   ├── docker-compose.yml
│   │   │   └── .env.example
│   │   └── staging/
│   │       ├── docker-compose.yml
│   │       └── .env.example
│   └── scripts/
│       ├── backup_db.sh
│       ├── restore_db.sh
│       ├── seed_staging_from_prod.sh
│       └── healthcheck.sh
└── apps/
    └── showroom/
        ├── README.md
        ├── package.json
        ├── next.config.ts
        ├── tsconfig.json
        ├── tailwind.config.ts
        ├── .env.example
        ├── src/
        │   ├── app/
        │   │   ├── layout.tsx
        │   │   ├── page.tsx
        │   │   ├── page.test.tsx
        │   │   ├── products/
        │   │   │   └── [slug]/
        │   │   │       └── page.tsx
        │   │   └── product-categories/
        │   │       └── [slug]/
        │   │           └── page.tsx
        │   ├── components/
        │   │   ├── ui/
        │   │   └── layout/
        │   ├── features/
        │   │   ├── catalog/
        │   │   │   ├── api.ts
        │   │   │   ├── types.ts
        │   │   │   ├── selectors.ts
        │   │   │   └── components/
        │   │   ├── cart/
        │   │   │   ├── api.ts
        │   │   │   ├── types.ts
        │   │   │   ├── store.ts
        │   │   │   └── components/
        │   │   └── account/
        │   │       ├── api.ts
        │   │       ├── types.ts
        │   │       └── components/
        │   ├── lib/
        │   │   ├── http/
        │   │   │   ├── client.ts
        │   │   │   └── errors.ts
        │   │   ├── seo/
        │   │   │   ├── canonical.ts
        │   │   │   └── metadata.ts
        │   │   └── env.ts
        │   └── types/
        │       └── api.ts
```

### Architectural Boundaries

**API Boundaries:**
- `api.tic.ci` expose `/api/v1/...` (REST JSON, snake_case, wrapper `{ data, meta }`).
- `app.tic.ci` (Showroom) consomme l’API via cookies (Sanctum stateful).
- Les endpoints sensibles sont protégés par Sanctum; le catalogue reste public.

**Component Boundaries (Showroom):**
- `src/app/*` : routing et pages (Server Components pour catalogue).
- `src/features/*` : logique par domaine (catalog/cart/account), y compris `api.ts`, `types.ts`, et stores.
- `src/types/api.ts` : types partagés (wrapper, error, meta).
- Tests co-locés: `*.test.ts(x)` au plus près du code.

**Service Boundaries (Legacy Botble):**
- Le code Botble/Laravel est traité comme un service externe “black box” (hors monorepo).
- Le monorepo ne modifie pas directement le legacy; l’intégration passe par l’API `/api/v1` et la configuration infra.

**Infrastructure Boundaries:**
- `infra/nginx/` : templates et conventions de configuration (à déployer dans `/opt/digitalcloud360/nginx/sites-available/`).
- `infra/docker/` : stack Docker TICCI (`ticci-db`, `ticci-redis`, `ticci-showroom`) séparée des autres projets.
- `infra/scripts/` : scripts d’exploitation (backup/restore/seed staging) versionnés.

### Requirements to Structure Mapping

**Hybrid Core (Legacy + Showroom):**
- Showroom Next.js: `apps/showroom/src/app/*` + `apps/showroom/src/features/*`
- Intégration API: `apps/showroom/src/features/*/api.ts` + `apps/showroom/src/lib/http/client.ts`
- Legacy Botble (external): API `/api/v1` + déploiement sur VPS

**SEO URL Preservation / Zero Broken Links:**
- Routes: `apps/showroom/src/app/products/[slug]/page.tsx`, `apps/showroom/src/app/product-categories/[slug]/page.tsx`
- SEO helpers: `apps/showroom/src/lib/seo/*`
- Nginx routing: `infra/nginx/sites-available/ticci.conf`

**ISR / Cache Invalidation:**
- Tags & conventions: `apps/showroom/src/features/catalog/*`
- Endpoint invalidation (si implémenté côté Next): `apps/showroom/src/app/api/*` (Route Handlers)
- Scripts ops: `infra/scripts/*` (support exploitation)

### File Organization Patterns

**Configuration Files:**
- Variables: `.env.example` (showroom) + `infra/docker/*/.env.example`.
- Les secrets ne sont jamais committés.

**Test Organization:**
- Tests co-locés: `*.test.ts(x)`.
- Les tests d’intégration (si ajoutés) peuvent être regroupés sous `apps/showroom/src/__tests__/`.

## Architecture Validation Results

### Coherence Analysis

**Status:** ✅ **PASS**

- **Decision Compatibility:** The hybrid architecture (Nginx central, Dockerized Next.js, Host PHP-FPM) is fully compatible with the existing VPS ecosystem constraints.
- **Pattern Consistency:** Adopted patterns (`snake_case`, `ISR tag-based`) provide a robust contract between the Legacy Backend and the Modern Frontend.
- **Structure Alignment:** The Monorepo structure correctly isolates the new system while treating the Legacy Botble app as an external service ("Black Box"), minimizing regression risks.

### Requirements Coverage (PRD)

**1. SEO & URL Preservation (Critical):**
- **Coverage:** High.
- **Mechanism:** Next.js App Router with strict slug matching (`/products/[slug]`) ensures zero broken links.
- **Action Item:** A comprehensive list of Legacy URLs (including pagination/filters) must be established during implementation to ensure 100% coverage.

**2. Infrastructure Integration:**
- **Coverage:** Complete.
- **Mechanism:** Use of the existing Nginx reverse proxy and PHP-FPM socket ensures no disruption to other hosted services (Ecademi, Dolibarr).
- **Action Item:** Finalize `docker-compose.yml` and `ticci.conf` details during the first sprint.

**3. Session Continuity (User Journey):**
- **Coverage:** Complete.
- **Mechanism:** Shared Redis session store + `.tic.ci` root domain cookies + Stateful Sanctum authentication.
- **Action Item:** Strict configuration of `SESSION_DOMAIN` and CORS headers is required to prevent cross-subdomain issues.

### Implementation Readiness

- **Overall Status:** **READY FOR IMPLEMENTATION**
- **Confidence Level:** High.
- **Pending Actions (Non-Blocking):**
  - Define exact list of Legacy URLs for SEO tests.
  - Document `SESSION_DOMAIN` and CORS configuration values.
  - Setup CI/CD pipeline for VPS deployment.

**Validation Verdict:** The architecture is approved for the Implementation Phase.
