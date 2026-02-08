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
        // Gating: Only allow access if session is set (from form submission)
        if (!session('book_download_access')) {
            return redirect()->route('book.landing');
        }
        
        return view('book.thank-you');
    }

    // send method moved to NotificationController
}
