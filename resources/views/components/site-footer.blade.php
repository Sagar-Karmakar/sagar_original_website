{{-- variant: "full" (every page) or "minimal" (the /call landing page) --}}
@props(['variant' => 'full'])

@php
    $instagram = ['Instagram @sagarforcouples', config('site.instagram_url')];
    $links = $variant === 'minimal'
        ? [$instagram, ['Privacy', route('privacy')], ['Refund policy', route('refund')]]
        : [
            $instagram,
            ['WhatsApp', config('site.whatsapp_url')],
            [config('site.email'), 'mailto:'.config('site.email')],
            ['Privacy', route('privacy')],
            ['Terms', route('terms')],
            ['Refund policy', route('refund')],
        ];
@endphp

<footer class="border-t border-line bg-panel text-body {{ $variant === 'minimal' ? 'py-10' : 'pt-14 pb-10' }}">
    @if ($variant === 'minimal')
        <div class="mx-auto flex max-w-site flex-wrap justify-between gap-x-7 gap-y-3 px-6 text-small">
            <span class="font-serif text-xl font-semibold text-ink">Sagar Karmakar</span>
            <nav aria-label="Footer" class="flex flex-wrap gap-x-6 gap-y-3">
                @foreach ($links as [$label, $href])
                    <a href="{{ $href }}" class="underline hover:text-brand">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
    @else
        <div class="mx-auto flex max-w-site flex-col gap-8 px-6">
            <div class="flex flex-wrap justify-between gap-8">
                <div class="flex flex-[1_1_260px] flex-col gap-2">
                    <span class="font-serif text-2xl font-semibold text-ink">Sagar Karmakar</span>
                    <span class="text-small">Couples coach</span>
                </div>
                <nav aria-label="Footer" class="flex flex-[2_1_420px] flex-wrap content-start gap-x-7 gap-y-3 text-small">
                    @foreach ($links as [$label, $href])
                        <a href="{{ $href }}" class="underline hover:text-brand">{{ $label }}</a>
                    @endforeach
                </nav>
            </div>
            <p class="border-t border-dash pt-6 text-sm text-muted">This is coaching, not therapy. If you feel afraid at home, call the Women Helpline 181, or 112 in an emergency. For emotional support, call Tele-MANAS on 14416.</p>
        </div>
    @endif
</footer>
