'use client';

import { useEffect, useRef } from 'react';
import { useRouter, useSearchParams, usePathname } from 'next/navigation';
import { useFilterStore, SortOption } from '../store/filterStore';

export function useFilterSync() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const pathname = usePathname();
  const isInitialMount = useRef(true);

  const {
    query,
    categories,
    minPrice,
    maxPrice,
    sortBy,
    setQuery,
    toggleCategory,
    setPriceRange,
    setSortBy,
  } = useFilterStore();

  // Sync URL -> Store (Initial load)
  useEffect(() => {
    if (isInitialMount.current) {
      const q = searchParams.get('q') || '';
      const cats = searchParams.get('category')?.split(',').filter(Boolean) || [];
      const min = searchParams.get('min_price') ? Number(searchParams.get('min_price')) : null;
      const max = searchParams.get('max_price') ? Number(searchParams.get('max_price')) : null;
      const sort = (searchParams.get('sort') as SortOption) || 'newest';

      if (q) setQuery(q);
      cats.forEach(c => toggleCategory(c));
      if (min !== null || max !== null) setPriceRange(min, max);
      if (sort) setSortBy(sort);

      isInitialMount.current = false;
    }
  }, [searchParams, setQuery, toggleCategory, setPriceRange, setSortBy]);

  // Sync Store -> URL
  useEffect(() => {
    if (isInitialMount.current) return;

    const params = new URLSearchParams();
    if (query) params.set('q', query);
    if (categories.length > 0) params.set('category', categories.join(','));
    if (minPrice !== null) params.set('min_price', String(minPrice));
    if (maxPrice !== null) params.set('max_price', String(maxPrice));
    if (sortBy !== 'newest') params.set('sort', sortBy);

    const queryString = params.toString();
    const url = queryString ? `${pathname}?${queryString}` : pathname;
    
    router.push(url, { scroll: false });
  }, [query, categories, minPrice, maxPrice, sortBy, pathname, router]);
}
