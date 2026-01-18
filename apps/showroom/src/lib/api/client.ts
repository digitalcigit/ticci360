const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8081/api/v1';

interface FetchOptions extends RequestInit {
  next?: {
    revalidate?: number;
    tags?: string[];
  };
}

export async function apiClient<T>(
  endpoint: string,
  options: FetchOptions = {}
): Promise<T> {
  const url = `${API_BASE_URL}/${endpoint.replace(/^\//, '')}`;

  const defaultOptions: FetchOptions = {
    headers: {
      'Content-Type': 'application/json',
      Accept: 'application/json',
    },
    credentials: 'include',
    ...options,
  };

  const res = await fetch(url, defaultOptions);

  if (!res.ok) {
    throw new Error(`API Error: ${res.status} ${res.statusText}`);
  }

  return res.json();
}

export { API_BASE_URL };
