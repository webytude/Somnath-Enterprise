/**
 * App environment config (bare React Native — no expo-constants).
 *
 * API base URL for the Laravel backend. Pick the value for your target:
 *  - Android emulator:  http://10.0.2.2:8000/api/v1   (10.0.2.2 = host localhost)
 *  - iOS simulator:     http://localhost:8000/api/v1
 *  - Physical device:   http://<your-machine-LAN-IP>:8000/api/v1
 *
 * For multi-environment builds, swap this for react-native-config (.env).
 */
export const API_BASE_URL = 'http://10.0.2.2:8000/api/v1';
