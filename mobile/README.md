# Somnath Enterprise — Mobile App

React Native (Expo SDK 53) client for the Somnath Enterprise Laravel API,
styled with **Gluestack UI v3** (NativeWind / Tailwind).

The app is **config-driven**: every backend module is described once in
`src/config/modules.ts`, and generic List / Detail / Form screens render
from that config. Adding a field or a whole module is a data change there —
no new screen code.

## Stack
- **Expo SDK 53** + React Native 0.79 (New Architecture)
- **Gluestack UI v3** + NativeWind 4 (Tailwind) — see `components/ui/`
- **React Navigation** (drawer + native stack)
- **TanStack Query** for server state
- **axios** API client with Sanctum Bearer token interceptor
- **expo-secure-store** for token storage

## Project layout
```
mobile/
├─ App.tsx                      # providers + navigation root
├─ components/ui/               # Gluestack v3 UI kit + provider
├─ src/
│  ├─ api/client.ts             # axios + token interceptor + 401 handling
│  ├─ api/crud.ts               # generic useList/useItem/useSave/useRemove
│  ├─ auth/AuthContext.tsx      # login/logout, session restore, can()
│  ├─ config/modules.ts         # ★ registry of all 27 modules + fields
│  ├─ components/RelationPicker.tsx
│  ├─ navigation/RootNavigator.tsx
│  └─ screens/                  # Login, Dashboard, ModuleList/Detail/Form
```

## Setup (on the native build system)
```bash
cd mobile
npm install

# Gluestack v3 — the components in components/ui/ are hand-written
# stand-ins following the gluestack API. To pull the canonical versions:
#   npx gluestack-ui init
#   npx gluestack-ui add box text heading button input vstack hstack spinner card

npx expo start            # dev
# native projects are generated on your side:
npx expo prebuild         # creates /ios and /android (gitignored)
```

## API base URL
Set in `app.json` → `expo.extra.apiBaseUrl`. Defaults to
`http://10.0.2.2:8000/api/v1` (Android emulator → host `localhost`).
- iOS simulator: `http://localhost:8000/api/v1`
- Physical device: your machine's LAN IP, e.g. `http://192.168.1.50:8000/api/v1`

## Auth
`POST /login` returns a Sanctum Bearer token, stored in SecureStore and
attached to every request. RBAC is mirrored client-side via `can()` (admin
role bypasses; otherwise checks `permissions[]`) to gate the dashboard tiles
and the create/edit/delete actions — the API enforces it for real.
