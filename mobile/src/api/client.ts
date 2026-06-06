import axios from 'axios';
import { API_BASE_URL } from '@/config/env';
import { getItem } from '@/lib/secureStore';

export const TOKEN_KEY = 'sm_auth_token';

export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: { Accept: 'application/json' },
  timeout: 20000,
});

// Attach the Bearer token to every request.
api.interceptors.request.use(async (config) => {
  const token = await getItem(TOKEN_KEY);
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Callback the AuthContext registers so a 401 anywhere forces a logout.
let onUnauthorized: (() => void) | null = null;
export const setUnauthorizedHandler = (fn: () => void) => {
  onUnauthorized = fn;
};

api.interceptors.response.use(
  (res) => res,
  (error) => {
    if (error?.response?.status === 401) {
      onUnauthorized?.();
    }
    return Promise.reject(error);
  },
);

/** Pull a human-readable message out of a Laravel JSON error response. */
export function apiErrorMessage(error: any): string {
  const data = error?.response?.data;
  if (data?.message) return data.message;
  if (data?.errors) {
    const first = Object.values(data.errors)[0];
    if (Array.isArray(first) && first[0]) return String(first[0]);
  }
  return error?.message ?? 'Something went wrong.';
}
