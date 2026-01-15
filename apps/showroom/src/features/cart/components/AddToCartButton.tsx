'use client';

import { useCart } from '../hooks/useCart';
import { ShoppingCart, Loader2 } from 'lucide-react';
import { useState } from 'react';

interface AddToCartButtonProps {
  productId: number;
  stockStatus: string;
}

export function AddToCartButton({ productId, stockStatus }: AddToCartButtonProps) {
  const { addToCart } = useCart();
  const [isAdding, setIsAdding] = useState(false);

  const handleAddToCart = async () => {
    setIsAdding(true);
    try {
      await addToCart(productId, 1);
    } catch (error) {
      // Error handled by hook or global toast
    } finally {
      setIsAdding(false);
    }
  };

  const isOutOfStock = stockStatus !== 'in_stock';

  return (
    <button 
      className="w-full bg-black dark:bg-white text-white dark:text-black rounded-full py-3 font-semibold hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
      disabled={isOutOfStock || isAdding}
      onClick={handleAddToCart}
    >
      {isAdding ? (
        <Loader2 className="w-5 h-5 animate-spin" />
      ) : (
        <ShoppingCart className="w-5 h-5" />
      )}
      {isOutOfStock ? 'Rupture de stock' : 'Ajouter au panier'}
    </button>
  );
}
