<x-layouts.admin title="Edit review">

    <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="flex max-w-190 flex-col gap-5 rounded-2xl border border-line bg-surface p-5 sm:p-6">
        @csrf
        @method('PUT')
        <h1 class="font-serif text-h2 font-semibold">Edit review</h1>
        @include('admin.reviews.form')
        <div class="flex flex-wrap items-center gap-4">
            <x-button>Save review</x-button>
            <a href="{{ route('admin.reviews') }}" class="font-semibold text-muted underline">Cancel</a>
        </div>
    </form>

</x-layouts.admin>
