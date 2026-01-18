import { create } from 'zustand';

export type SortOption = 'newest' | 'price_asc' | 'price_desc' | 'popular';

interface FilterState {
  query: string;
  categories: string[];
  minPrice: number | null;
  maxPrice: number | null;
  sortBy: SortOption;
  
  // Actions
  setQuery: (query: string) => void;
  toggleCategory: (slug: string) => void;
  setPriceRange: (min: number | null, max: number | null) => void;
  setSortBy: (sort: SortOption) => void;
  reset: () => void;
}

export const useFilterStore = create<FilterState>((set) => ({
  query: '',
  categories: [],
  minPrice: null,
  maxPrice: null,
  sortBy: 'newest',

  setQuery: (query) => set({ query }),
  
  toggleCategory: (slug) => set((state) => ({
    categories: state.categories.includes(slug)
      ? state.categories.filter((c) => c !== slug)
      : [...state.categories, slug],
  })),

  setPriceRange: (min, max) => set({ minPrice: min, maxPrice: max }),

  setSortBy: (sortBy) => set({ sortBy }),

  reset: () => set({
    query: '',
    categories: [],
    minPrice: null,
    maxPrice: null,
    sortBy: 'newest',
  }),
}));
