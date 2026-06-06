# Running the Somnath Enterprise Mobile App

A step-by-step guide to run the **bare React Native** app (no Expo) on
**Android** and **iOS**, including the Laravel backend it talks to.

> The repo ships JS/TS + config only. The native `android/` and `ios/`
> folders are **generated once** (Section 3) — they are gitignored.

---

## 1. Prerequisites

### Common (all platforms)
- **Node.js 18+** and **npm** — `brew install node` (macOS) / [nodejs.org](https://nodejs.org)
- **Watchman** (macOS) — `brew install watchman`
- **Git**
- The **Laravel backend** running (Section 2) — the app is useless without it.

### For iOS (macOS only)
- **Xcode** (latest) from the App Store
- Xcode Command Line Tools:
  ```bash
  xcode-select --install
  sudo xcodebuild -license accept
  ```
- **CocoaPods**: `sudo gem install cocoapods` (or `brew install cocoapods`)

### For Android (macOS / Windows / Linux)
- **Android Studio** (includes the Android SDK + an emulator)
- **JDK 17** — `brew install --cask zulu@17` (macOS) or use Android Studio's bundled JDK
- In Android Studio → **SDK Manager**, install:
  - Android SDK Platform (API 34/35)
  - Android SDK Build-Tools
  - Android Emulator + a virtual device (AVD), e.g. Pixel 7
- Set environment variables (add to `~/.zshrc` / `~/.bash_profile`):
  ```bash
  export ANDROID_HOME=$HOME/Library/Android/sdk
  export PATH=$PATH:$ANDROID_HOME/emulator:$ANDROID_HOME/platform-tools
  ```

Verify your environment any time with:
```bash
npx react-native doctor
```

---

## 2. Backend (Laravel API)

The mobile app authenticates against the Laravel API on this same branch.

```bash
# from the repo root (not mobile/)
composer install
cp .env.example .env          # then edit DB_* to match your MySQL
php artisan key:generate
php artisan migrate            # creates tables incl. personal_access_tokens
php artisan serve              # serves http://127.0.0.1:8000
```

Requirements: **PHP 8.2+**, **Composer**, **MySQL**. Create a database and set
`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in `.env`.

> Keep `php artisan serve` running in its own terminal while you use the app.
> Test login: `admin@gmail.com` (set a password via `php artisan tinker`).

---

## 3. Get the project & install JS dependencies

```bash
git clone https://github.com/webytude/Somnath-Enterprise.git
cd Somnath-Enterprise
git checkout apps/react-native
cd mobile
npm install
```

### Generate the native projects (one time)
The native folders are not committed. Create them with the **same app name**
(`SomnathEnterprise`) and matching RN version, then copy them in:

```bash
cd ~/Desktop
npx @react-native-community/cli@latest init SomnathEnterprise --version 0.79.2 --skip-install

# copy the generated native folders into this repo's mobile/
cp -R SomnathEnterprise/ios     /path/to/Somnath-Enterprise/mobile/
cp -R SomnathEnterprise/android /path/to/Somnath-Enterprise/mobile/
```

⚠️ The name **must** be `SomnathEnterprise` — it must match `app.json`
(`name`) and `AppRegistry.registerComponent` in `index.js`.

---

## 4. Configure the API base URL

Edit `mobile/src/config/env.ts` for your target. The host differs per platform:

| Target                     | `API_BASE_URL`                          |
|----------------------------|------------------------------------------|
| **iOS simulator**          | `http://localhost:8000/api/v1`           |
| **Android emulator**       | `http://10.0.2.2:8000/api/v1`            |
| **Physical device** (any)  | `http://<your-mac-LAN-IP>:8000/api/v1`   |

> `10.0.2.2` is how the Android emulator reaches the host machine's
> `localhost`. Find your LAN IP with `ipconfig getifaddr en0` (macOS).
> For a physical device, also run the backend with
> `php artisan serve --host=0.0.0.0`.

---

## 5. Run on iOS

### 5a. Install pods
```bash
cd mobile/ios
pod install            # if it fails: bundle install && bundle exec pod install
cd ..
```

### 5b. Start Metro (keep running)
```bash
npm start
```

### 5c. Option A — Xcode
```bash
open ios/SomnathEnterprise.xcworkspace   # the .xcworkspace, NOT .xcodeproj
```
In Xcode:
1. Select the **SomnathEnterprise** scheme (top-left).
2. Choose a simulator (e.g. **iPhone 15**).
3. Press **▶ Run** (⌘R).

### 5c. Option B — CLI
```bash
npm run ios
# specific device: npm run ios -- --simulator="iPhone 15"
```

### Physical iPhone
In Xcode → target → **Signing & Capabilities** → select your Apple ID **Team**,
plug in the phone, trust the computer, pick it as the run destination.
Use your Mac's **LAN IP** in `env.ts` (not `localhost`).

---

## 6. Run on Android

### 6a. Start an emulator (or plug in a device)
- **Android Studio** → Device Manager → ▶ start a virtual device, **or**
- Physical device: enable **Developer Options → USB debugging**, connect, then
  confirm it's visible: `adb devices`.

### 6b. Start Metro (keep running)
```bash
cd mobile
npm start
```

### 6c. Option A — Android Studio
1. **File → Open** → select `mobile/android`.
2. Let Gradle sync finish (first time downloads dependencies — be patient).
3. Pick your device/emulator in the toolbar.
4. Press **▶ Run**.

### 6c. Option B — CLI
```bash
npm run android
```

### Cleartext HTTP (required for dev)
Android blocks plain `http://` by default. In
`mobile/android/app/src/main/AndroidManifest.xml`, add to the `<application>` tag:
```xml
<application
    android:usesCleartextTraffic="true"
    ... >
```
(Only needed for non-HTTPS dev servers.)

---

## 7. Troubleshooting

| Symptom | Fix |
|---|---|
| White screen / "No bundle URL registered" | Metro isn't running → `npm start`. |
| Login fails / network error | Wrong `API_BASE_URL` for the platform (Section 4), or backend not running. |
| Android network error to localhost | Use `10.0.2.2`, and add `usesCleartextTraffic` (Section 6). |
| iOS HTTP blocked on LAN IP | Add an ATS exception in `ios/.../Info.plist` (`localhost` already works in debug). |
| Pods out of date after dep change | `cd ios && pod install`. |
| Android build cache issues | `cd android && ./gradlew clean` then re-run. |
| Stale Metro cache | `npm start -- --reset-cache`. |
| Anything env-related | `npx react-native doctor`. |

---

## 8. Quick reference

```bash
# Terminal 1 — backend
php artisan serve

# Terminal 2 — Metro
cd mobile && npm start

# Terminal 3 — build & launch
cd mobile && npm run ios       # or: npm run android
```
