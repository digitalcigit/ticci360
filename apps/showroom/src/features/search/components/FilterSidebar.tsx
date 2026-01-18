'use client';

import { CategoryFilter } from './CategoryFilter';
import { PriceRangeFilter } from './PriceRangeFilter';
import { useFilterStore } from '../store/filterStore';
import { Category } from '@/types';
import { X } from 'lucide-react';

interface FilterSidebarProps {
  categories: Category[];
}

export function FilterSidebar({ categories }: FilterSidebarProps) {
  const { reset, categories: selectedCategories, minPrice, maxPrice } = useFilterStore();
  const hasActiveFilters = selectedCategories.length > 0 || minPrice !== null || maxPrice !== null;

  return (
    <aside className="w-full space-y-8 sticky top-24">
      <div className="flex items-center justify-between">
        <h2 className="text-lg font-bold text-gray-900 dark:text-gray-100">Filtres</h2>
        {hasActiveFilters && (
          <button
            onClick={reset}
            className="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 flex items-center gap-1"
          >
            <X className="w-3 h-3" />
            Réinitialiser
          </button>
        )}
      </div>

      <CategoryFilter categories={categories} />
      <div className="border-t border-gray-200 dark:border-zinc-800 pt-8">
        <PriceRangeFilter />
      </div>
    </aside>
  );
}
