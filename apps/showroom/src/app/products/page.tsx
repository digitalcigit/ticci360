import { Metadata } from 'next';
import { Suspense } from 'react';
import { getProducts } from '@/lib/api/products';
import { getCategories } from '@/lib/api/categories';
import { ProductCatalog } from '@/features/catalog/components/ProductCatalog';
import { SearchBar } from '@/features/search/components/SearchBar';
import { FilterSidebar } from '@/features/search/components/FilterSidebar';
import { ActiveFilters } from '@/features/search/components/ActiveFilters';

export const metadata: Metadata = {
  title: 'Nos Produits | TICCI - Matériel Informatique en Côte d\'Ivoire',
  description: 'Découvrez notre catalogue de matériel informatique de qualité professionnelle. Ordinateurs, serveurs, accessoires et plus encore. Livraison en Côte d\'Ivoire.',
  openGraph: {
    title: 'Nos Produits | TICCI',
    description: 'Catalogue de matériel informatique professionnel en Côte d\'Ivoire',
    type: 'website',
    locale: 'fr_CI',
  },
};

interface ProductsPageProps {
  searchParams: Promise<{ [key: string]: string | string[] | undefined }>;
}

export default async function ProductsPage({ searchParams }: ProductsPageProps) {
  const params = await searchParams;
  const page = typeof params.page === 'string' ? parseInt(params.page, 10) : 1;
  const search = typeof params.search === 'string' ? params.search : undefined;

  // Fetch initial data for SSR
  const [productsData, categories] = await Promise.all([
    getProducts(
      { page, per_page: 12, search },
      { tags: ['products'], revalidate: 60 }
    ),
    getCategories({ tree: true })
  ]);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <h1 className="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
          Nos Produits
        </h1>
        <Suspense fallback={<div className="w-full md:w-64 h-10 bg-gray-200 rounded animate-pulse" />}>
          <SearchBar />
        </Suspense>
      </div>

      <div className="flex flex-col lg:grid lg:grid-cols-4 gap-8">
        {/* Desktop Sidebar */}
        <div className="hidden lg:block lg:col-span-1">
          <Suspense fallback={<div className="space-y-4 animate-pulse"><div className="h-8 bg-gray-200 rounded w-1/2"></div><div className="h-32 bg-gray-200 rounded"></div></div>}>
            <FilterSidebar categories={categories} />
          </Suspense>
        </div>

        {/* Main Content */}
        <div className="lg:col-span-3">
          <Suspense fallback={null}>
            <ActiveFilters />
          </Suspense>
          
          <ProductCatalog 
            initialProducts={productsData.data} 
            initialMeta={productsData.meta}
            categories={categories}
          />
        </div>
      </div>
    </div>
  );
}

