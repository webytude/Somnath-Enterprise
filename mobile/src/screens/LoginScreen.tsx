import React, { useState } from 'react';
import { KeyboardAvoidingView, Platform } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

import {
  Box,
  Center,
  VStack,
  Text,
  Heading,
  Input,
  InputField,
  Button,
  ButtonText,
  ButtonSpinner,
} from '@ui/index';
import { useAuth } from '@/auth/AuthContext';
import { apiErrorMessage } from '@/api/client';

export function LoginScreen() {
  const { signIn } = useAuth();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState<string | null>(null);
  const [busy, setBusy] = useState(false);

  const submit = async () => {
    setError(null);
    setBusy(true);
    try {
      await signIn(email.trim(), password);
    } catch (e) {
      setError(apiErrorMessage(e));
    } finally {
      setBusy(false);
    }
  };

  return (
    <SafeAreaView style={{ flex: 1, backgroundColor: '#0f766e' }}>
      <KeyboardAvoidingView
        style={{ flex: 1 }}
        behavior={Platform.OS === 'ios' ? 'padding' : undefined}
      >
        <Center className="flex-1 px-6">
          <VStack space="xl" className="w-full max-w-sm">
            <Center>
              <Box className="h-16 w-16 items-center justify-center rounded-2xl bg-white/20">
                <Text className="text-3xl">🏗️</Text>
              </Box>
              <Heading className="mt-4 text-white text-2xl">Somnath Enterprise</Heading>
              <Text className="text-white/80">Sign in to continue</Text>
            </Center>

            <Box className="rounded-3xl bg-white p-6">
              <VStack space="md">
                {error && (
                  <Box className="rounded-lg bg-red-50 p-3">
                    <Text className="text-red-600 text-sm">{error}</Text>
                  </Box>
                )}

                <VStack space="xs">
                  <Text className="text-sm font-medium text-gray-600">Email</Text>
                  <Input>
                    <InputField
                      placeholder="you@example.com"
                      autoCapitalize="none"
                      keyboardType="email-address"
                      value={email}
                      onChangeText={setEmail}
                    />
                  </Input>
                </VStack>

                <VStack space="xs">
                  <Text className="text-sm font-medium text-gray-600">Password</Text>
                  <Input>
                    <InputField
                      placeholder="••••••••"
                      secureTextEntry
                      value={password}
                      onChangeText={setPassword}
                    />
                  </Input>
                </VStack>

                <Button className="mt-2" isDisabled={busy} onPress={submit}>
                  {busy && <ButtonSpinner />}
                  <ButtonText>{busy ? 'Signing in…' : 'Sign In'}</ButtonText>
                </Button>
              </VStack>
            </Box>
          </VStack>
        </Center>
      </KeyboardAvoidingView>
    </SafeAreaView>
  );
}
