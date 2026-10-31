import java.util.Properties

plugins {
    id("com.android.application")
}

// Signing key details live in android/keystore.properties, which is never committed (see README → Android app)
val keystoreProperties = Properties().apply {
    rootProject.file("keystore.properties").takeIf { it.exists() }?.inputStream()?.use { load(it) }
}

android {
    namespace = "com.sagarkarmakar.admin"
    compileSdk = 36

    defaultConfig {
        applicationId = "com.sagarkarmakar.admin"
        minSdk = 24
        targetSdk = 36
        // Raise both for every new APK, or Android won't install it over the old one
        versionCode = 3
        versionName = "1.2"
    }

    signingConfigs {
        create("release") {
            storeFile = keystoreProperties.getProperty("storeFile")?.let { rootProject.file(it) }
            storePassword = keystoreProperties.getProperty("storePassword")
            keyAlias = keystoreProperties.getProperty("keyAlias")
            keyPassword = keystoreProperties.getProperty("keyPassword")
        }
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            signingConfig = signingConfigs.getByName("release")
        }
    }
}

dependencies {
    // Trusted Web Activity: shows the admin site full screen in Chrome's engine, with its notifications
    implementation("com.google.androidbrowserhelper:androidbrowserhelper:2.7.4")
}
