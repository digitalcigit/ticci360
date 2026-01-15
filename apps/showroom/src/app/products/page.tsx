import { fetchAPI } from '@/lib/api';
import { ApiResponse, Product } from '@/types';
import { ProductList } from '@/features/catalog/components/ProductList';
import { SearchBar } from '@/features/search/components/SearchBar';

// Force dynamic rendering for search params
export const dynamic = 'force-dynamic';

interface ProductsPageProps {
  searchParams: Promise<{ [key: string]: string | string[] | undefined }>;
}

async function getProducts(search?: string) {
  try {
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    
    const queryString = params.toString();
    const endpoint = queryString ? `products?${queryString}` : 'products';

    const response = await fetchAPI<ApiResponse<Product[]>>(endpoint, {
      next: { tags: ['products'] },
      cache: 'no-store' // Don't cache search results
    });
    return response.data;
  } catch (error) {
    console.error('Failed to fetch products:', error);
    return [];
  }
}

export default async function ProductsPage({ searchParams }: ProductsPageProps) {
  const { search } = await searchParams;
  const searchTerm = typeof search === 'string' ? search : undefined;
  const products = await getProducts(searchTerm);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
          Nos Produits
        </h1>
        <SearchBar />
      </div>
      
      <ProductList products={products} />
    </div>
  );
}
