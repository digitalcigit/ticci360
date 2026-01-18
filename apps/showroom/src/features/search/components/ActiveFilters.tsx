'use client';

import { useFilterStore } from '../store/filterStore';
import { X } from 'lucide-react';

export function ActiveFilters() {
  const { 
    categories, 
    toggleCategory, 
    minPrice, 
    maxPrice, 
    setPriceRange,
    reset 
  } = useFilterStore();

  const hasFilters = categories.length > 0 || minPrice !== null || maxPrice !== null;

  if (!hasFilters) return null;

  return (
    <div className="flex flex-wrap gap-2 mb-6">
      {categories.map((slug) => (
        <button
          key={slug}
          onClick={() => toggleCategory(slug)}
          className="flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100 rounded-full text-xs hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors"
        >
          Catégorie: {slug}
          <X className="w-3 h-3" />
        </button>
      ))}
      {(minPrice !== null || maxPrice !== null) && (
        <button
          onClick={() => setPriceRange(null, null)}
          className="flex items-center gap-1 px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100 rounded-full text-xs hover:bg-green-200 dark:hover:bg-green-800 transition-colors"
        >
          Prix: {minPrice || 0} - {maxPrice || 'max'} XOF
          <X className="w-3 h-3" />
        </button>
      )}
      <button
        onClick={reset}
        className="text-xs text-gray-500 hover:text-gray-900 dark:hover:text-gray-100 px-2 py-1 underline"
      >
        Effacer tout
      </button>
    </div>
  );
}
