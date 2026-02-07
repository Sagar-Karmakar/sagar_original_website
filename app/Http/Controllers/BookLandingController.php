<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BookLandingController extends Controller
{
    public function index()
    {
        return view('book.landing');
    }

    public function thankYou()
    {
        // If accessed directly without session data, maybe redirect back? 
        // Or just show generic message.
        if (!session('email') && !session('success')) {
            return redirect()->route('book.landing');
        }
        return view('book.thank-you');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'whatsapp' => 'nullable|string'
        ]);

        $email = $request->input('email');
        // $whatsapp = $request->input('whatsapp'); // Use if needed for API

        // Path to the file
        $filePath = public_path('files/ThisIsNotLaziness_ReviewCopy.pdf');

        // Check for file existence
        if (!file_exists($filePath)) {
            // Ideally, we might want to log this but still let the user proceed to the thank you page 
            // saying "We'll email you shortly once the system is ready", but for now, let's keep the error.
            // Or better, creating a dummy file if missing? No, stick to error if file missing.
             return back()->with('error', 'The book file is temporarily missing. Please contact support.');
        }

        // 1. Prepare WhatsApp Link (Send message TO Sagar)
        $waLink = null;
        if ($request->filled('whatsapp')) {
            // Target specific number
            $targetNumber = "918961373748";
            $message = "Hello Sagar, I like to check and review the book \"This Is Not Laziness\". Can you share it here please?";
            $waLink = "https://wa.me/" . $targetNumber . "?text=" . urlencode($message); 
        }

        // 2. Attempt Email Sending
        try {
            Mail::html('Here is your copy of <strong>This Is Not Laziness</strong>.<br><br>Enjoy the read!', function ($message) use ($email, $filePath) {
                $message->to($email)
                        ->subject('Your Copy: This Is Not Laziness')
                        ->attach($filePath);
            });
        } catch (\Exception $e) {
            // Log error but continue flow so user sees the Thank You page
            \Log::error("Book email send failed: " . $e->getMessage());
        }

        // 3. Redirect to Thank You Page
        return redirect()->route('book.thank-you')->with([
            'success' => 'Your copy is on its way!',
            'email' => $email,
            'waLink' => $waLink
        ]);
    }
}
