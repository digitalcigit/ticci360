import { Product } from '@/types';
import { AddToCartButton } from '@/features/cart/components/AddToCartButton';

interface ProductInfoProps {
  product: Product;
}

export function ProductInfo({ product }: ProductInfoProps) {
  return (
    <div className="flex flex-col gap-6">
      <div>
        <h1 className="text-3xl font-bold text-gray-900 dark:text-gray-100">{product.name}</h1>
        <div className="mt-2 flex items-center gap-4">
          <p className="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(product.final_price)}
          </p>
          {product.is_on_sale && (
            <p className="text-lg text-gray-500 line-through">
              {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(product.price)}
            </p>
          )}
        </div>
        <div className="mt-2 flex items-center gap-2">
          <span className={`text-sm font-medium px-2 py-0.5 rounded ${
            product.stock_status === 'in_stock' 
              ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' 
              : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
          }`}>
            {product.stock_status_label}
          </span>
          {product.sku && <span className="text-sm text-gray-500">REF: {product.sku}</span>}
        </div>
      </div>

      <div className="prose dark:prose-invert text-gray-600 dark:text-gray-300">
        <p>{product.description}</p>
      </div>

      {/* Expert Opinion Section - Story 4.2 */}
      {product.expert_opinion && (
        <div className="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-md">
          <h3 className="text-blue-800 dark:text-blue-200 font-bold flex items-center gap-2 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-5 h-5">
              <path strokeLinecap="round" strokeLinejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
            </svg>
            L'avis de l'ingénieur
          </h3>
          <p className="text-blue-900 dark:text-blue-100 text-sm italic">
            "{product.expert_opinion}"
          </p>
        </div>
      )}

      <div className="border-t border-gray-200 dark:border-gray-800 pt-6">
        <div className="flex flex-col gap-4">
          <AddToCartButton productId={product.id} stockStatus={product.stock_status} />
        </div>
      </div>

      {product.content && (
        <div className="border-t border-gray-200 dark:border-gray-800 pt-6">
          <h3 className="text-lg font-bold mb-2">Description détaillée</h3>
          <div 
            className="prose dark:prose-invert max-w-none"
            dangerouslySetInnerHTML={{ __html: product.content }} 
          />
        </div>
      )}
    </div>
  );
}
