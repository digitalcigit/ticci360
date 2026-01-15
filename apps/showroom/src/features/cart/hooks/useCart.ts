import { create } from 'zustand';
import { fetchAPI } from '@/lib/api';
import { ApiResponse } from '@/types';

export interface CartItem {
  rowId: string;
  id: number;
  name: string;
  qty: number;
  price: number;
  subtotal: number;
  image: string | null;
  product_link: string | null;
}

interface CartState {
  items: CartItem[];
  count: number;
  sub_total: number;
  total: number;
  isOpen: boolean;
  isLoading: boolean;
  
  // Actions
  openCart: () => void;
  closeCart: () => void;
  toggleCart: () => void;
  fetchCart: () => Promise<void>;
  addToCart: (productId: number, qty?: number) => Promise<void>;
  removeItem: (rowId: string) => Promise<void>;
  updateItem: (rowId: string, qty: number) => Promise<void>;
}

interface CartResponse {
  items: CartItem[];
  count: number;
  sub_total: number;
  total: number;
}

export const useCart = create<CartState>((set, get) => ({
  items: [],
  count: 0,
  sub_total: 0,
  total: 0,
  isOpen: false,
  isLoading: false,

  openCart: () => set({ isOpen: true }),
  closeCart: () => set({ isOpen: false }),
  toggleCart: () => set((state) => ({ isOpen: !state.isOpen })),

  fetchCart: async () => {
    set({ isLoading: true });
    try {
      // Note: This requires credentials (cookies) to work for the session
      // We assume fetchAPI handles this via credentials: 'include' if configured,
      // but standard fetch doesn't default to it. 
      // We updated cors.php to allow credentials, so we need to ensure fetchAPI sends them.
      // *Correction*: api.ts needs 'credentials: include'.
      const res = await fetchAPI<ApiResponse<CartResponse>>('cart', { credentials: 'include' });
      set({
        items: res.data.items,
        count: res.data.count,
        sub_total: res.data.sub_total,
        total: res.data.total,
        isLoading: false,
      });
    } catch (error) {
      console.error('Fetch cart error:', error);
      set({ isLoading: false });
    }
  },

  addToCart: async (productId, qty = 1) => {
    set({ isLoading: true });
    try {
      await fetchAPI('cart', {
        method: 'POST',
        body: JSON.stringify({ id: productId, qty }),
        credentials: 'include',
      });
      await get().fetchCart();
      set({ isOpen: true }); // Open cart on add
    } catch (error) {
      console.error('Add to cart error:', error);
      set({ isLoading: false });
      throw error; // Let component handle error toast
    }
  },

  removeItem: async (rowId) => {
    set({ isLoading: true });
    try {
      await fetchAPI(`cart/${rowId}`, {
        method: 'DELETE',
        credentials: 'include',
      });
      await get().fetchCart();
    } catch (error) {
      console.error('Remove item error:', error);
      set({ isLoading: false });
    }
  },

  updateItem: async (rowId, qty) => {
    set({ isLoading: true });
    try {
      await fetchAPI('cart', {
        method: 'PUT',
        body: JSON.stringify({
          items: [{ rowId, values: { qty } }]
        }),
        credentials: 'include',
      });
      await get().fetchCart();
    } catch (error) {
      console.error('Update item error:', error);
      set({ isLoading: false });
    }
  },
}));
