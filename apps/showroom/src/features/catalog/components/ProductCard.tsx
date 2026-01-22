import Image from 'next/image';
import Link from 'next/link';
import { Product } from '@/types';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ShoppingCart } from 'lucide-react';

interface ProductCardProps {
  product: Product;
}

export function ProductCard({ product }: ProductCardProps) {
  return (
    <Card className="group h-full flex flex-col overflow-hidden hover:shadow-lg transition-all duration-300 border-zinc-200 dark:border-zinc-800">
      <div className="relative aspect-square bg-gray-100 dark:bg-zinc-800 overflow-hidden">
        {product.image ? (
          <Image
            src={product.image}
            alt={product.name}
            fill
            className="object-cover object-center group-hover:scale-105 transition-transform duration-500"
            sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 25vw"
          />
        ) : (
          <div className="flex items-center justify-center h-full text-gray-400">No Image</div>
        )}
        
        {/* Badges Overlay */}
        <div className="absolute top-2 left-2 flex flex-col gap-1">
          {product.is_on_sale && (
            <Badge variant="destructive" className="font-bold shadow-sm">
              PROMO
            </Badge>
          )}
          {product.stock_status === 'in_stock' ? (
             <Badge variant="secondary" className="bg-green-500/90 hover:bg-green-500 text-white shadow-sm backdrop-blur-sm">
               En stock
             </Badge>
          ) : (
            <Badge variant="outline" className="bg-white/90 text-zinc-600 backdrop-blur-sm">
              Sur commande
            </Badge>
          )}
        </div>
      </div>
      
      <CardHeader className="p-4 pb-0">
        <div className="text-xs text-muted-foreground mb-1 uppercase tracking-wider font-semibold">
          {product.brand?.name || 'Générique'}
        </div>
        <Link href={`/products/${product.slug || product.id}`} className="group-hover:text-primary transition-colors">
          <h3 className="font-semibold leading-tight line-clamp-2 min-h-[2.5rem]" title={product.name}>
            {product.name}
          </h3>
        </Link>
      </CardHeader>
      
      <CardContent className="p-4 pt-2 flex-grow flex flex-col justify-end">
        <div className="flex items-baseline gap-2">
          <span className="text-lg font-bold text-primary">
            {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF', maximumFractionDigits: 0 }).format(product.final_price)}
          </span>
          {product.is_on_sale && (
            <span className="text-sm text-muted-foreground line-through decoration-destructive/50">
              {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF', maximumFractionDigits: 0 }).format(product.price)}
            </span>
          )}
        </div>
      </CardContent>

      <CardFooter className="p-4 pt-0">
        <Button className="w-full gap-2" size="sm">
          <ShoppingCart className="h-4 w-4" />
          Ajouter
        </Button>
      </CardFooter>
    </Card>
  );
}
