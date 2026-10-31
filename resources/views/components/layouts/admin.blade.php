@props(['title'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <meta name="color-scheme" content="light">
    <title>{{ $title }} · Admin · Sagar for Couples</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600&family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-page font-sans text-base text-ink antialiased">

    <header class="border-b border-line bg-surface">
        <div class="mx-auto flex max-w-site flex-wrap items-center justify-between gap-4 px-6 py-4">
            <a href="{{ route('admin.bookings') }}" class="font-serif text-xl font-semibold">Sagar <span class="text-brand">admin</span></a>
            @auth
                <nav aria-label="Admin" class="flex flex-wrap items-center gap-x-5 gap-y-2">
                    @foreach (['admin.bookings' => 'Bookings', 'admin.availability' => 'Availability'] as $route => $label)
                        <a href="{{ route($route) }}" @if (request()->routeIs($route)) aria-current="page" @endif
                           class="text-muted hover:text-ink aria-[current=page]:font-semibold aria-[current=page]:text-brand">{{ $label }}</a>
                    @endforeach
                    <a href="{{ route('home') }}" class="text-muted hover:text-ink">View site</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="cursor-pointer text-muted underline hover:text-ink">Log out</button>
                    </form>
                </nav>
            @endauth
        </div>
    </header>

    <main class="mx-auto max-w-site px-6 py-10">
        @if (session('status'))
            <p role="status" class="mb-8 rounded-xl bg-brand/10 px-4 py-3 font-semibold text-brand">{{ session('status') }}</p>
        @endif

        {{ $slot }}
    </main>

</body>
</html>
