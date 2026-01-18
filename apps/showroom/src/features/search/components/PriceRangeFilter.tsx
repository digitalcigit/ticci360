'use client';

import { useState, useEffect } from 'react';
import { useFilterStore } from '../store/filterStore';

export function PriceRangeFilter() {
  const { minPrice, maxPrice, setPriceRange } = useFilterStore();
  const [min, setMin] = useState(minPrice?.toString() || '');
  const [max, setMax] = useState(maxPrice?.toString() || '');

  useEffect(() => {
    setMin(minPrice?.toString() || '');
    setMax(maxPrice?.toString() || '');
  }, [minPrice, maxPrice]);

  const handleApply = () => {
    const minVal = min ? Number(min) : null;
    const maxVal = max ? Number(max) : null;
    setPriceRange(minVal, maxVal);
  };

  const handleReset = () => {
    setMin('');
    setMax('');
    setPriceRange(null, null);
  };

  return (
    <div className="space-y-4">
      <h3 className="text-sm font-semibold text-gray-900 dark:text-gray-100 uppercase tracking-wider">
        Prix (XOF)
      </h3>
      <div className="grid grid-cols-2 gap-2">
        <div>
          <label htmlFor="min-price" className="sr-only">Prix Min</label>
          <input
            type="number"
            id="min-price"
            placeholder="Min"
            className="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-100"
            value={min}
            onChange={(e) => setMin(e.target.value)}
          />
        </div>
        <div>
          <label htmlFor="max-price" className="sr-only">Prix Max</label>
          <input
            type="number"
            id="max-price"
            placeholder="Max"
            className="block w-full px-3 py-2 border border-gray-300 rounded-md text-sm dark:bg-zinc-800 dark:border-zinc-700 dark:text-gray-100"
            value={max}
            onChange={(e) => setMax(e.target.value)}
          />
        </div>
      </div>
      <div className="flex gap-2">
        <button
          onClick={handleApply}
          className="flex-1 px-3 py-2 bg-black text-white dark:bg-white dark:text-black rounded-md text-xs font-medium hover:opacity-80 transition-opacity"
        >
          Appliquer
        </button>
        <button
          onClick={handleReset}
          className="px-3 py-2 border border-gray-300 rounded-md text-xs font-medium hover:bg-gray-50 dark:border-zinc-700 dark:hover:bg-zinc-800 transition-colors"
        >
          Reset
        </button>
      </div>
    </div>
  );
}
