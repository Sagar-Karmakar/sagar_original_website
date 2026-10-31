<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Reviews shown on the home page ("What couples say"). Newest first.
 */
class ReviewController extends Controller
{
    public function index(): View
    {
        return view('admin.reviews.index', [
            'reviews' => Review::latest()->get(),
            'review' => new Review(['couple' => 'A couple from ', 'is_published' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Review::create($this->validated($request));

        return back()->with('status', 'Review added.');
    }

    public function edit(Review $review): View
    {
        return view('admin.reviews.edit', ['review' => $review]);
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $review->update($this->validated($request));

        return to_route('admin.reviews')->with('status', 'Review saved.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('status', 'Review deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'quote' => ['required', 'string', 'max:1000'],
            'couple' => ['required', 'string', 'max:100'],
            'context' => ['nullable', 'string', 'max:100'],
            'is_published' => ['boolean'],
            'consent' => ['accepted'],
        ], [
            'consent.accepted' => 'Please confirm the couple gave written permission to share this.',
        ]);

        return [...collect($data)->except('consent')->all(), 'is_published' => $request->boolean('is_published')];
    }
}
