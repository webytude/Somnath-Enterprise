# Android Build Guide

How to build the Somnath Enterprise app for Android — a quick **debug APK** for
testing, and a **signed release** APK / AAB for distribution (Play Store or
direct install).

> Prerequisite: the native `android/` folder must already exist. If not, generate
> it first — see [RUNNING.md](./RUNNING.md) §3. And run `npm install` in `mobile/`.

---

## 0. Before any release build

Point the app at your **production** API (a release build talks to a real
server, not your laptop). Edit `mobile/src/config/env.ts`:

```ts
export const API_BASE_URL = 'https://api.yourdomain.com/api/v1';
```

- Use **HTTPS** in production. If you must ship an HTTP URL, keep
  `android:usesCleartextTraffic="true"` in `AndroidManifest.xml` (not
  recommended for production).
- After changing JS config, no extra step is needed — Gradle re-bundles the JS
  into the build automatically for release.

---

## 1. Debug build (fast, for testing)

Produces an unsigned-but-debuggable APK you can install on any device. No
keystore needed (uses the auto-generated debug key).

```bash
cd mobile/android
./gradlew assembleDebug
```

Output:
```
android/app/build/outputs/apk/debug/app-debug.apk
```

Install it on a connected device/emulator:
```bash
adb install -r app/build/outputs/apk/debug/app-debug.apk
```

> A debug APK still needs **Metro** running (`npm start`) unless you bundle JS.
> For a self-contained test build, use the release build below.

---

## 2. Release build — one-time signing setup

A release build must be signed with **your own** keystore. Do this once and keep
the keystore safe — you need the same key for every future update.

### 2a. Generate an upload keystore
```bash
cd mobile/android/app
keytool -genkeypair -v \
  -storetype PKCS12 \
  -keystore somnath-upload-key.keystore \
  -alias somnath-upload \
  -keyalg RSA -keysize 2048 -validity 10000
```
It prompts for a **store password**, **key password**, and your details.
This creates `android/app/somnath-upload-key.keystore`.

> ⚠️ **Back up this file and the passwords.** Lose them and you can never update
> the app on the Play Store under the same listing. Do **not** commit the
> keystore to git.

### 2b. Add credentials to `android/gradle.properties`
Add these lines (keep this file out of git, or use `~/.gradle/gradle.properties`
on your build machine):
```properties
MYAPP_UPLOAD_STORE_FILE=somnath-upload-key.keystore
MYAPP_UPLOAD_KEY_ALIAS=somnath-upload
MYAPP_UPLOAD_STORE_PASSWORD=*****
MYAPP_UPLOAD_KEY_PASSWORD=*****
```

### 2c. Wire the signing config in `android/app/build.gradle`
Inside `android { ... }`, add a `signingConfigs.release` block and point the
release build type at it:

```gradle
android {
    ...
    signingConfigs {
        release {
            if (project.hasProperty('MYAPP_UPLOAD_STORE_FILE')) {
                storeFile file(MYAPP_UPLOAD_STORE_FILE)
                storePassword MYAPP_UPLOAD_STORE_PASSWORD
                keyAlias MYAPP_UPLOAD_KEY_ALIAS
                keyPassword MYAPP_UPLOAD_KEY_PASSWORD
            }
        }
    }
    buildTypes {
        release {
            signingConfig signingConfigs.release   // was signingConfigs.debug
            minifyEnabled true
            shrinkResources true
            proguardFiles getDefaultProguardFile("proguard-android-optimize.txt"), "proguard-rules.pro"
        }
    }
}
```

---

## 3. Build a release APK (direct install / sideload)

```bash
cd mobile/android
./gradlew assembleRelease
```

Output:
```
android/app/build/outputs/apk/release/app-release.apk
```

Install to a device:
```bash
adb install -r app/build/outputs/apk/release/app-release.apk
```

This APK is **self-contained** — JS is bundled in, so Metro is not required.

---

## 4. Build a release AAB (Google Play)

The Play Store requires an **Android App Bundle (.aab)**, not an APK:

```bash
cd mobile/android
./gradlew bundleRelease
```

Output:
```
android/app/build/outputs/bundle/release/app-release.aab
```

Upload `app-release.aab` in the Google Play Console. (With Play App Signing,
Google manages the final signing key; your upload key signs the bundle.)

---

## 5. App version & identity

Set in `android/app/build.gradle` under `defaultConfig`:

```gradle
defaultConfig {
    applicationId "com.somnath.enterprise"   // unique app ID (set once)
    versionCode 1        // integer — increment for EVERY Play upload
    versionName "1.0.0"  // user-visible version string
    ...
}
```
- `versionCode` **must increase** with each Play Store upload.
- App display name: `android/app/src/main/res/values/strings.xml` → `app_name`.
- Launcher icon: replace `res/mipmap-*/ic_launcher*` (use Android Studio →
  right-click `res` → New → Image Asset).

---

## 6. Build from Android Studio (GUI alternative)

1. **File → Open** → `mobile/android`, let Gradle sync.
2. **Build → Generate Signed Bundle / APK…**
3. Choose **APK** or **Android App Bundle**, select your keystore, pick
   **release**, and finish. Output paths are the same as above.

---

## 7. Troubleshooting

| Problem | Fix |
|---|---|
| `SDK location not found` | Create `android/local.properties` with `sdk.dir=/Users/<you>/Library/Android/sdk`. |
| `keytool: command not found` | Use the JDK's keytool, e.g. `$JAVA_HOME/bin/keytool` (JDK 17). |
| Build fails after dependency change | `cd android && ./gradlew clean` then rebuild. |
| `Duplicate resources` / weird cache | `./gradlew clean` + delete `android/app/build`. |
| Release app shows blank screen | JS bundling failed — check `assembleRelease` logs; ensure `npm install` ran. |
| App can't reach the API | `env.ts` must use the production HTTPS URL; HTTP needs cleartext enabled. |
| Out of memory during build | Add `org.gradle.jvmargs=-Xmx4g` to `android/gradle.properties`. |

---

## 8. Quick reference

```bash
cd mobile/android

./gradlew assembleDebug      # debug APK    -> apk/debug/app-debug.apk
./gradlew assembleRelease    # release APK  -> apk/release/app-release.apk
./gradlew bundleRelease      # release AAB  -> bundle/release/app-release.aab
./gradlew clean              # clear build cache
```

> On Windows use `gradlew.bat` instead of `./gradlew`. On macOS/Linux, if you get
> a permissions error: `chmod +x gradlew`.
