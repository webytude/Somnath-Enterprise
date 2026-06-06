import React, { createContext, useContext, useState, useMemo } from 'react';
import { View } from 'react-native';
import { colorScheme } from 'nativewind';

type Mode = 'light' | 'dark';

interface ColorModeContextValue {
  mode: Mode;
  setMode: (m: Mode) => void;
  toggle: () => void;
}

const ColorModeContext = createContext<ColorModeContextValue>({
  mode: 'light',
  setMode: () => {},
  toggle: () => {},
});

export const useColorMode = () => useContext(ColorModeContext);

/**
 * Gluestack UI v3 provider.
 *
 * Wraps the app with the NativeWind color-mode context. The canonical
 * gluestack CLI (`npx gluestack-ui init`) regenerates this file with the
 * full token config; this hand-written version keeps the same public API
 * (GluestackUIProvider + useColorMode) so screens don't change.
 */
export function GluestackUIProvider({
  mode = 'light',
  children,
}: {
  mode?: Mode;
  children: React.ReactNode;
}) {
  const [current, setCurrent] = useState<Mode>(mode);

  const value = useMemo<ColorModeContextValue>(
    () => ({
      mode: current,
      setMode: (m) => {
        colorScheme.set(m);
        setCurrent(m);
      },
      toggle: () => {
        const next = current === 'light' ? 'dark' : 'light';
        colorScheme.set(next);
        setCurrent(next);
      },
    }),
    [current],
  );

  return (
    <ColorModeContext.Provider value={value}>
      <View style={{ flex: 1 }} className={current === 'dark' ? 'dark' : ''}>
        {children}
      </View>
    </ColorModeContext.Provider>
  );
}
