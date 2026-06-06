import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createDrawerNavigator } from '@react-navigation/drawer';

import { Center, Spinner } from '@ui/index';
import { useAuth } from '@/auth/AuthContext';
import { MODULES } from '@/config/modules';

import { LoginScreen } from '@/screens/LoginScreen';
import { DashboardScreen } from '@/screens/DashboardScreen';
import { ModuleListScreen } from '@/screens/ModuleListScreen';
import { ModuleDetailScreen } from '@/screens/ModuleDetailScreen';
import { ModuleFormScreen } from '@/screens/ModuleFormScreen';

export type RootStackParamList = {
  Dashboard: undefined;
  ModuleList: { moduleKey: string };
  ModuleDetail: { moduleKey: string; id: number };
  ModuleForm: { moduleKey: string; id?: number };
};

const Stack = createNativeStackNavigator<RootStackParamList>();
const Drawer = createDrawerNavigator();

const screenHeader = {
  headerStyle: { backgroundColor: '#0f766e' },
  headerTintColor: '#ffffff',
  headerTitleStyle: { fontWeight: '700' as const },
};

function AppStack() {
  return (
    <Stack.Navigator screenOptions={screenHeader}>
      <Stack.Screen
        name="Dashboard"
        component={DashboardScreen}
        options={{ title: 'Somnath Enterprise' }}
      />
      <Stack.Screen name="ModuleList" component={ModuleListScreen} options={{ title: '' }} />
      <Stack.Screen name="ModuleDetail" component={ModuleDetailScreen} options={{ title: 'Details' }} />
      <Stack.Screen name="ModuleForm" component={ModuleFormScreen} options={{ title: '' }} />
    </Stack.Navigator>
  );
}

function AppDrawer() {
  return (
    <Drawer.Navigator screenOptions={{ ...screenHeader, drawerActiveTintColor: '#0f766e' }}>
      <Drawer.Screen name="Home" component={AppStack} options={{ headerShown: false, title: 'Home' }} />
      {MODULES.map((m) => (
        <Drawer.Screen
          key={m.key}
          name={m.key}
          component={ModuleStackFor(m.key)}
          options={{ title: `${m.icon}  ${m.title}`, headerShown: false }}
        />
      ))}
    </Drawer.Navigator>
  );
}

// Each drawer entry opens the same stack pre-pointed at a module list.
function ModuleStackFor(moduleKey: string) {
  return function ModuleStack() {
    return (
      <Stack.Navigator screenOptions={screenHeader}>
        <Stack.Screen
          name="ModuleList"
          component={ModuleListScreen}
          initialParams={{ moduleKey }}
          options={{ title: '' }}
        />
        <Stack.Screen name="ModuleDetail" component={ModuleDetailScreen} options={{ title: 'Details' }} />
        <Stack.Screen name="ModuleForm" component={ModuleFormScreen} options={{ title: '' }} />
      </Stack.Navigator>
    );
  };
}

export function RootNavigator() {
  const { user, loading } = useAuth();

  if (loading) {
    return (
      <Center className="flex-1 bg-white">
        <Spinner />
      </Center>
    );
  }

  return (
    <NavigationContainer>
      {user ? <AppDrawer /> : <LoginScreen />}
    </NavigationContainer>
  );
}
