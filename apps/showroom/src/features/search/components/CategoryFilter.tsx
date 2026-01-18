'use client';

import { useFilterStore } from '../store/filterStore';
import { Category } from '@/types';

interface CategoryFilterProps {
  categories: Category[];
}

export function CategoryFilter({ categories }: CategoryFilterProps) {
  const { categories: selectedCategories, toggleCategory } = useFilterStore();

  return (
    <div className="space-y-2">
      <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
        Catégories
      </h3>
      <div className="space-y-1">
        {categories.map((category) => (
          <label key={category.id} className="flex items-center gap-3 cursor-pointer group">
            <input
              type="checkbox"
              className="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
              checked={selectedCategories.includes(category.slug)}
              onChange={() => toggleCategory(category.slug)}
            />
            <span className="text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 transition-colors">
              {category.name}
              {category.products_count > 0 && (
                <span className="ml-1 text-xs text-gray-400">({category.products_count})</span>
              )}
            </span>
          </label>
        ))}
      </div>
    </div>
  );
}
