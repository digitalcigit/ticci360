'use client';

import { useState, useEffect, useMemo } from 'react';
import { useSearchParams } from 'next/navigation';
import { Product, Category, ApiResponse } from '@/types';
import { ProductList } from './ProductList';
import { Pagination } from './Pagination';
import { useFilterStore } from '@/features/search/store/filterStore';
import { useFilterSync } from '@/features/search/hooks/useFilterSync';
import { getProducts } from '@/lib/api/products';
import { Loader2 } from 'lucide-react';

interface ProductCatalogProps {
  initialProducts: Product[];
  initialMeta: ApiResponse<Product[]>['meta'];
  categories: Category[];
}

export function ProductCatalog({ 
  initialProducts, 
  initialMeta,
  categories 
}: ProductCatalogProps) {
  useFilterSync();
  const searchParams = useSearchParams();
  const { query, categories: selectedCategories, minPrice, maxPrice, sortBy } = useFilterStore();
  
  const [products, setProducts] = useState<Product[]>(initialProducts);
  const [meta, setMeta] = useState(initialMeta);
  const [isLoading, setIsLoading] = useState(false);
  
  const page = useMemo(() => {
    const p = searchParams.get('page');
    return p ? parseInt(p, 10) : 1;
  }, [searchParams]);

  // Initial load sync - only if store is empty (handled by useFilterSync mostly)
  
  useEffect(() => {
    // Skip fetching on initial mount if we already have the right data
    // But since filters might have been synced from URL by useFilterSync, 
    // we should probably fetch to be sure if any filter is active.
    
    const fetchFilteredProducts = async () => {
      setIsLoading(true);
      try {
        const result = await getProducts({
          page,
          per_page: 12,
          search: query,
          category_id: selectedCategories.join(',') as any,
          min_price: minPrice || undefined,
          max_price: maxPrice || undefined,
          sort: sortBy,
        });
        setProducts(result.data);
        setMeta(result.meta);
      } catch (error) {
        console.error('Failed to fetch filtered products:', error);
      } finally {
        setIsLoading(false);
      }
    };

    fetchFilteredProducts();
  }, [query, selectedCategories, minPrice, maxPrice, sortBy, page]);

  const totalPages = meta.pagination?.total_pages || 1;
  const total = meta.pagination?.total || products.length;

  return (
    <div className="space-y-6">
      <div className="flex items-center justify-between">
        <p className="text-sm text-gray-500 dark:text-gray-400">
          {total} produit{total > 1 ? 's' : ''} trouvé{total > 1 ? 's' : ''}
        </p>
        {isLoading && <Loader2 className="w-5 h-5 animate-spin text-blue-600" />}
      </div>

      <div className={isLoading ? 'opacity-50 pointer-events-none transition-opacity' : 'transition-opacity'}>
        <ProductList products={products} />
      </div>

      <Pagination 
        currentPage={page} 
        totalPages={totalPages} 
        basePath="/products" 
      />
    </div>
  );
}
