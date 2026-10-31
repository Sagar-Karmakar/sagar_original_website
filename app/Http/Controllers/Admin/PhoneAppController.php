<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use App\Services\PushNotifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * The admin as a phone app: install it, and get a notification for each booking.
 */
class PhoneAppController extends Controller
{
    /**
     * The Android app, built from android/ (see README → Android app).
     */
    public const APK_PATH = 'android/sagar-admin.apk';

    public function show(PushNotifier $push): View
    {
        return view('admin.app', [
            'pushConfigured' => $push->isConfigured(),
            'devices' => PushSubscription::latest()->get(),
            'apkAvailable' => is_file(base_path(self::APK_PATH)),
        ]);
    }

    public function downloadApk(): BinaryFileResponse
    {
        abort_unless(is_file(base_path(self::APK_PATH)), 404);

        return response()->download(base_path(self::APK_PATH), 'sagar-admin.apk', [
            'Content-Type' => 'application/vnd.android.package-archive',
        ]);
    }

    /**
     * Save this device's push subscription (sent by the browser after "Turn on notifications").
     */
    public function subscribe(Request $request): JsonResponse
    {
        $data = $request->validate([
            'endpoint' => ['required', 'url:https', 'max:500'],
            'keys.p256dh' => ['required', 'string', 'max:255'],
            'keys.auth' => ['required', 'string', 'max:255'],
            'contentEncoding' => ['nullable', 'in:aesgcm,aes128gcm'],
        ]);

        PushSubscription::updateOrCreate(['endpoint' => $data['endpoint']], [
            'user_id' => $request->user()->id,
            'public_key' => $data['keys']['p256dh'],
            'auth_token' => $data['keys']['auth'],
            'content_encoding' => $data['contentEncoding'] ?? 'aes128gcm',
            'user_agent' => Str::limit((string) $request->userAgent(), 250),
        ]);

        return response()->json(['ok' => true]);
    }

    public function unsubscribe(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate(['endpoint' => ['required', 'string']]);

        PushSubscription::where('endpoint', $request->input('endpoint'))->delete();

        return $request->expectsJson()
            ? response()->json(['ok' => true])
            : back()->with('status', 'Notifications turned off for that device.');
    }

    public function test(PushNotifier $push): RedirectResponse
    {
        $sent = $push->send('Test from Sagar for Couples', 'Notifications are working. You\'ll get one like this for every booking.');

        return back()->with('status', $sent
            ? "Test sent to {$sent} ".Str::plural('device', $sent).'.'
            : 'No device got the test. Turn on notifications on your phone first.');
    }
}
