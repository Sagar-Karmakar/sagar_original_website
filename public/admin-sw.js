// Service worker for the admin app (web and Android): shows a notification for each
// booking and opens the admin when it's tapped. Pages are never cached; admin data is always live.

self.addEventListener('install', () => self.skipWaiting());
self.addEventListener('activate', (event) => event.waitUntil(self.clients.claim()));

self.addEventListener('push', (event) => {
    const data = event.data ? event.data.json() : {};

    event.waitUntil(
        self.registration.showNotification(data.title || 'Sagar for Couples', {
            body: data.body || '',
            icon: '/images/app-icon-192.png',
            badge: '/images/app-badge-96.png',
            tag: data.tag || undefined,
            renotify: Boolean(data.tag),
            data: { url: data.url || '/admin' },
        }),
    );
});

self.addEventListener('notificationclick', (event) => {
    event.notification.close();
    const url = new URL(event.notification.data?.url || '/admin', self.location.origin).href;

    event.waitUntil(
        (async () => {
            const windows = await self.clients.matchAll({ type: 'window', includeUncontrolled: true });
            const admin = windows.find((client) => client.url.startsWith(`${self.location.origin}/admin`));

            if (!admin) return self.clients.openWindow(url);
            await admin.focus();
            return admin.navigate(url).catch(() => {});
        })(),
    );
});

// When the phone is offline, show a short note instead of the browser's error page
self.addEventListener('fetch', (event) => {
    if (event.request.mode !== 'navigate') return;

    event.respondWith(
        fetch(event.request).catch(
            () =>
                new Response(
                    '<!doctype html><meta name="viewport" content="width=device-width,initial-scale=1"><title>Offline</title>' +
                        '<body style="margin:0;padding:48px 24px;font-family:system-ui,sans-serif;background:#fdf4f2;color:#2b2420">' +
                        '<h1 style="font-family:Georgia,serif;color:#b81f1f">You’re offline</h1>' +
                        '<p>Bookings will load again when your phone is back online.</p>',
                    { headers: { 'Content-Type': 'text/html; charset=utf-8' } },
                ),
        ),
    );
});
