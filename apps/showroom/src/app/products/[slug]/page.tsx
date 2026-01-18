import { Metadata } from 'next';
import { notFound } from 'next/navigation';
import Script from 'next/script';
import { getProductBySlug, getProducts } from '@/lib/api/products';
import { ProductGallery } from '@/features/catalog/components/ProductGallery';
import { ProductInfo } from '@/features/catalog/components/ProductInfo';
import { generateProductJsonLd } from '@/lib/seo/product-jsonld';

interface PageProps {
  params: Promise<{ slug: string }>;
}

// Revalidate every 60 seconds
export const revalidate = 60;

// Generate static params for the first page of products to improve initial load
export async function generateStaticParams() {
  try {
    const { data: products } = await getProducts({ per_page: 20 });
    return products
      .filter((p) => p.slug)
      .map((p) => ({
        slug: p.slug as string,
      }));
  } catch (error) {
    console.error('Failed to generate static params:', error);
    return [];
  }
}

export async function generateMetadata({ params }: PageProps): Promise<Metadata> {
  const { slug } = await params;
  const product = await getProductBySlug(slug);

  if (!product) {
    return {
      title: 'Produit non trouvé | TICCI',
    };
  }

  const baseUrl = process.env.NEXT_PUBLIC_BASE_URL || 'https://staging.tic.ci';
  const canonicalBaseUrl = process.env.NEXT_PUBLIC_CANONICAL_BASE_URL || 'https://www.tic.ci';

  return {
    title: `${product.name} | TICCI`,
    description: product.description || `Achetez ${product.name} chez TICCI. Qualité professionnelle garantie.`,
    alternates: {
      canonical: `${canonicalBaseUrl}/products/${product.slug || product.id}`,
    },
    openGraph: {
      title: product.name,
      description: product.description,
      type: 'website',
      url: `${baseUrl}/products/${product.slug || product.id}`,
      images: product.image ? [{ url: product.image, alt: product.name }] : [],
    },
    twitter: {
      card: 'summary_large_image',
      title: product.name,
      description: product.description,
      images: product.image ? [product.image] : [],
    },
  };
}

export default async function ProductPage({ params }: PageProps) {
  const { slug } = await params;
  const product = await getProductBySlug(slug);

  if (!product) {
    notFound();
  }

  const baseUrl = process.env.NEXT_PUBLIC_BASE_URL || 'https://staging.tic.ci';
  const jsonLd = generateProductJsonLd(product, baseUrl);

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <Script
        id="product-jsonld"
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(jsonLd) }}
      />
      
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div className="w-full">
          <ProductGallery 
            images={product.images.length > 0 ? product.images : (product.image ? [product.image] : [])} 
            name={product.name} 
          />
        </div>
        <div className="w-full">
          <ProductInfo product={product} />
        </div>
      </div>
    </div>
  );
}
