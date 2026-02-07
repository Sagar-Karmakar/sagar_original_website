@extends('layouts.app')

@section('title', 'Check Your Inbox')

@section('background')
    <!-- Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[120px] opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-[120px] opacity-10 animate-blob"></div>
    </div>
@endsection

@section('menu')
    <a href="{{ url('/') }}" class="text-sm font-medium hover:text-white transition-colors text-gray-300">Return Home</a>
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full glass rounded-2xl p-8 md:p-12 text-center reveal active relative overflow-hidden">
        
        <!-- Glow Effect -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent"></div>

        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-500/20 text-green-400 mb-6">
            <i class="ph-fill ph-check text-3xl"></i>
        </div>

        <h1 class="text-3xl font-bold text-white mb-4">It's on the way.</h1>
        
        <p class="text-gray-300 mb-8 leading-relaxed">
            I've sent the PDF to <br>
            <span class="text-white font-medium bg-white/10 px-2 py-0.5 rounded">{{ session('email') ?? 'your email' }}</span>.
        </p>

        @if(session('waLink'))
            <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-8">
                <p class="text-sm text-gray-400 mb-4">Prefer to get it on WhatsApp directly?</p>
                <a href="{{ session('waLink') }}" target="_blank" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-[#25D366] text-white font-bold hover:bg-[#128C7E] transition-colors gap-2">
                    <i class="ph-fill ph-whatsapp-logo text-xl"></i> Ask Sagar for the Book
                </a>
            </div>
        @endif

        <p class="text-sm text-gray-500 mb-8">
            Please check your Spam/Promotions folder if it doesn't arrive within 2 minutes.
        </p>
        
        <div class="pt-8 border-t border-white/10 space-y-4">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">
                &larr; Return to Home
            </a>
            <div class="text-xs text-gray-600 space-x-2">
                <a href="{{ route('privacy') }}" class="hover:text-gray-500 transition-colors">Privacy Policy</a>
                <span>&bull;</span>
                <a href="{{ route('terms') }}" class="hover:text-gray-500 transition-colors">Terms</a>
            </div>
        </div>
    </div>
</div>
@endsection
