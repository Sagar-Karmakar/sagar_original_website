<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $upcoming = Booking::active()
            ->where('ends_at', '>=', now())
            ->orderBy('starts_at')
            ->get()
            ->groupBy(fn (Booking $booking) => $booking->localStart()->format('l, j F'));

        $recent = Booking::where(fn ($query) => $query->whereNotNull('cancelled_at')->orWhere('ends_at', '<', now()))
            ->latest('starts_at')
            ->limit(20)
            ->get();

        return view('admin.bookings', ['upcoming' => $upcoming, 'recent' => $recent]);
    }

    public function cancel(Booking $booking, BookingNotifier $notifier): RedirectResponse
    {
        if (! $booking->isCancelled()) {
            $booking->cancel();
            $notifier->cancelled($booking, byClient: false);
        }

        return back()->with('status', "Cancelled {$booking->couple()}'s call. They've been emailed.");
    }
}
