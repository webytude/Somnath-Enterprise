import React, { useLayoutEffect } from 'react';
import { FlatList, Pressable, RefreshControl } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';

import { Box, VStack, HStack, Text, Center, Spinner } from '@ui/index';
import { useList } from '@/api/crud';
import { getModule, recordTitle } from '@/config/modules';
import { useAuth } from '@/auth/AuthContext';
import { apiErrorMessage } from '@/api/client';

export function ModuleListScreen() {
  const route = useRoute<any>();
  const nav = useNavigation<any>();
  const { can } = useAuth();
  const mod = getModule(route.params.moduleKey)!;
  const { data, isLoading, isError, error, refetch, isRefetching } = useList(mod.endpoint);

  const canCreate = can(`${mod.endpoint}.store`);

  useLayoutEffect(() => {
    nav.setOptions({
      title: `${mod.icon}  ${mod.title}`,
      headerRight: () =>
        canCreate ? (
          <Pressable
            onPress={() => nav.navigate('ModuleForm', { moduleKey: mod.key })}
            className="mr-3"
          >
            <Text className="text-white text-2xl">＋</Text>
          </Pressable>
        ) : null,
    });
  }, [nav, mod, canCreate]);

  if (isLoading) {
    return (
      <Center className="flex-1 bg-gray-50">
        <Spinner />
      </Center>
    );
  }

  if (isError) {
    return (
      <Center className="flex-1 bg-gray-50 px-6">
        <Text className="text-red-600 text-center">{apiErrorMessage(error)}</Text>
      </Center>
    );
  }

  const rows: any[] = Array.isArray(data) ? data : [];

  return (
    <Box className="flex-1 bg-gray-50">
      <FlatList
        data={rows}
        keyExtractor={(item) => String(item.id)}
        contentContainerStyle={{ padding: 16, paddingBottom: 32 }}
        refreshControl={
          <RefreshControl refreshing={isRefetching} onRefresh={refetch} />
        }
        ListEmptyComponent={
          <Center className="mt-24">
            <Text className="text-4xl">{mod.icon}</Text>
            <Text className="mt-2 text-gray-400">No records yet</Text>
          </Center>
        }
        renderItem={({ item }) => (
          <Pressable
            onPress={() =>
              nav.navigate('ModuleDetail', { moduleKey: mod.key, id: item.id })
            }
          >
            <Box className="mb-3 rounded-2xl bg-white p-4 border border-gray-100 shadow-sm">
              <HStack className="justify-between">
                <VStack space="xs" className="flex-1 pr-2">
                  <Text className="font-semibold text-gray-900" numberOfLines={1}>
                    {recordTitle(mod, item)}
                  </Text>
                  <Text className="text-xs text-gray-400">#{item.id}</Text>
                </VStack>
                <Text className="text-gray-300 text-xl">›</Text>
              </HStack>
            </Box>
          </Pressable>
        )}
      />
    </Box>
  );
}
