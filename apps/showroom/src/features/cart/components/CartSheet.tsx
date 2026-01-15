'use client';

import { useCart } from '../hooks/useCart';
import Image from 'next/image';
import Link from 'next/link';
import { X, Minus, Plus, ShoppingBag, Trash2 } from 'lucide-react';
import { useEffect } from 'react';
import { CONFIG } from '@/lib/config';

export function CartSheet() {
  const { 
    isOpen, 
    closeCart, 
    items, 
    total, 
    isLoading, 
    fetchCart, 
    removeItem, 
    updateItem 
  } = useCart();

  useEffect(() => {
    fetchCart();
  }, [fetchCart]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex justify-end">
      {/* Backdrop */}
      <div 
        className="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" 
        onClick={closeCart}
      />

      {/* Drawer */}
      <div className="relative w-full max-w-md bg-white dark:bg-zinc-900 shadow-xl flex flex-col h-full animate-in slide-in-from-right duration-300">
        <div className="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
          <h2 className="text-lg font-semibold flex items-center gap-2">
            <ShoppingBag className="w-5 h-5" />
            Mon Panier
          </h2>
          <button 
            onClick={closeCart}
            className="p-2 hover:bg-gray-100 dark:hover:bg-zinc-800 rounded-full transition-colors"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        <div className="flex-1 overflow-y-auto p-4 space-y-4">
          {items.length === 0 ? (
            <div className="flex flex-col items-center justify-center h-full text-gray-500 gap-4">
              <ShoppingBag className="w-12 h-12 opacity-20" />
              <p>Votre panier est vide</p>
              <button 
                onClick={closeCart}
                className="text-primary hover:underline"
              >
                Continuer mes achats
              </button>
            </div>
          ) : (
            items.map((item) => (
              <div key={item.rowId} className="flex gap-4 border-b border-gray-100 dark:border-zinc-800 pb-4 last:border-0">
                <div className="relative w-20 h-20 bg-gray-100 rounded-md overflow-hidden flex-shrink-0">
                  {item.image ? (
                    <Image
                      src={item.image}
                      alt={item.name}
                      fill
                      className="object-cover"
                    />
                  ) : (
                    <div className="w-full h-full flex items-center justify-center text-xs text-gray-400">No Img</div>
                  )}
                </div>
                <div className="flex-1 flex flex-col justify-between">
                  <div className="flex justify-between items-start gap-2">
                    <h3 className="font-medium text-sm line-clamp-2">
                      <Link href={`/products/${item.id}`} onClick={closeCart} className="hover:underline">
                        {item.name}
                      </Link>
                    </h3>
                    <button 
                      onClick={() => removeItem(item.rowId)}
                      className="text-gray-400 hover:text-red-500 transition-colors"
                      disabled={isLoading}
                    >
                      <Trash2 className="w-4 h-4" />
                    </button>
                  </div>
                  <div className="flex justify-between items-end">
                    <div className="flex items-center border border-gray-200 dark:border-zinc-700 rounded-md">
                      <button 
                        onClick={() => updateItem(item.rowId, Math.max(1, item.qty - 1))}
                        className="p-1 hover:bg-gray-50 dark:hover:bg-zinc-800 disabled:opacity-50"
                        disabled={isLoading || item.qty <= 1}
                      >
                        <Minus className="w-3 h-3" />
                      </button>
                      <span className="w-8 text-center text-sm">{item.qty}</span>
                      <button 
                        onClick={() => updateItem(item.rowId, item.qty + 1)}
                        className="p-1 hover:bg-gray-50 dark:hover:bg-zinc-800 disabled:opacity-50"
                        disabled={isLoading}
                      >
                        <Plus className="w-3 h-3" />
                      </button>
                    </div>
                    <div className="text-right">
                      <p className="font-semibold text-sm">
                        {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(item.price * item.qty)}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            ))
          )}
        </div>

        {items.length > 0 && (
          <div className="p-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-zinc-900">
            <div className="flex justify-between items-center mb-4">
              <span className="text-gray-600 dark:text-gray-400">Total</span>
              <span className="text-xl font-bold">
                {new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF' }).format(total)}
              </span>
            </div>
            <a 
              href="http://localhost:8081/checkout" // Legacy Checkout URL (Epic 3.3) - Needs config
              className="block w-full bg-black dark:bg-white text-white dark:text-black text-center py-3 rounded-full font-bold hover:opacity-90 transition-opacity"
            >
              Commander
            </a>
          </div>
        )}
      </div>
    </div>
  );
}
