# Somnath Enterprise — Mobile App

**Bare React Native CLI** client (no Expo) for the Somnath Enterprise Laravel
API, styled with **Gluestack UI v3** (NativeWind / Tailwind).

The app is **config-driven**: every backend module is described once in
`src/config/modules.ts`, and generic List / Detail / Form screens render
from that config. Adding a field or a whole module is a data change there —
no new screen code.

## Stack
- **React Native 0.79** CLI (bare — no Expo), New Architecture
- **Gluestack UI v3** + NativeWind 4 (Tailwind) — see `components/ui/`
- **React Navigation** (drawer + native stack)
- **TanStack Query** for server state
- **axios** API client with Sanctum Bearer token interceptor
- **react-native-keychain** for secure token storage (via `src/lib/secureStore.ts`)

## Project layout
```
mobile/
├─ App.tsx                      # providers + navigation root
├─ components/ui/               # Gluestack v3 UI kit + provider
├─ src/
│  ├─ api/client.ts             # axios + token interceptor + 401 handling
│  ├─ api/crud.ts               # generic useList/useItem/useSave/useRemove
│  ├─ auth/AuthContext.tsx      # login/logout, session restore, can()
│  ├─ config/env.ts             # API_BASE_URL
│  ├─ config/modules.ts         # ★ registry of all 27 modules + fields
│  ├─ lib/secureStore.ts        # react-native-keychain wrapper
│  ├─ components/RelationPicker.tsx
│  ├─ navigation/RootNavigator.tsx
│  └─ screens/                  # Login, Dashboard, ModuleList/Detail/Form
```

## Setup (bare React Native CLI — no Expo)

> 📖 **Run guide (Android & iOS): [RUNNING.md](./RUNNING.md)**
> 🤖 **Android build/release guide (APK & AAB): [ANDROID_BUILD.md](./ANDROID_BUILD.md)**

This folder holds JS/TS + config only. Generate the native projects with your
own setup, then run with the RN CLI.

```bash
cd mobile
npm install

# 1) Generate /android and /ios (gitignored). Either init a fresh RN project
#    with the same name (SomnathEnterprise) and copy these sources in, or run:
npx @react-native-community/cli@latest init SomnathEnterprise   # in a temp dir
#    then copy its android/ + ios/ folders here. (You said you handle native.)

# 2) iOS pods (macOS only)
npm run pods            # cd ios && pod install

# 3) Run
npm start               # Metro bundler
npm run android         # build + launch on Android device/emulator
npm run ios             # build + launch on iOS simulator
```

Gluestack v3: the components in `components/ui/` are hand-written stand-ins
following the gluestack API. To pull the canonical versions, run
`npx gluestack-ui init` then `npx gluestack-ui add box text button input ...`.

## API base URL
Set in `src/config/env.ts` (`API_BASE_URL`). Defaults to
`http://10.0.2.2:8000/api/v1` (Android emulator → host `localhost`).
- iOS simulator: `http://localhost:8000/api/v1`
- Physical device: your machine's LAN IP, e.g. `http://192.168.1.50:8000/api/v1`

> Android cleartext HTTP: for non-HTTPS dev URLs, enable
> `android:usesCleartextTraffic="true"` in your generated
> `android/app/src/main/AndroidManifest.xml`.

## Auth
`POST /login` returns a Sanctum Bearer token, stored in SecureStore and
attached to every request. RBAC is mirrored client-side via `can()` (admin
role bypasses; otherwise checks `permissions[]`) to gate the dashboard tiles
and the create/edit/delete actions — the API enforces it for real.
