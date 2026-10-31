<?php

namespace App\Services;

use App\Models\PushSubscription;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;
use RuntimeException;
use Throwable;

/**
 * Sends a notification to every phone or computer where Sagar turned them on in
 * the admin app. Uses the browser's own push service, so no Google or app store
 * account is needed. Failures are logged and never stop a booking.
 */
class PushNotifier
{
    public function isConfigured(): bool
    {
        return filled(config('services.webpush.public_key')) && filled(config('services.webpush.private_key'));
    }

    /**
     * @return int How many devices accepted the notification
     */
    public function send(string $title, string $body, string $url = '/admin', ?string $tag = null): int
    {
        $subscriptions = PushSubscription::all();

        if (! $this->isConfigured() || $subscriptions->isEmpty()) {
            return 0;
        }

        try {
            $webPush = new WebPush(['VAPID' => [
                'subject' => config('services.webpush.subject'),
                'publicKey' => config('services.webpush.public_key'),
                'privateKey' => config('services.webpush.private_key'),
            ]], ['TTL' => 24 * 3600, 'urgency' => 'high']);

            $payload = json_encode(['title' => $title, 'body' => $body, 'url' => $url, 'tag' => $tag]);

            foreach ($subscriptions as $subscription) {
                $webPush->queueNotification(Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'publicKey' => $subscription->public_key,
                    'authToken' => $subscription->auth_token,
                    'contentEncoding' => $subscription->content_encoding,
                ]), $payload);
            }

            $delivered = 0;

            foreach ($webPush->flush() as $report) {
                if ($report->isSuccess()) {
                    $delivered++;
                } elseif ($report->isSubscriptionExpired()) {
                    // Notifications were turned off on that device, or the app was uninstalled
                    PushSubscription::where('endpoint', $report->getEndpoint())->delete();
                } else {
                    report(new RuntimeException('Push notification failed: '.$report->getReason()));
                }
            }

            return $delivered;
        } catch (Throwable $e) {
            report($e);

            return 0;
        }
    }
}
