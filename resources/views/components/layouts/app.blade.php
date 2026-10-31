@props([
    'title' => null,
    'description' => 'Back to Us is a 4-week online program that helps married couples laugh, talk and feel like a team again. Book a free 20-minute call with couples coach Sagar Karmakar.',
    'nav' => 'pages',
    'footer' => 'full',
    'stickyCta' => false,
])

<!DOCTYPE html>
<html lang="en" class="motion-safe:scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ? "{$title} · Sagar for Couples" : 'Sagar for Couples' }}</title>
    <meta name="description" content="{{ $description }}">
    {{-- How links look when shared on WhatsApp, Facebook and others --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Sagar for Couples">
    <meta property="og:title" content="{{ $title ?? 'Sagar for Couples' }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($shareImage = \App\Support\SiteImage::url('share'))
        <meta property="og:image" content="{{ $shareImage }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif
    <meta name="color-scheme" content="light">
    <meta name="theme-color" content="#fdf4f2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,500;0,9..144,600;1,9..144,500;1,9..144,600&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-page font-sans text-base text-ink antialiased">

    <x-site-header :nav="$nav" />

    <main>
        {{ $slot }}
    </main>

    <x-site-footer :variant="$footer" />

    @if ($stickyCta)
        <div class="sticky bottom-0 border-t border-line bg-page/95 px-4 py-3 md:hidden">
            <x-button :href="route('call')" class="w-full">Book your free call</x-button>
        </div>
    @endif

</body>
</html>
