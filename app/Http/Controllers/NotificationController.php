<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    /**
     * Handle Contact Form Submission (Welcome Page)
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'option' => 'required|string',
            'message' => 'required|string',
        ]);

        return $this->sendToDiscord(
            env('DISCORD_CONTACT_WEBHOOK'),
            "New Contact Request",
            [
                ['name' => 'Name', 'value' => $validated['name'], 'inline' => true],
                ['name' => 'Email', 'value' => $validated['email'], 'inline' => true],
                ['name' => 'Interest', 'value' => $validated['option'], 'inline' => false],
                ['name' => 'Message', 'value' => $validated['message'], 'inline' => false],
            ],
            5814783 // Purple
        );
    }

    /**
     * Handle Application / Healing Form Submission
     */
    public function submitApplication(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'age' => 'nullable|integer',
            'contact_pref' => 'required|string',
            'treatment' => 'required|string',
            'replace_care' => 'required|string',
            'reason' => 'required|string',
            'state' => 'required|string',
            'sense' => 'required|string',
            'location' => 'required|string',
            'time' => 'required|string',
            'impact_level' => 'required|string',
            'impact_area' => 'nullable|array',
            'history' => 'required|string',
            'resources' => 'required|string',
            'goal' => 'required|string',
            'openness' => 'required|string',
        ]);

        // Format Fields for Discord
        $fields = [
            ['name' => 'Name', 'value' => $validated['name'], 'inline' => true],
            ['name' => 'Phone', 'value' => $validated['phone'], 'inline' => true],
            ['name' => 'Email', 'value' => $validated['email'], 'inline' => true],
            ['name' => 'Age', 'value' => (string)($validated['age'] ?? 'N/A'), 'inline' => true],
            ['name' => 'Contact Pref', 'value' => $validated['contact_pref'], 'inline' => true],
            ['name' => 'Treatment?', 'value' => $validated['treatment'], 'inline' => true],
            ['name' => 'Replacing Care?', 'value' => $validated['replace_care'], 'inline' => true],
            ['name' => 'Reason', 'value' => $validated['reason'], 'inline' => false],
            ['name' => 'Current State', 'value' => $validated['state'], 'inline' => true],
            ['name' => 'Primary Sense', 'value' => $validated['sense'], 'inline' => true],
            ['name' => 'Body Location', 'value' => $validated['location'], 'inline' => true],
            ['name' => 'Time Focus', 'value' => $validated['time'], 'inline' => true],
            ['name' => 'Impact', 'value' => $validated['impact_level'], 'inline' => true],
            ['name' => 'Impact Areas', 'value' => implode(', ', $validated['impact_area'] ?? []), 'inline' => false],
            ['name' => 'History', 'value' => $validated['history'], 'inline' => true],
            ['name' => 'Resources', 'value' => $validated['resources'], 'inline' => false],
            ['name' => 'Goal', 'value' => $validated['goal'], 'inline' => false],
            ['name' => 'Openness', 'value' => $validated['openness'], 'inline' => true],
        ];

        return $this->sendToDiscord(
            env('DISCORD_APPLICATION_WEBHOOK'),
            "New Application Form Submission",
            $fields,
            3066993 // Teal/Green
        );
    }

    /**
     * Handle Book Lead Submission
     */
    public function submitLead(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
        ]);

        $name = $validated['name'];
        $phone = $validated['phone'];
        $email = $validated['email'];

        // 1. Send to Discord
        $this->sendToDiscord(
            env('DISCORD_LEAD_WEBHOOK'),
            "New Book Lead Generated",
            [
                ['name' => 'Name', 'value' => $name, 'inline' => true],
                ['name' => 'Phone/WhatsApp', 'value' => $phone, 'inline' => true],
                ['name' => 'Email', 'value' => $email, 'inline' => true],
                ['name' => 'Source', 'value' => 'Book Landing Page', 'inline' => false],
            ],
            15105570, // Orange
            true 
        );

        // 2. Existing Book Logic (Send Email & File)
        $filePath = public_path('files/ThisIsNotLaziness_ReviewCopy.pdf');
        
        if (file_exists($filePath)) {
            try {
                Mail::html('Here is your copy of <strong>This Is Not Laziness</strong>.<br><br>Enjoy the read!', function ($message) use ($email, $filePath) {
                    $message->to($email)
                            ->subject('Your Copy: This Is Not Laziness')
                            ->attach($filePath);
                });
            } catch (\Exception $e) {
                Log::error("Book email send failed: " . $e->getMessage());
            }
        }

        // WhatsApp Link construction
        $targetNumber = "918961373748";
        $message = "Hello Sagar, I like to check and review the book \"This Is Not Laziness\". Can you share it here please?";
        $waLink = "https://wa.me/" . $targetNumber . "?text=" . urlencode($message); 

        // Grant Access to Thank You Page
        session(['book_download_access' => true]);

        return redirect()->route('book.thank-you')->with([
            'success' => 'Your copy is on its way!',
            'email' => $email,
            'waLink' => $waLink
        ]);
    }

    /**
     * Helper to send Discord Webhook
     */
    private function sendToDiscord($url, $title, $fields, $color, $silent = false)
    {
        if (!$url) {
            Log::error('Discord webhook URL is missing for: ' . $title);
            if ($silent) return false;
            return response()->json(['message' => 'Configuration error.'], 500);
        }

        try {
            $response = Http::post($url, [
                'content' => "Create New Ticket", // Trigger for bot if needed
                'embeds' => [
                    [
                        'title' => $title,
                        'fields' => $fields,
                        'color' => $color,
                        'timestamp' => now()->toIso8601String(),
                        'footer' => ['text' => 'Sent from SagarKarmakar.com']
                    ]
                ]
            ]);

            if ($response->successful()) {
                if ($silent) return true;
                return response()->json(['message' => 'Message sent successfully!']);
            } else {
                Log::error('Discord webhook failed: ' . $response->body());
                if ($silent) return false;
                return response()->json(['message' => 'Failed to send message.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Notification error: ' . $e->getMessage());
            if ($silent) return false;
            return response()->json(['message' => 'An error occurred.'], 500);
        }
    }
}
