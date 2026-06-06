import {
  useQuery,
  useMutation,
  useQueryClient,
} from '@tanstack/react-query';
import { api } from './client';

/**
 * Generic CRUD hooks keyed by a module's REST endpoint (e.g. "departments").
 * The API wraps payloads as { success, message, data }, so we unwrap `.data`.
 */

const unwrap = (res: any) => res?.data?.data ?? res?.data;

export function useList(endpoint: string) {
  return useQuery({
    queryKey: [endpoint],
    queryFn: async () => unwrap(await api.get(`/${endpoint}`)),
  });
}

export function useItem(endpoint: string, id?: number | string) {
  return useQuery({
    queryKey: [endpoint, id],
    enabled: id != null,
    queryFn: async () => unwrap(await api.get(`/${endpoint}/${id}`)),
  });
}

export function useSave(endpoint: string, id?: number | string) {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: async (payload: Record<string, any>) => {
      const res = id
        ? await api.put(`/${endpoint}/${id}`, payload)
        : await api.post(`/${endpoint}`, payload);
      return unwrap(res);
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: [endpoint] });
    },
  });
}

export function useRemove(endpoint: string) {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: async (id: number | string) => {
      await api.delete(`/${endpoint}/${id}`);
    },
    onSuccess: () => {
      qc.invalidateQueries({ queryKey: [endpoint] });
    },
  });
}
