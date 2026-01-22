import { apiClient } from './client';

export interface Brand {
  id: number;
  name: string;
  website?: string | null;
  logo?: string | null;
  description?: string | null;
}

export interface BrandResponse {
  data: Brand[];
}

export const getFeaturedBrands = async (limit: number = 10): Promise<Brand[]> => {
  try {
    const query = new URLSearchParams({ 
      featured: '1',
      limit: limit.toString() 
    }).toString();
    
    const response = await apiClient<BrandResponse>(`brands?${query}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching brands:', error);
    return [];
  }
};
