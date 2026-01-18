# Story 2.4: Instant Search & Filtering

**Epic:** 2 - High-Performance Digital Showroom  
**Sprint:** 2  
**Priorité:** Moyenne  
**Estimation:** 3-4 heures  
**Statut:** Review  
**Dépendance:** Story 2.2 (ProductGrid existe)

---

## User Story

**En tant que** visiteur du showroom  
**Je veux** filtrer les produits et rechercher par mots-clés dynamiquement  
**Afin de** affiner ma sélection sans rechargement de page  

---

## Critères d'Acceptation

### AC-2.4.1: Barre de recherche
- [x] **Given** je suis sur la page `/products`
- [x] **When** je tape "HP" dans la barre de recherche
- [x] **Then** la liste se met à jour avec les produits contenant "HP"
- [x] **And** la mise à jour est instantanée (client-side, pas de reload)

### AC-2.4.2: Debounce de recherche
- [x] **Given** je tape rapidement "ordinateur"
- [x] **When** je m'arrête de taper
- [x] **Then** la requête API est envoyée après 300ms de pause
- [x] **And** pas de requêtes multiples pendant la frappe

### AC-2.4.3: Filtres par catégorie
- [x] **Given** je suis sur `/products`
- [x] **When** je sélectionne la catégorie "Informatique"
- [x] **Then** seuls les produits de cette catégorie s'affichent
- [x] **And** je peux sélectionner plusieurs catégories (OR logic)

### AC-2.4.4: Filtres par prix
- [x] **Given** je suis sur `/products`
- [x] **When** je définis une fourchette de prix (100000 - 500000 XOF)
- [x] **Then** seuls les produits dans cette fourchette s'affichent

### AC-2.4.5: Synchronisation URL
- [x] **Given** j'ai appliqué des filtres (catégorie: informatique, prix: 100000-500000)
- [x] **When** je regarde l'URL
- [x] **Then** elle contient `?q=HP&category=informatique&min_price=100000&max_price=500000`
- [x] **And** je peux partager cette URL et les filtres sont restaurés

### AC-2.4.6: Bouton retour navigateur
- [x] **Given** j'ai navigué: `/products` → filtré → autre filtre
- [x] **When** je clique sur le bouton retour
- [x] **Then** les filtres précédents sont restaurés
- [x] **And** la liste se met à jour correctement

### AC-2.4.7: Reset des filtres
- [x] **Given** j'ai plusieurs filtres actifs
- [x] **When** je clique sur "Réinitialiser"
- [x] **Then** tous les filtres sont supprimés
- [x] **And** l'URL revient à `/products`

### AC-2.4.8: Indicateur de résultats
- [x] **Given** j'ai appliqué des filtres
- [x] **When** la liste est mise à jour
- [x] **Then** je vois "X produits trouvés"
- [x] **And** si 0 résultats, un message "Aucun produit trouvé" s'affiche

---

## Tâches Techniques

### Task 1: State Management (Zustand)
- [x] 1.1 Créer `src/features/search/store/filterStore.ts`
- [x] 1.2 Définir le state: query, categories[], minPrice, maxPrice, sortBy
- [x] 1.3 Implémenter les actions: setQuery, toggleCategory, setPriceRange, reset

### Task 2: URL Sync Hook
- [x] 2.1 Créer `src/features/search/hooks/useFilterSync.ts`
- [x] 2.2 Sync bidirectionnelle: Zustand ↔ URL searchParams
- [x] 2.3 Gérer le bouton retour avec `popstate` (via useEffect sync)

### Task 3: Composants Search
- [x] 3.1 Créer `src/features/search/components/SearchBar.tsx` avec debounce
- [x] 3.2 Créer `src/features/search/components/FilterSidebar.tsx`
- [x] 3.3 Créer `src/features/search/components/CategoryFilter.tsx`
- [x] 3.4 Créer `src/features/search/components/PriceRangeFilter.tsx`
- [x] 3.5 Créer `src/features/search/components/ActiveFilters.tsx` (chips)

### Task 4: Intégration API
- [x] 4.1 Modifier `src/lib/api/products.ts` pour accepter les params de filtre
- [x] 4.2 Implémenter le fetching client-side avec les filtres (via ProductCatalog)
- [x] 4.3 Ajouter un loading state pendant la recherche

### Task 5: Intégration page produits
- [x] 5.1 Intégrer SearchBar dans le header de `/products`
- [x] 5.2 Intégrer FilterSidebar (desktop)
- [x] 5.3 Connecter ProductGrid au filterStore (via ProductCatalog)

---

## Architecture State (Zustand)

```typescript
// src/features/search/store/filterStore.ts
interface FilterState {
  query: string;
  categories: string[];
  minPrice: number | null;
  maxPrice: number | null;
  sortBy: 'newest' | 'price_asc' | 'price_desc' | 'popular';
  
  // Actions
  setQuery: (query: string) => void;
  toggleCategory: (slug: string) => void;
  setPriceRange: (min: number | null, max: number | null) => void;
  setSortBy: (sort: SortOption) => void;
  reset: () => void;
}
```

---

## Endpoints API Requis

| Endpoint | Méthode | Params |
|----------|---------|--------|
| `/api/v1/products` | GET | `q`, `category`, `min_price`, `max_price`, `sort`, `page` |

**Exemple:**
```
GET /api/v1/products?q=HP&category=informatique&min_price=100000&max_price=500000&sort=price_asc&page=1
```

---

## Fichiers à Créer/Modifier

```
apps/showroom/
├── src/
│   ├── features/
│   │   └── search/
│   │       ├── store/
│   │       │   └── filterStore.ts (nouveau)
│   │       ├── hooks/
│   │       │   └── useFilterSync.ts (nouveau)
│   │       └── components/
│   │           ├── SearchBar.tsx (nouveau)
│   │           ├── FilterSidebar.tsx (nouveau)
│   │           ├── CategoryFilter.tsx (nouveau)
│   │           ├── PriceRangeFilter.tsx (nouveau)
│   │           └── ActiveFilters.tsx (nouveau)
│   ├── lib/
│   │   └── api/
│   │       └── products.ts (modifier - ajouter params)
│   └── app/
│       └── products/
│           └── page.tsx (modifier - intégrer search)
```

---

## Dépendances NPM

```json
{
  "zustand": "^5.0.10"  // Déjà prévu dans l'architecture
}
```

---

## Definition of Done

- [x] Tous les AC validés
- [x] URL sync fonctionne (partage de lien avec filtres)
- [x] Bouton retour navigateur fonctionne
- [x] Debounce 300ms vérifié
- [x] Mobile responsive (Layout adapté)
- [x] Build Next.js sans erreurs
- [ ] Déployé sur staging.tic.ci

---

## Dev Agent Record

### Implementation Date
2026-01-18

### Files Created/Modified
- `apps/showroom/src/features/search/store/filterStore.ts` - Zustand store for global filters
- `apps/showroom/src/features/search/hooks/useFilterSync.ts` - Bidirectional URL synchronization hook
- `apps/showroom/src/features/search/components/SearchBar.tsx` - Updated to use store with debounce
- `apps/showroom/src/features/search/components/FilterSidebar.tsx` - Desktop filter sidebar
- `apps/showroom/src/features/search/components/CategoryFilter.tsx` - Checkbox list for categories
- `apps/showroom/src/features/search/components/PriceRangeFilter.tsx` - Min/Max price inputs
- `apps/showroom/src/features/search/components/ActiveFilters.tsx` - Dismissible chips for active filters
- `apps/showroom/src/features/catalog/components/ProductCatalog.tsx` - Client-side engine for dynamic updates
- `apps/showroom/src/app/products/page.tsx` - Integrated filters and dynamic catalog

### Completion Notes
- Implemented global state for filters using Zustand v5.
- URL synchronization ensures shareable links and functional browser back/forward buttons.
- Optimized performance with 300ms debounce on text search.
- Clean separation of concerns between SSR (initial load) and Client-side updates (filtering).
- Mobile layout uses responsive blocks, with "Add to Cart" sticky button from Story 2.3.

### Change Log
- 2026-01-18: Story 2.4 implementation completed.
