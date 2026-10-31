<x-layouts.admin title="Reviews">

    <div class="flex max-w-190 flex-col gap-10">
        <section class="flex flex-col gap-5">
            <div class="flex flex-col gap-2">
                <h1 class="font-serif text-h2 font-semibold">Reviews</h1>
                <p class="text-muted">Shown on the home page under "What couples say", newest first (up to 6). With none shown, that section is hidden.</p>
            </div>

            <form method="POST" action="{{ route('admin.reviews.store') }}" class="flex flex-col gap-5 rounded-2xl border border-line bg-surface p-5 sm:p-6">
                @csrf
                <h2 class="font-serif text-2xl font-semibold">Add a review</h2>
                @include('admin.reviews.form')
                <div>
                    <x-button>Add review</x-button>
                </div>
            </form>
        </section>

        @if ($reviews->isNotEmpty())
            <section class="flex flex-col gap-4">
                <h2 class="font-serif text-2xl font-semibold">All reviews</h2>
                @foreach ($reviews as $saved)
                    <article class="flex flex-col gap-3 rounded-2xl border border-line bg-surface p-5">
                        <blockquote class="whitespace-pre-line">“{{ $saved->quote }}”</blockquote>
                        <p class="text-small text-muted">{{ $saved->couple }}@if ($saved->context) · {{ $saved->context }}@endif · {{ $saved->is_published ? 'Shown on the site' : 'Hidden' }}</p>
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="{{ route('admin.reviews.edit', $saved) }}" class="text-small font-semibold text-brand underline">Edit</a>
                            <details>
                                <summary class="cursor-pointer text-small font-semibold text-muted">Delete…</summary>
                                <form method="POST" action="{{ route('admin.reviews.destroy', $saved) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="outline" size="sm">Yes, delete it</x-button>
                                </form>
                            </details>
                        </div>
                    </article>
                @endforeach
            </section>
        @endif
    </div>

</x-layouts.admin>
