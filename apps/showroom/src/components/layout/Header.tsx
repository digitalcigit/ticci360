'use client';

import Link from 'next/link';
import { ShoppingBag } from 'lucide-react';
import { useCart } from '@/features/cart/hooks/useCart';
import { useEffect } from 'react';

export function Header() {
  const { count, toggleCart, fetchCart } = useCart();

  useEffect(() => {
    fetchCart();
  }, [fetchCart]);

  return (
    <header className="sticky top-0 z-40 w-full border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
        <Link href="/" className="font-bold text-xl">
          TICCI
        </Link>

        <nav className="flex items-center gap-6">
          <Link href="/products" className="text-sm font-medium hover:underline underline-offset-4">
            Catalogue
          </Link>
          <Link href="/quote" className="text-sm font-medium hover:underline underline-offset-4 text-blue-600 dark:text-blue-400">
            Espace PRO
          </Link>
          
          <button  
            onClick={toggleCart}
            className="relative p-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-full transition-colors"
            aria-label="Ouvrir le panier"
          >
            <ShoppingBag className="w-5 h-5" />
            {count > 0 && (
              <span className="absolute -top-1 -right-1 w-5 h-5 bg-black dark:bg-white text-white dark:text-black text-xs font-bold rounded-full flex items-center justify-center">
                {count}
              </span>
            )}
          </button>
        </nav>
      </div>
    </header>
  );
}
