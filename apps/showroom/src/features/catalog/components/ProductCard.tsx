import Image from 'next/image';
import Link from 'next/link';
import { Product } from '@/types';

interface ProductCardProps {
  product: Product;
}

export function ProductCard({ product }: ProductCardProps) {
  return (
    <div className="group relative border rounded-lg p-4 hover:shadow-lg transition-shadow bg-white dark:bg-zinc-900">
      <div className="aspect-square relative overflow-hidden rounded-md bg-gray-200 mb-4">
        {product.image ? (
          <Image
            src={product.image}
            alt={product.name}
            fill
            className="object-cover object-center group-hover:scale-105 transition-transform"
            sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw"
          />
        ) : (
          <div className="flex items-center justify-center h-full text-gray-400">No Image</div>
        )}
        {product.is_on_sale && (
          <span className="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold px-2 py-1 rounded">
            PROMO
          </span>
        )}
      </div>
      
      <div className="flex justify-between items-start">
        <div>
          <h3 className="text-sm font-medium text-gray-900 dark:text-gray-100">
            <Link href={`/products/${product.slug || product.id}`}>
              <span aria-hidden="true" className="absolute inset-0" />
              {product.name}
            </Link>
          </h3>
          <p className="mt-1 text-sm text-gray-500 dark:text-gray-400">{product.brand?.name}</p>
        </div>
        <div className="text-right">
          <p className="text-sm font-medium text-gray-900 dark:text-gray-100">
            {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(product.final_price)}
          </p>
          {product.is_on_sale && (
            <p className="text-xs text-gray-500 line-through">
              {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(product.price)}
            </p>
          )}
        </div>
      </div>
      
      <div className="mt-2">
        <span className={`text-xs font-medium px-2 py-0.5 rounded ${
          product.stock_status === 'in_stock' 
            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
            : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
        }`}>
          {product.stock_status_label}
        </span>
      </div>
    </div>
  );
}
