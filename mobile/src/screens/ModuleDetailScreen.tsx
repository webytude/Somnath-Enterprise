import React, { useLayoutEffect } from 'react';
import { ScrollView, Pressable, Alert } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';

import {
  Box,
  VStack,
  HStack,
  Text,
  Center,
  Spinner,
  Button,
  ButtonText,
  Divider,
} from '@ui/index';
import { useItem, useRemove } from '@/api/crud';
import { getModule, recordTitle } from '@/config/modules';
import { useAuth } from '@/auth/AuthContext';
import { apiErrorMessage } from '@/api/client';

export function ModuleDetailScreen() {
  const route = useRoute<any>();
  const nav = useNavigation<any>();
  const { can } = useAuth();
  const mod = getModule(route.params.moduleKey)!;
  const id = route.params.id;

  const { data, isLoading, isError, error } = useItem(mod.endpoint, id);
  const remove = useRemove(mod.endpoint);

  const canEdit = can(`${mod.endpoint}.update`);
  const canDelete = can(`${mod.endpoint}.destroy`);

  useLayoutEffect(() => {
    nav.setOptions({
      title: data ? recordTitle(mod, data) : 'Details',
      headerRight: () =>
        canEdit ? (
          <Pressable
            onPress={() => nav.navigate('ModuleForm', { moduleKey: mod.key, id })}
            className="mr-3"
          >
            <Text className="text-white font-semibold">Edit</Text>
          </Pressable>
        ) : null,
    });
  }, [nav, mod, data, canEdit, id]);

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

  const confirmDelete = () => {
    Alert.alert('Delete', 'Are you sure you want to delete this record?', [
      { text: 'Cancel', style: 'cancel' },
      {
        text: 'Delete',
        style: 'destructive',
        onPress: async () => {
          try {
            await remove.mutateAsync(id);
            nav.goBack();
          } catch (e) {
            Alert.alert('Error', apiErrorMessage(e));
          }
        },
      },
    ]);
  };

  return (
    <Box className="flex-1 bg-gray-50">
      <ScrollView contentContainerStyle={{ padding: 16, paddingBottom: 40 }}>
        <Box className="rounded-2xl bg-white p-4 border border-gray-100">
          <VStack space="md">
            {mod.fields.map((f, idx) => {
              const value = data?.[f.name];
              return (
                <Box key={f.name}>
                  <Text className="text-xs uppercase tracking-wide text-gray-400">
                    {f.label}
                  </Text>
                  <Text className="mt-0.5 text-gray-900">
                    {value === null || value === undefined || value === ''
                      ? '—'
                      : String(value)}
                  </Text>
                  {idx < mod.fields.length - 1 && <Divider className="mt-3" />}
                </Box>
              );
            })}
          </VStack>
        </Box>

        {canDelete && (
          <Button action="negative" className="mt-6" onPress={confirmDelete}>
            <ButtonText>Delete</ButtonText>
          </Button>
        )}
      </ScrollView>
    </Box>
  );
}
