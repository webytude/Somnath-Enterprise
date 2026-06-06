import React from 'react';
import {
  View,
  Text as RNText,
  Pressable,
  TextInput,
  ActivityIndicator,
  ViewProps,
  TextProps,
  PressableProps,
  TextInputProps,
  ScrollView as RNScrollView,
} from 'react-native';

/**
 * Gluestack UI v3 compatible primitive kit (NativeWind / Tailwind classes).
 *
 * These follow the gluestack component API (Box, VStack, Button + ButtonText,
 * Input + InputField, etc.) so screens read like canonical gluestack code.
 * Run `npx gluestack-ui add <component>` to swap any of these for the official
 * implementations — the import surface stays the same.
 */

type WithClass<P> = P & { className?: string };

export const Box = ({ className = '', ...props }: WithClass<ViewProps>) => (
  <View className={className} {...props} />
);

export const VStack = ({
  className = '',
  space,
  ...props
}: WithClass<ViewProps> & { space?: 'xs' | 'sm' | 'md' | 'lg' | 'xl' }) => {
  const gap = { xs: 'gap-1', sm: 'gap-2', md: 'gap-3', lg: 'gap-4', xl: 'gap-6' }[space ?? 'md'];
  return <View className={`flex-col ${gap} ${className}`} {...props} />;
};

export const HStack = ({
  className = '',
  space,
  ...props
}: WithClass<ViewProps> & { space?: 'xs' | 'sm' | 'md' | 'lg' | 'xl' }) => {
  const gap = { xs: 'gap-1', sm: 'gap-2', md: 'gap-3', lg: 'gap-4', xl: 'gap-6' }[space ?? 'md'];
  return <View className={`flex-row items-center ${gap} ${className}`} {...props} />;
};

export const Center = ({ className = '', ...props }: WithClass<ViewProps>) => (
  <View className={`items-center justify-center ${className}`} {...props} />
);

export const Text = ({ className = '', ...props }: WithClass<TextProps>) => (
  <RNText className={`text-base text-gray-800 dark:text-gray-100 ${className}`} {...props} />
);

export const Heading = ({ className = '', ...props }: WithClass<TextProps>) => (
  <RNText
    className={`text-xl font-bold text-gray-900 dark:text-white ${className}`}
    {...props}
  />
);

export const Divider = ({ className = '' }: { className?: string }) => (
  <View className={`h-px w-full bg-gray-200 dark:bg-gray-700 ${className}`} />
);

export const Card = ({ className = '', ...props }: WithClass<ViewProps>) => (
  <View
    className={`rounded-2xl bg-white dark:bg-gray-800 p-4 shadow-sm border border-gray-100 dark:border-gray-700 ${className}`}
    {...props}
  />
);

export const Badge = ({
  children,
  action = 'muted',
}: {
  children: React.ReactNode;
  action?: 'success' | 'error' | 'warning' | 'muted' | 'info';
}) => {
  const styles = {
    success: 'bg-green-100 text-green-700',
    error: 'bg-red-100 text-red-700',
    warning: 'bg-amber-100 text-amber-700',
    info: 'bg-sky-100 text-sky-700',
    muted: 'bg-gray-100 text-gray-600',
  }[action];
  const [bg, fg] = styles.split(' ');
  return (
    <View className={`self-start rounded-full px-2.5 py-0.5 ${bg}`}>
      <RNText className={`text-xs font-semibold ${fg}`}>{children}</RNText>
    </View>
  );
};

type ButtonVariant = 'solid' | 'outline' | 'link';
type ButtonAction = 'primary' | 'secondary' | 'negative';

export const Button = ({
  className = '',
  variant = 'solid',
  action = 'primary',
  isDisabled,
  children,
  ...props
}: WithClass<PressableProps> & {
  variant?: ButtonVariant;
  action?: ButtonAction;
  isDisabled?: boolean;
}) => {
  const base = 'flex-row items-center justify-center rounded-xl px-4 h-11';
  const solid = {
    primary: 'bg-primary-700',
    secondary: 'bg-gray-700',
    negative: 'bg-red-600',
  }[action];
  const outline = 'border border-primary-700 bg-transparent';
  const link = 'bg-transparent px-0 h-auto';
  const variantClass = variant === 'solid' ? solid : variant === 'outline' ? outline : link;
  return (
    <Pressable
      disabled={isDisabled}
      className={`${base} ${variantClass} ${isDisabled ? 'opacity-50' : ''} ${className}`}
      {...props}
    >
      {children}
    </Pressable>
  );
};

export const ButtonText = ({
  className = '',
  variant = 'solid',
  ...props
}: WithClass<TextProps> & { variant?: ButtonVariant }) => {
  const color =
    variant === 'solid' ? 'text-white' : 'text-primary-700';
  return <RNText className={`text-base font-semibold ${color} ${className}`} {...props} />;
};

export const ButtonSpinner = ({ color = '#fff' }: { color?: string }) => (
  <ActivityIndicator color={color} className="mr-2" />
);

export const Input = ({ className = '', ...props }: WithClass<ViewProps>) => (
  <View
    className={`flex-row items-center rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 px-3 h-11 ${className}`}
    {...props}
  />
);

export const InputField = ({ className = '', ...props }: WithClass<TextInputProps>) => (
  <TextInput
    placeholderTextColor="#9ca3af"
    className={`flex-1 text-base text-gray-900 dark:text-gray-100 ${className}`}
    {...props}
  />
);

export const Spinner = ({ size = 'large' }: { size?: 'small' | 'large' }) => (
  <ActivityIndicator size={size} color="#0f766e" />
);

export const ScrollView = RNScrollView;
export { Pressable };
