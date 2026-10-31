{{-- Review fields, shared by the add form and the edit page --}}
<div class="flex flex-col gap-1.5">
    <label for="quote" class="font-semibold">What they said</label>
    <textarea id="quote" name="quote" rows="4" maxlength="1000" required class="form-control"
              @error('quote') aria-invalid="true" @enderror>{{ old('quote', $review->quote) }}</textarea>
    @error('quote')
        <p class="text-sm font-semibold text-brand">{{ $message }}</p>
    @enderror
</div>

<div class="flex flex-wrap gap-4">
    <div class="flex-1 basis-60">
        <x-input name="couple" label="Who" hint="(no names, e.g. A couple from Kolkata)" :value="$review->couple" required maxlength="100" />
    </div>
    <div class="flex-1 basis-60">
        <x-input name="context" label="When" hint="(optional, e.g. from a free session)" :value="$review->context" maxlength="100" />
    </div>
</div>

<label class="flex items-center gap-3">
    <input type="hidden" name="is_published" value="0">
    <input type="checkbox" name="is_published" value="1" class="size-5 accent-brand" @checked(old('is_published', $review->is_published))>
    Show it on the home page
</label>

<div class="flex flex-col gap-1">
    <label class="flex items-start gap-3">
        <input type="checkbox" name="consent" value="1" required class="mt-1 size-5 shrink-0 accent-brand" @checked(old('consent', $review->exists))>
        The couple gave me written permission to share this, without their names.
    </label>
    @error('consent')
        <p class="text-sm font-semibold text-brand">{{ $message }}</p>
    @enderror
</div>
