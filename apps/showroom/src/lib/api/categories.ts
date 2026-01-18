import { apiClient } from './client';
import { ApiResponse, Category } from '@/types';

export interface CategoriesParams {
  tree?: boolean;
}

export async function getCategories(
  params: CategoriesParams = { tree: true },
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<Category[]> {
  const searchParams = new URLSearchParams();
  if (params.tree !== undefined) searchParams.append('tree', String(params.tree));

  const queryString = searchParams.toString();
  const endpoint = queryString ? `categories?${queryString}` : 'categories';

  const response = await apiClient<ApiResponse<Category[]>>(endpoint, {
    next: {
      tags: options.tags || ['categories'],
      revalidate: options.revalidate ?? 3600, // 1 hour default for categories
    },
  });

  return response.data;
}

export async function getCategoryById(
  id: number,
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<Category | null> {
  try {
    const response = await apiClient<ApiResponse<Category>>(`categories/${id}`, {
      next: {
        tags: options.tags || [`category:${id}`],
        revalidate: options.revalidate ?? 3600,
      },
    });
    return response.data;
  } catch {
    return null;
  }
}

export async function getCategoryBySlug(
  slug: string,
  options: { tags?: string[]; revalidate?: number } = {}
): Promise<Category | null> {
  // Note: Current API may not support slug lookup directly
  // This is a placeholder - may need backend enhancement
  try {
    const categories = await getCategories({ tree: false }, options);
    return categories.find((c) => c.slug === slug) || null;
  } catch {
    return null;
  }
}
