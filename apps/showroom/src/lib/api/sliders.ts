import { apiClient } from './client';

export interface SliderItem {
  id: number;
  title: string;
  image: string;
  tablet_image?: string | null;
  mobile_image?: string | null;
  link?: string | null;
  description?: string | null;
  order: number;
}

export interface SliderResponse {
  data: SliderItem[];
}

export const getSliders = async (key: string = 'home-slider'): Promise<SliderItem[]> => {
  try {
    // Construct query string manually since apiClient is simple
    const query = new URLSearchParams({ key }).toString();
    const response = await apiClient<SliderResponse>(`sliders?${query}`);
    return response.data;
  } catch (error) {
    console.error('Error fetching sliders:', error);
    return [];
  }
};
