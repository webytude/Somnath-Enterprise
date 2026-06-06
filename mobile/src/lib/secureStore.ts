import * as Keychain from 'react-native-keychain';

/**
 * Thin secure key/value wrapper over react-native-keychain, mirroring the
 * expo-secure-store API the app was originally written against. Each key is
 * stored under its own Keychain `service` so multiple values can coexist.
 */

export async function getItem(key: string): Promise<string | null> {
  const creds = await Keychain.getGenericPassword({ service: key });
  return creds ? creds.password : null;
}

export async function setItem(key: string, value: string): Promise<void> {
  await Keychain.setGenericPassword(key, value, { service: key });
}

export async function deleteItem(key: string): Promise<void> {
  await Keychain.resetGenericPassword({ service: key });
}
