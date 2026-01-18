# Sprint 2 - Digital Showroom Core

**Période:** 18-25 Janvier 2026  
**Objectif:** Livrer le catalogue produits fonctionnel avec SSR/ISR et navigation fluide

---

## 🎯 Objectif du Sprint

Finaliser l'Epic 2 (Stories 2.2, 2.3, 2.4) pour avoir un showroom produits entièrement fonctionnel, connecté à l'API backend, avec SEO optimisé.

---

## 📋 Stories du Sprint

### Story 2.2: Product Catalog Listing (SSR/ISR) - **PRIORITÉ HAUTE**

**En tant que** visiteur  
**Je veux** parcourir les catégories et listes de produits qui se chargent instantanément  
**Afin de** découvrir les produits sans attendre les requêtes base de données

**Critères d'acceptation:**
- [ ] Page `/products` affiche la liste paginée des produits depuis l'API
- [ ] Page `/product-categories/[slug]` filtre par catégorie
- [ ] SSR avec données actuelles + tags ISR pour invalidation
- [ ] Meta tags SEO (title, description) populés depuis l'API
- [ ] Temps de chargement < 500ms (NFR-01.1)

**Tâches techniques:**
1. Créer le service API client (`src/lib/api/products.ts`)
2. Implémenter le fetching SSR dans `src/app/products/page.tsx`
3. Créer le composant `ProductCard` responsive
4. Ajouter la pagination
5. Configurer les tags de revalidation ISR

**Estimation:** 3-4 heures

---

### Story 2.3: Product Detail Page (SEO Optimized) - **PRIORITÉ HAUTE**

**En tant que** visiteur  
**Je veux** voir les informations détaillées d'un produit sur une page dédiée  
**Afin de** prendre une décision d'achat éclairée

**Critères d'acceptation:**
- [ ] Page `/products/[slug]` affiche images, prix, stock, description
- [ ] URL strictement préservée (pas de liens cassés)
- [ ] Canonical tags vers URL legacy (phase hybride)
- [ ] JSON-LD Structured Data pour rich snippets Google
- [ ] Mobile-first responsive design

**Tâches techniques:**
1. Créer `src/app/products/[slug]/page.tsx` avec SSR
2. Implémenter le composant galerie images
3. Ajouter les métadonnées SEO dynamiques
4. Implémenter JSON-LD Product schema
5. Créer le layout responsive mobile-first

**Estimation:** 4-5 heures

---

### Story 2.4: Instant Search & Filtering - **PRIORITÉ MOYENNE**

**En tant que** visiteur  
**Je veux** filtrer les produits et rechercher par mots-clés dynamiquement  
**Afin de** affiner ma sélection sans rechargement de page

**Critères d'acceptation:**
- [ ] Barre de recherche avec mise à jour instantanée
- [ ] Filtres (prix, marque, catégorie) côté client
- [ ] URL query params reflètent l'état des filtres
- [ ] Bouton retour restaure l'état précédent
- [ ] Debounce sur la recherche (300ms)

**Tâches techniques:**
1. Créer le composant `SearchBar` avec debounce
2. Implémenter les filtres avec Zustand store
3. Synchroniser les filtres avec URL search params
4. Créer le composant `FilterSidebar`
5. Optimiser les transitions client-side

**Estimation:** 3-4 heures

---

## 📊 Récapitulatif Sprint

| Story | Priorité | Estimation | Dépendances |
|-------|----------|------------|-------------|
| 2.2 | Haute | 3-4h | API Products OK ✅ |
| 2.3 | Haute | 4-5h | Story 2.2 |
| 2.4 | Moyenne | 3-4h | Story 2.2 |

**Total Sprint:** ~12 heures de développement

---

## ✅ Definition of Done

- [ ] Code testé localement
- [ ] Build Next.js sans erreurs
- [ ] Déployé sur staging.tic.ci
- [ ] Tests manuels passés
- [ ] SEO vérifié (meta tags, JSON-LD)
- [ ] Performance < 500ms vérifié

---

## 🔧 Prérequis Techniques

**API Endpoints requis (déjà disponibles):**
- `GET /api/v1/products` - Liste paginée
- `GET /api/v1/products/{slug}` - Détail produit
- `GET /api/v1/categories` - Liste catégories

**Configuration environnement:**
```env
NEXT_PUBLIC_API_URL=https://api-staging.tic.ci/api/v1
NEXT_PUBLIC_BASE_URL=https://staging.tic.ci
```

---

## 📝 Notes pour l'Agent Dev

1. **Commencer par Story 2.2** - C'est le fondement pour 2.3 et 2.4
2. **Utiliser les types existants** dans `src/types/`
3. **Respecter la structure features** - `src/features/catalog/`
4. **Tester l'API staging** avant d'implémenter le fetching
5. **Suivre le pattern ISR** défini dans l'architecture
