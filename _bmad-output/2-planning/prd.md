---
project: TICCI 360
status: DRAFT
version: 1.1
author: John (BMad PM)
date: 2026-01-14
classification:
  domain: E-commerce (VAR / Tech)
  projectType: Hybrid (API Backend + Web App)
inputDocuments:
  - _bmad-output/1-analysis/technical_decision_headless.md
stepsCompleted:
  - Executive Summary
  - Success Criteria
  - Product Scope
  - User Journeys
  - Functional Requirements
  - Non-Functional Requirements
---

# Product Requirements Document (PRD) - TICCI 360

## 1. Executive Summary
TICCI se transforme d'un simple site e-commerce en une plateforme de **Value Added Reseller (VAR)**. L'objectif est de capitaliser sur l'ADN "Ingénieur" de l'équipe pour offrir de la "Tranquillité Numérique". 

La stratégie repose sur une modernisation progressive vers une architecture découplée (Headless) hébergée sur une infrastructure **VPS souveraine (Self-hosted)**, garantissant performance, contrôle total et différenciation visuelle.

## 2. Success Criteria
| ID | Objectif | Métrique de Succès | Méthode de Mesure |
|:---|:---|:---|:---|
| SC-01 | Performance Frontend | Temps de chargement (LCP) < 1.5s | Google PageSpeed Insights |
| SC-02 | Conversion Vente | Augmentation du taux de conversion de 15% | Analytics (Période N vs N-1) |
| SC-03 | Lead B2B | Augmentation des demandes de devis de 50% | CRM / Logs Formulaires |
| SC-04 | Souveraineté | 100% des composants critiques sur VPS | Audit d'infrastructure |

## 3. Product Scope
### En Périmètre (In-Scope)
- **Phase 1 :** Optimisations Trust & Expertise sur le site existant.
- **Phase 2 :** API Core pour l'exposition des produits.
- **Phase 3 :** Frontend moderne en lecture seule (Showroom).
- **Phase 4 :** Migration transactionnelle complète.
- **Infrastructure :** Migration vers VPS (Docker/Node.js/PHP).

### Hors Périmètre (Out-of-Scope)
- Migration immédiate du checkout (reportée en Phase 4).
- Application mobile native (PWA privilégiée).

## 4. User Journeys
### UJ-01 : Parcours Hybride (Navigation Showroom -> Achat Legacy)
1. **Découverte :** L'utilisateur accède au Showroom moderne.
2. **Consultation :** Il navigue de manière fluide entre les produits (sans rechargement).
3. **Action :** Il clique sur "Acheter" sur une fiche produit.
4. **Transition :** Il est redirigé de manière transparente vers le panier du site legacy avec l'article ajouté.
5. **Finalisation :** Il termine son achat sur le checkout sécurisé actuel.

### UJ-02 : Parcours Expert B2B
1. **Recherche :** Un client pro recherche une configuration spécifique.
2. **Validation :** Il consulte la section "L'avis de l'ingénieur".
3. **Interaction :** Il demande un devis personnalisé via le nouveau composant dédié.
4. **Suivi :** Sa demande est enregistrée et notifiée à l'équipe commerciale.

## 5. Functional Requirements
### FR-01 : Core API (Capacités)
- **FR-01.1 :** Le système doit exposer les données produits via des endpoints sécurisés.
- **FR-01.2 :** L'API doit supporter le filtrage dynamique (catégories, attributs, prix).
- **FR-01.3 :** Le système doit gérer l'authentification des clients frontend via des jetons sécurisés.

### FR-02 : Showroom Frontend (Capacités)
- **FR-02.1 :** L'utilisateur peut naviguer entre les pages produits sans rechargement complet du navigateur.
- **FR-02.2 :** Le frontend doit supporter le rendu côté serveur (SSR) pour garantir un SEO optimal.
- **FR-02.3 :** Le catalogue doit refléter les prix et stocks du backend en temps réel ou quasi-réel.

## 6. Non-Functional Requirements
### NFR-01 : Performance & Scalabilité
- **NFR-01.1 :** Le frontend doit répondre en moins de 500ms pour 95% des requêtes de navigation.
- **NFR-01.2 :** L'architecture doit permettre un déploiement via conteneurs (Docker) sur VPS.

### NFR-02 : Sécurité & Souveraineté
- **NFR-02.1 :** Toutes les communications entre le frontend et l'API doivent être chiffrées via TLS.
- **NFR-02.2 :** Les données clients et produits doivent être hébergées sur l'infrastructure VPS gérée en propre.

## 7. Project-Type Requirements (Hybrid)
- **Interface :** Responsive Design obligatoire (Mobile-first).
- **API :** Documentation OpenAPI/Swagger à jour pour chaque version.
- **DevOps :** Pipeline de déploiement automatisé vers le VPS.

## 8. Domain Requirements (E-commerce VAR)
- **Conformité :** Gestion des taxes par juridiction.
- **Reassurance :** Affichage dynamique des garanties et avis experts sur chaque fiche produit.

## 9. Questions Ouvertes
- Stratégie de synchronisation des sessions entre le Showroom et le site Legacy lors de la redirection du panier.
- Fréquence de mise à jour du cache pour les données de prix/stock sur le Showroom.
