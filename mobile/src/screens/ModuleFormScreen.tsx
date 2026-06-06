import React, { useLayoutEffect, useState, useEffect } from 'react';
import { ScrollView, Switch, Alert } from 'react-native';
import { useNavigation, useRoute } from '@react-navigation/native';

import {
  Box,
  VStack,
  HStack,
  Text,
  Center,
  Spinner,
  Input,
  InputField,
  Button,
  ButtonText,
  ButtonSpinner,
} from '@ui/index';
import { useItem, useSave } from '@/api/crud';
import { getModule, ModuleField } from '@/config/modules';
import { RelationPicker } from '@/components/RelationPicker';
import { apiErrorMessage } from '@/api/client';

export function ModuleFormScreen() {
  const route = useRoute<any>();
  const nav = useNavigation<any>();
  const mod = getModule(route.params.moduleKey)!;
  const id: number | undefined = route.params?.id;
  const isEdit = id != null;

  const { data: existing, isLoading } = useItem(mod.endpoint, id);
  const save = useSave(mod.endpoint, id);

  const [form, setForm] = useState<Record<string, any>>({});

  useLayoutEffect(() => {
    nav.setOptions({ title: `${isEdit ? 'Edit' : 'New'} ${mod.title}` });
  }, [nav, mod, isEdit]);

  useEffect(() => {
    if (existing) {
      const initial: Record<string, any> = {};
      mod.fields.forEach((f) => {
        initial[f.name] = existing[f.name] ?? '';
      });
      setForm(initial);
    }
  }, [existing, mod]);

  const set = (name: string, value: any) =>
    setForm((prev) => ({ ...prev, [name]: value }));

  const submit = async () => {
    // Drop empty password on edit so we don't overwrite it with blank.
    const payload: Record<string, any> = { ...form };
    Object.keys(payload).forEach((k) => {
      if (payload[k] === '') delete payload[k];
    });
    try {
      await save.mutateAsync(payload);
      nav.goBack();
    } catch (e) {
      Alert.alert('Error', apiErrorMessage(e));
    }
  };

  if (isEdit && isLoading) {
    return (
      <Center className="flex-1 bg-gray-50">
        <Spinner />
      </Center>
    );
  }

  return (
    <Box className="flex-1 bg-gray-50">
      <ScrollView contentContainerStyle={{ padding: 16, paddingBottom: 48 }}>
        <VStack space="lg">
          {mod.fields.map((f) => (
            <VStack key={f.name} space="xs">
              <Text className="text-sm font-medium text-gray-600">
                {f.label}
                {f.required && <Text className="text-red-500"> *</Text>}
              </Text>
              <FieldInput
                field={f}
                value={form[f.name]}
                onChange={(v) => set(f.name, v)}
              />
            </VStack>
          ))}

          <Button className="mt-2" isDisabled={save.isPending} onPress={submit}>
            {save.isPending && <ButtonSpinner />}
            <ButtonText>{isEdit ? 'Update' : 'Create'}</ButtonText>
          </Button>
        </VStack>
      </ScrollView>
    </Box>
  );
}

function FieldInput({
  field,
  value,
  onChange,
}: {
  field: ModuleField;
  value: any;
  onChange: (v: any) => void;
}) {
  switch (field.type) {
    case 'relation':
      return (
        <RelationPicker
          endpoint={field.relation!.endpoint}
          labelKeys={field.relation!.labelKeys}
          value={value}
          onChange={(v) => onChange(v)}
        />
      );

    case 'boolean':
      return (
        <HStack className="justify-between">
          <Text className="text-gray-500">{value ? 'Yes' : 'No'}</Text>
          <Switch value={!!value} onValueChange={onChange} trackColor={{ true: '#0f766e' }} />
        </HStack>
      );

    case 'textarea':
      return (
        <Input className="h-24 items-start py-2">
          <InputField
            multiline
            textAlignVertical="top"
            value={value != null ? String(value) : ''}
            onChangeText={onChange}
            placeholder={field.label}
          />
        </Input>
      );

    case 'number':
      return (
        <Input>
          <InputField
            keyboardType="numeric"
            value={value != null ? String(value) : ''}
            onChangeText={onChange}
            placeholder={field.label}
          />
        </Input>
      );

    case 'password':
      return (
        <Input>
          <InputField
            secureTextEntry
            value={value != null ? String(value) : ''}
            onChangeText={onChange}
            placeholder="••••••••"
          />
        </Input>
      );

    case 'date':
      return (
        <Input>
          <InputField
            value={value != null ? String(value) : ''}
            onChangeText={onChange}
            placeholder="YYYY-MM-DD"
          />
        </Input>
      );

    default:
      return (
        <Input>
          <InputField
            value={value != null ? String(value) : ''}
            onChangeText={onChange}
            placeholder={field.label}
          />
        </Input>
      );
  }
}
