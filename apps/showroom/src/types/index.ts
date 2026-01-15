export interface Product {
  id: number;
  name: string;
  slug?: string;
  sku: string;
  description: string;
  content: string;
  price: number;
  sale_price: number | null;
  final_price: number;
  is_on_sale: boolean;
  image: string | null;
  images: string[];
  stock_status: string;
  stock_status_label: string;
  quantity: number | null;
  categories: Category[];
  brand: Brand | null;
  tags: string[];
  expert_opinion?: string | null;
  created_at: string;
  updated_at: string;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string | null;
  image: string | null;
  parent_id: number;
  children: Category[];
  products_count: number;
}

export interface Brand {
  id: number;
  name: string;
}

export interface ApiResponse<T> {
  data: T;
  meta: {
    success: boolean;
    message: string;
    timestamp: string;
    pagination?: {
      total: number;
      count: number;
      per_page: number;
      current_page: number;
      total_pages: number;
      links: {
        next: string | null;
        previous: string | null;
      };
    };
  };
}
