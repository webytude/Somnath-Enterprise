import React, { useState, useMemo } from 'react';
import { Modal, FlatList, Pressable } from 'react-native';

import { Box, VStack, HStack, Text, Center, Spinner, Input, InputField } from '@ui/index';
import { useList } from '@/api/crud';

interface Props {
  endpoint: string;
  labelKeys: string[];
  value?: number | string | null;
  onChange: (id: number | null) => void;
}

function labelFor(row: any, labelKeys: string[]): string {
  for (const k of labelKeys) {
    if (row?.[k] != null && row[k] !== '') return String(row[k]);
  }
  return `#${row?.id}`;
}

export function RelationPicker({ endpoint, labelKeys, value, onChange }: Props) {
  const [open, setOpen] = useState(false);
  const [search, setSearch] = useState('');
  const { data, isLoading } = useList(endpoint);
  const rows: any[] = Array.isArray(data) ? data : [];

  const selected = rows.find((r) => String(r.id) === String(value));

  const filtered = useMemo(() => {
    if (!search.trim()) return rows;
    const q = search.toLowerCase();
    return rows.filter((r) => labelFor(r, labelKeys).toLowerCase().includes(q));
  }, [rows, search, labelKeys]);

  return (
    <>
      <Pressable onPress={() => setOpen(true)}>
        <Input className="justify-between">
          <Text className={selected ? 'text-gray-900' : 'text-gray-400'}>
            {selected ? labelFor(selected, labelKeys) : 'Select…'}
          </Text>
          <Text className="text-gray-400">▾</Text>
        </Input>
      </Pressable>

      <Modal visible={open} animationType="slide" transparent onRequestClose={() => setOpen(false)}>
        <Box className="flex-1 justify-end bg-black/40">
          <Box className="max-h-[75%] rounded-t-3xl bg-white p-4">
            <HStack className="justify-between mb-2">
              <Text className="font-semibold text-gray-900">Select</Text>
              <Pressable onPress={() => setOpen(false)}>
                <Text className="text-gray-400 text-lg">✕</Text>
              </Pressable>
            </HStack>

            <Input className="mb-2">
              <InputField placeholder="Search…" value={search} onChangeText={setSearch} />
            </Input>

            {isLoading ? (
              <Center className="py-10">
                <Spinner />
              </Center>
            ) : (
              <FlatList
                data={filtered}
                keyExtractor={(item) => String(item.id)}
                ListHeaderComponent={
                  <Pressable
                    onPress={() => {
                      onChange(null);
                      setOpen(false);
                    }}
                    className="py-3 border-b border-gray-100"
                  >
                    <Text className="text-gray-400">— None —</Text>
                  </Pressable>
                }
                renderItem={({ item }) => (
                  <Pressable
                    onPress={() => {
                      onChange(item.id);
                      setOpen(false);
                    }}
                    className="py-3 border-b border-gray-100"
                  >
                    <VStack space="xs">
                      <Text className="text-gray-900">{labelFor(item, labelKeys)}</Text>
                      <Text className="text-xs text-gray-400">#{item.id}</Text>
                    </VStack>
                  </Pressable>
                )}
              />
            )}
          </Box>
        </Box>
      </Modal>
    </>
  );
}
