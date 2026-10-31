// The admin as a phone app: install it from /admin/app and get a notification for every booking.

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/admin-sw.js', { scope: '/admin' });
}

// Install: Chrome offers its install prompt once the app can be installed
const installButton = document.querySelector('[data-install]');
const installedNote = document.querySelector('[data-installed]');
let installPrompt;

const showInstalled = () => {
    installedNote?.removeAttribute('hidden');
    installButton?.setAttribute('hidden', '');
};

if (window.matchMedia('(display-mode: standalone)').matches) showInstalled();

window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault();
    installPrompt = event;
    installButton?.removeAttribute('hidden');
});

installButton?.addEventListener('click', async () => {
    if (!installPrompt) return;
    installPrompt.prompt();
    if ((await installPrompt.userChoice).outcome === 'accepted') showInstalled();
});

window.addEventListener('appinstalled', showInstalled);

// Notifications for this device
const pushPanel = document.querySelector('[data-push]');

if (pushPanel) {
    const status = pushPanel.querySelector('[data-push-status]');
    const onButton = pushPanel.querySelector('[data-push-on]');
    const offButton = pushPanel.querySelector('[data-push-off]');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // subscribed: true / false shows the matching button; null shows neither
    const show = (message, subscribed) => {
        status.textContent = message;
        onButton.hidden = subscribed !== false;
        offButton.hidden = subscribed !== true;
    };

    const save = (method, body) =>
        fetch(pushPanel.dataset.url, {
            method,
            headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrfToken },
            body: JSON.stringify(body),
        });

    const subscriptionBody = (subscription) => ({
        ...subscription.toJSON(),
        contentEncoding: (PushManager.supportedContentEncodings || ['aes128gcm'])[0],
    });

    if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        show("This browser can't show notifications. Open the admin in Chrome, or use the Android app.", null);
    } else if (Notification.permission === 'denied') {
        show('Notifications are blocked for this site. Allow them in the browser’s site settings, then reload.', null);
    } else {
        navigator.serviceWorker.ready.then(async (registration) => {
            const subscription = await registration.pushManager.getSubscription();
            // Re-save in case the server lost it
            if (subscription) await save('POST', subscriptionBody(subscription));
            show(subscription ? 'Notifications are on for this device.' : 'Notifications are off for this device.', Boolean(subscription));
        });
    }

    onButton?.addEventListener('click', async () => {
        onButton.disabled = true;

        try {
            if ((await Notification.requestPermission()) !== 'granted') {
                show('Notifications weren’t allowed. Tap the button again and choose Allow.', false);
                return;
            }

            const registration = await navigator.serviceWorker.ready;
            const subscription = await registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: base64UrlToBytes(pushPanel.dataset.key),
            });

            if (!(await save('POST', subscriptionBody(subscription))).ok) throw new Error('Not saved');
            show('Notifications are on for this device. Send yourself a test below.', true);
        } catch {
            show('Something went wrong turning on notifications. Please try again.', false);
        } finally {
            onButton.disabled = false;
        }
    });

    offButton?.addEventListener('click', async () => {
        const subscription = await (await navigator.serviceWorker.ready).pushManager.getSubscription();

        if (subscription) {
            await save('DELETE', { endpoint: subscription.endpoint });
            await subscription.unsubscribe();
        }

        show('Notifications are off for this device.', false);
    });
}

function base64UrlToBytes(value) {
    const base64 = (value + '='.repeat((4 - (value.length % 4)) % 4)).replace(/-/g, '+').replace(/_/g, '/');

    return Uint8Array.from(atob(base64), (char) => char.charCodeAt(0));
}
