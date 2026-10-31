<x-layouts.admin title="Offer">

    <div class="flex max-w-190 flex-col gap-6">
        <div class="flex flex-col gap-2">
            <h1 class="font-serif text-h2 font-semibold">Offer</h1>
            <p class="text-muted">The Back to Us price card on the home page, and the line in its last red band. Changes show straight away.</p>
        </div>

        <form method="POST" action="{{ route('admin.offer.update') }}" class="flex flex-col gap-5 rounded-2xl border border-line bg-surface p-5 sm:p-6">
            @csrf
            @method('PUT')

            <x-input name="label" label="Label" hint="(the red tag, e.g. Founding couples)" :value="$offer['label']" required maxlength="40" />
            <x-input name="price" label="Price per couple, in ₹" type="number" :value="$offer['price']" required min="0" step="1" inputmode="numeric" />

            <div class="flex flex-wrap gap-4">
                <div class="flex-1 basis-40">
                    <x-input name="spots_total" label="Total spots" hint="(empty: don't show spots)" type="number" :value="$offer['spots_total']" min="1" step="1" />
                </div>
                <div class="flex-1 basis-40">
                    <x-input name="spots_left" label="Spots left" type="number" :value="$offer['spots_left']" min="0" step="1" />
                </div>
            </div>

            <x-input name="note_title" label="Note heading" hint="(optional)" :value="$offer['note_title']" maxlength="60" />
            <div class="flex flex-col gap-1.5">
                <label for="note" class="font-semibold">Note under the price <span class="font-normal text-muted">(optional)</span></label>
                <textarea id="note" name="note" rows="3" maxlength="400" class="form-control">{{ old('note', $offer['note']) }}</textarea>
                @error('note')
                    <p class="text-sm font-semibold text-brand">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-button>Save offer</x-button>
            </div>
        </form>
    </div>

</x-layouts.admin>
