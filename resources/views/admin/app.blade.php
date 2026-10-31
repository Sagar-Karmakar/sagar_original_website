<x-layouts.admin title="Phone app">

    <div class="flex max-w-190 flex-col gap-8">
        <div class="flex flex-col gap-2">
            <h1 class="font-serif text-h2 font-semibold">Phone app</h1>
            <p class="text-muted">Keep this admin on your phone like an app, and get a notification the moment someone books a call.</p>
        </div>

        <section class="flex flex-col items-start gap-4 rounded-2xl border border-line bg-surface p-5 sm:p-6">
            <h2 class="font-serif text-2xl font-semibold">1. Install it</h2>

            @if ($apkAvailable)
                <p><strong>Android app:</strong> download it on your phone, open the file and tap <strong>Install</strong>. Android may ask you to allow installs from your browser first; that's normal for apps not from the Play Store.</p>
                <x-button :href="route('admin.app.apk')">Download the Android app (.apk)</x-button>
                <p class="text-small text-muted">The app opens {{ config('app.url') }}/admin, so it works fully once the site is live there.</p>
            @endif

            <p>@if ($apkAvailable)<strong>Or, without downloading:</strong> @endif Open <strong class="break-all">{{ route('admin.app') }}</strong> in Chrome on your phone, log in, and tap:</p>
            <x-button type="button" variant="outline" data-install hidden>Install the app</x-button>
            <p data-installed hidden class="font-semibold text-brand">Installed. Open "Sagar Admin" from your home screen.</p>
            <p class="text-small text-muted">No button? In Chrome's ⋮ menu, tap <strong>Add to Home screen</strong> or <strong>Install app</strong>. Before the site is live, open the admin on your phone through the link from <code>Local Server/Start Local Server.bat</code>.</p>
        </section>

        <section class="flex flex-col items-start gap-4 rounded-2xl border border-line bg-surface p-5 sm:p-6">
            <h2 class="font-serif text-2xl font-semibold">2. Turn on booking notifications</h2>

            @if ($pushConfigured)
                <div data-push data-url="{{ route('admin.push.subscribe') }}" data-key="{{ config('services.webpush.public_key') }}" class="flex flex-col items-start gap-4">
                    <p>Do this on the phone itself, inside the app. You'll get a notification for every new booking, and when a couple cancels.</p>
                    <p data-push-status role="status" class="font-semibold">Checking this device…</p>
                    <div class="flex flex-wrap gap-3">
                        <x-button type="button" data-push-on hidden>Turn on notifications</x-button>
                        <x-button type="button" variant="outline" data-push-off hidden>Turn off on this device</x-button>
                    </div>
                </div>
            @else
                <p>Notifications need their keys first: run <code>php artisan push:keys</code> and add the two lines it prints to <code>.env</code>.</p>
            @endif
        </section>

        <section class="flex flex-col items-start gap-4 rounded-2xl border border-line bg-surface p-5 sm:p-6">
            <h2 class="font-serif text-2xl font-semibold">3. Test it</h2>

            @if ($devices->isEmpty())
                <p class="text-muted">No devices yet. Turn on notifications on your phone first.</p>
            @else
                <ul class="flex w-full flex-col divide-y divide-line">
                    @foreach ($devices as $device)
                        <li class="flex flex-wrap items-center justify-between gap-3 py-3">
                            <span><strong>{{ $device->deviceName() }}</strong> <span class="text-muted">· added {{ $device->created_at->diffForHumans() }}</span></span>
                            <form method="POST" action="{{ route('admin.push.unsubscribe') }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="endpoint" value="{{ $device->endpoint }}">
                                <button type="submit" class="cursor-pointer text-small font-semibold text-brand underline">Remove</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
                <form method="POST" action="{{ route('admin.push.test') }}">
                    @csrf
                    <x-button>Send a test notification</x-button>
                </form>
            @endif
        </section>
    </div>

</x-layouts.admin>
