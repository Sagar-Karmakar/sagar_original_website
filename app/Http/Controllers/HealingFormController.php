<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\HealingFormSubmission;
use Illuminate\Support\Facades\Log;

class HealingFormController extends Controller
{
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'reason' => 'required|string',
        ]);

        try {
            // Send Email
            Mail::to('hello@sagarkarmakar.com')->send(new HealingFormSubmission($request->all()));

            return response()->json(['message' => 'Form submitted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Healing Form Mail Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send email. Please try again later.'], 500);
        }
    }
}
