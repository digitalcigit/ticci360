import { apiClient } from './client';
import { ApiResponse, Product } from '@/types';

export interface ProductsParams {
  page?: number;
  per_page?: number;
  category_id?: number;
  search?: string;
  q?: string;
  min_price?: number;
  max_price?: number;
  sort?: string;
}

export interface PaginatedProducts {
  data: Product[];
  meta: ApiResponse<Product[]>['meta'];
}

export async function getProducts(
  params: ProductsParams = {},
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<PaginatedProducts> {
  const searchParams = new URLSearchParams();

  if (params.page) searchParams.append('page', String(params.page));
  if (params.per_page) searchParams.append('per_page', String(params.per_page));
  if (params.category_id) searchParams.append('category_id', String(params.category_id));
  if (params.search) searchParams.append('search', params.search);
  if (params.q) searchParams.append('search', params.q);
  if (params.min_price) searchParams.append('min_price', String(params.min_price));
  if (params.max_price) searchParams.append('max_price', String(params.max_price));
  if (params.sort) searchParams.append('sort', params.sort);
  
  // Support for multiple categories (comma separated from store)
  if (typeof params.category_id === 'string') {
    searchParams.append('categories', params.category_id);
  }

  const queryString = searchParams.toString();
  const endpoint = queryString ? `products?${queryString}` : 'products';

  try {
    const response = await apiClient<ApiResponse<Product[]>>(endpoint, {
      next: {
        tags: options.tags || ['products'],
        revalidate: options.revalidate,
      },
    });

    return {
      data: response.data,
      meta: response.meta,
    };
  } catch (error) {
    console.error('Error fetching products:', error);
    return {
      data: [],
      meta: {
        success: false,
        message: 'Error fetching products',
        timestamp: new Date().toISOString(),
        pagination: {
          total: 0,
          count: 0,
          per_page: params.per_page || 12,
          current_page: params.page || 1,
          total_pages: 0,
          links: { next: null, previous: null }
        }
      }
    };
  }
}

export async function getProductBySlug(
  slug: string,
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<Product | null> {
  try {
    const response = await apiClient<ApiResponse<Product>>(`products/${slug}`, {
      next: {
        tags: options.tags || [`product:${slug}`],
        revalidate: options.revalidate,
      },
    });
    return response.data;
  } catch {
    return null;
  }
}

export async function getProductById(
  id: number,
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<Product | null> {
  try {
    const response = await apiClient<ApiResponse<Product>>(`products/${id}`, {
      next: {
        tags: options.tags || [`product:${id}`],
        revalidate: options.revalidate,
      },
    });
    return response.data;
  } catch {
    return null;
  }
}
