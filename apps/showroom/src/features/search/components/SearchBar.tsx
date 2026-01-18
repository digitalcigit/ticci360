'use client';

import { useDebouncedCallback } from 'use-debounce';
import { useFilterStore } from '../store/filterStore';
import { Search } from 'lucide-react';

export function SearchBar() {
  const { query, setQuery } = useFilterStore();

  const debouncedSetQuery = useDebouncedCallback((value: string) => {
    setQuery(value);
  }, 300);

  return (
    <div className="relative w-full max-w-md">
      <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <Search className="h-5 w-5 text-gray-400" />
      </div>
      <input
        type="text"
        className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-zinc-800 dark:border-zinc-700 placeholder-gray-500 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        placeholder="Rechercher des produits..."
        defaultValue={query}
        onChange={(e) => debouncedSetQuery(e.target.value)}
      />
    </div>
  );
}
