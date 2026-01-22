import { getSliders } from '@/lib/api/sliders';
import { getFeaturedBrands } from '@/lib/api/brands';
import { getProducts } from '@/lib/api/products';
import { HeroSlider } from '@/components/ui/hero-slider';
import { TrustBar } from '@/components/ui/trust-bar';
import { ProductRail } from '@/features/catalog/components/ProductRail';
import { BrandsRail } from '@/components/ui/brands-rail';
import { B2BSection } from '@/components/ui/b2b-section';

export const revalidate = 3600; // Revalidate every hour

export default async function Home() {
  // Fetch data in parallel
  const [
    slides, 
    brands, 
    newProducts, 
    // featuredProducts 
  ] = await Promise.all([
    getSliders('home-slider'),
    getFeaturedBrands(12),
    getProducts({ sort: 'created_at-desc', per_page: 8 }),
    // getProducts({ sort: 'views-desc', per_page: 8 }) // Example for "Featured"/Popular
  ]);

  return (
    <div className="flex flex-col min-h-screen bg-zinc-50 dark:bg-zinc-950">
      {/* Hero Section with Slider */}
      <section className="relative">
        <HeroSlider slides={slides} />
      </section>

      {/* Trust Indicators */}
      <TrustBar />

      {/* New Arrivals Rail */}
      <div className="container px-4 md:px-6">
        <ProductRail 
          title="Nouveautés" 
          products={newProducts.data} 
          viewAllLink="/products?sort=created_at-desc" 
        />
      </div>

      {/* B2B / Services Section */}
      <B2BSection />

      {/* Brands Partners */}
      <BrandsRail brands={brands} />
    </div>
  );
}
