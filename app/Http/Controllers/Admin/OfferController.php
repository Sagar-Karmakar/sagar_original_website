<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The Back to Us offer on the home page: label, price, spots and the note under the price.
 */
class OfferController extends Controller
{
    public function edit(): View
    {
        return view('admin.offer', ['offer' => Setting::offer()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $offer = $request->validate([
            'label' => ['required', 'string', 'max:40'],
            'price' => ['required', 'integer', 'min:0', 'max:1000000'],
            'spots_total' => ['nullable', 'integer', 'min:1', 'max:1000'],
            'spots_left' => ['nullable', 'required_with:spots_total', 'integer', 'min:0', 'lte:spots_total'],
            'note_title' => ['nullable', 'string', 'max:60'],
            'note' => ['nullable', 'string', 'max:400'],
        ], [
            'spots_left.lte' => 'Spots left can’t be more than the total.',
        ]);

        Setting::saveOffer($offer);

        return back()->with('status', 'Offer saved. The home page shows it now.');
    }
}
