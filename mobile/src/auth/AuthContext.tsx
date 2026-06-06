import React, {
  createContext,
  useContext,
  useEffect,
  useState,
  useCallback,
} from 'react';
import { getItem, setItem, deleteItem } from '@/lib/secureStore';
import { api, TOKEN_KEY, setUnauthorizedHandler } from '@/api/client';

export interface AuthUser {
  id: number;
  name: string;
  email: string;
  phone?: string | null;
  is_staff: boolean;
  role: string | null;
  permissions: string[];
}

interface AuthContextValue {
  user: AuthUser | null;
  token: string | null;
  loading: boolean;
  signIn: (email: string, password: string) => Promise<void>;
  signOut: () => Promise<void>;
  can: (permission: string) => boolean;
}

const AuthContext = createContext<AuthContextValue>({} as AuthContextValue);

export const useAuth = () => useContext(AuthContext);

export function AuthProvider({ children }: { children: React.ReactNode }) {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);

  const signOut = useCallback(async () => {
    try {
      await api.post('/logout');
    } catch {
      // ignore — we clear local state regardless
    }
    await deleteItem(TOKEN_KEY);
    setToken(null);
    setUser(null);
  }, []);

  // Wire 401 -> signOut once.
  useEffect(() => {
    setUnauthorizedHandler(() => {
      void signOut();
    });
  }, [signOut]);

  // Restore session on launch.
  useEffect(() => {
    (async () => {
      try {
        const saved = await getItem(TOKEN_KEY);
        if (saved) {
          setToken(saved);
          const { data } = await api.get('/me');
          setUser(data.user);
        }
      } catch {
        await deleteItem(TOKEN_KEY);
      } finally {
        setLoading(false);
      }
    })();
  }, []);

  const signIn = useCallback(async (email: string, password: string) => {
    const { data } = await api.post('/login', {
      email,
      password,
      device_name: 'mobile',
    });
    await setItem(TOKEN_KEY, data.token);
    setToken(data.token);
    setUser(data.user);
  }, []);

  const can = useCallback(
    (permission: string) => {
      if (!user) return false;
      if (user.role && user.role.toLowerCase() === 'admin') return true;
      return user.permissions.includes(permission);
    },
    [user],
  );

  return (
    <AuthContext.Provider value={{ user, token, loading, signIn, signOut, can }}>
      {children}
    </AuthContext.Provider>
  );
}
