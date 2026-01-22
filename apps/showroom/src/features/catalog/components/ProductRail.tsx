import { Product } from '@/types';
import { ProductCard } from './ProductCard';
import { Button } from '@/components/ui/button';
import Link from 'next/link';
import { ArrowRight } from 'lucide-react';

interface ProductRailProps {
  title: string;
  products: Product[];
  viewAllLink?: string;
}

export function ProductRail({ title, products, viewAllLink }: ProductRailProps) {
  if (!products.length) return null;

  return (
    <section className="py-12">
      <div className="flex items-center justify-between mb-8 px-1">
        <h2 className="text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
          {title}
        </h2>
        {viewAllLink && (
          <Button variant="ghost" className="text-primary hover:text-primary/80 hover:bg-primary/10 group" asChild>
            <Link href={viewAllLink}>
              Voir tout 
              <ArrowRight className="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1" />
            </Link>
          </Button>
        )}
      </div>
      
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {products.slice(0, 4).map((product) => (
          <ProductCard key={product.id} product={product} />
        ))}
      </div>
    </section>
  );
}
