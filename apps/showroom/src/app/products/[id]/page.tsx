import { fetchAPI } from '@/lib/api';
import { ApiResponse, Product } from '@/types';
import { ProductGallery } from '@/features/catalog/components/ProductGallery';
import { ProductInfo } from '@/features/catalog/components/ProductInfo';
import { Metadata } from 'next';
import { notFound } from 'next/navigation';

interface PageProps {
  params: Promise<{ id: string }>;
}

// Revalidate every 60 seconds
export const revalidate = 60;

async function getProduct(id: string) {
  try {
    const response = await fetchAPI<ApiResponse<Product>>(`products/${id}`, {
      next: { tags: [`product:${id}`] }
    });
    return response.data;
  } catch (error) {
    return null;
  }
}

export async function generateMetadata({ params }: PageProps): Promise<Metadata> {
  const { id } = await params;
  const product = await getProduct(id);

  if (!product) {
    return {
      title: 'Produit non trouvé',
    };
  }

  return {
    title: `${product.name} | TICCI Showroom`,
    description: product.description || `Achetez ${product.name} chez TICCI.`,
    alternates: {
      canonical: `/products/${product.id}`, // Should ideally be slug
    },
    openGraph: {
      images: product.image ? [product.image] : [],
    },
  };
}

export default async function ProductPage({ params }: PageProps) {
  const { id } = await params;
  const product = await getProduct(id);

  if (!product) {
    notFound();
  }

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <ProductGallery images={product.images.length > 0 ? product.images : (product.image ? [product.image] : [])} name={product.name} />
        <ProductInfo product={product} />
      </div>
    </div>
  );
}
