import React from 'react';
import { ScrollView, Pressable } from 'react-native';
import { useNavigation, DrawerActions } from '@react-navigation/native';

import { Box, VStack, HStack, Text, Heading, Button, ButtonText } from '@ui/index';
import { useAuth } from '@/auth/AuthContext';
import { MODULES, MODULE_GROUPS, ModuleDef } from '@/config/modules';

function ModuleTile({ mod }: { mod: ModuleDef }) {
  const nav = useNavigation<any>();
  return (
    <Pressable
      onPress={() => nav.navigate('ModuleList', { moduleKey: mod.key })}
      className="w-[31%] mb-3"
    >
      <Box className="aspect-square items-center justify-center rounded-2xl bg-white border border-gray-100 shadow-sm p-2">
        <Text className="text-3xl">{mod.icon}</Text>
        <Text className="mt-1 text-center text-xs text-gray-700" numberOfLines={2}>
          {mod.title}
        </Text>
      </Box>
    </Pressable>
  );
}

export function DashboardScreen() {
  const { user, signOut, can } = useAuth();
  const nav = useNavigation<any>();

  return (
    <Box className="flex-1 bg-gray-50">
      <ScrollView contentContainerStyle={{ padding: 16, paddingBottom: 40 }}>
        <HStack className="justify-between">
          <VStack space="xs">
            <Text className="text-gray-500">Welcome back,</Text>
            <Heading>{user?.name}</Heading>
            <Text className="text-xs text-gray-400">
              {user?.role ? user.role.toUpperCase() : 'No role'} · {user?.email}
            </Text>
          </VStack>
          <Button
            variant="outline"
            className="h-9 px-3"
            onPress={() => nav.dispatch(DrawerActions.openDrawer())}
          >
            <ButtonText variant="outline">☰ Menu</ButtonText>
          </Button>
        </HStack>

        {MODULE_GROUPS.map((group) => {
          const mods = MODULES.filter(
            (m) => m.group === group && can(`${m.endpoint}.index`),
          );
          if (mods.length === 0) return null;
          return (
            <VStack key={group} space="sm" className="mt-6">
              <Text className="text-sm font-semibold uppercase tracking-wide text-gray-500">
                {group}
              </Text>
              <HStack className="flex-wrap justify-between">
                {mods.map((m) => (
                  <ModuleTile key={m.key} mod={m} />
                ))}
              </HStack>
            </VStack>
          );
        })}

        <Button action="negative" className="mt-8" onPress={signOut}>
          <ButtonText>Sign Out</ButtonText>
        </Button>
      </ScrollView>
    </Box>
  );
}
