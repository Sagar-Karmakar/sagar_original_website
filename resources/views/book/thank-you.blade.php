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
    <div class="max-w-2xl w-full glass rounded-3xl p-8 md:p-12 text-center reveal active relative overflow-hidden">
        
        <!-- Glow Effect -->
        <div class="absolute top-0 left-1/2 transform -translate-x-1/2 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent"></div>

        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-500/20 text-green-400 mb-8 animate-bounce">
            <i class="ph-fill ph-check text-4xl"></i>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">You're In.</h1>

        <div class="flex flex-col md:flex-row items-center justify-center gap-8 mb-10">
            <!-- Book Visual -->
            <div class="relative group">
                 <!-- Removed fake background glow -->
                 <img src="{{ asset('images/this-is-not-laziness-cover.png') }}" 
                      alt="Book Cover" 
                      class="relative z-10 w-[180px] drop-shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500"
                      onerror="this.src='https://placehold.co/400x600/1e293b/e2e8f0?text=Cover+Image';">
            </div>

            <div class="text-left max-w-sm">
                 <p class="text-xl text-white font-medium mb-2">You are the lucky person!</p>
                 <p class="text-gray-300 text-sm mb-6 leading-relaxed">
                    You got the chance to review the book. This is the first step to remove procrastination and you showed the initiation.
                 </p>
                 
                 <a href="{{ asset('files/ThisIsNotLaziness_ReviewCopy.pdf') }}" download 
                    class="inline-flex items-center justify-center px-6 py-3 rounded-full bg-white text-dark font-bold hover:bg-gray-200 transition-colors gap-2 shadow-lg shadow-white/10 w-full md:w-auto">
                     <i class="ph-bold ph-download-simple"></i> Download PDF Now
                 </a>
            </div>
        </div>

        @if(session('waLink'))
            <div class="bg-white/5 border border-white/10 rounded-xl p-6 mb-10 mx-auto max-w-lg">
                <p class="text-sm text-gray-400 mb-4">Want to discuss the book or have questions?</p>
                <a href="{{ session('waLink') }}" target="_blank" 
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-lg bg-[#25D366] text-white font-bold hover:bg-[#128C7E] transition-colors gap-2">
                    <i class="ph-fill ph-whatsapp-logo text-xl"></i> Chat on WhatsApp
                </a>
            </div>
        @endif
        
        <div class="pt-8 border-t border-white/10 space-y-4">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">
                &larr; Return to Home
            </a>
            <div class="text-xs text-gray-600 space-x-2">
                <a href="{{ route('privacy') }}" class="hover:text-gray-500 transition-colors">Privacy</a>
                <span>&bull;</span>
                <a href="{{ route('terms') }}" class="hover:text-gray-500 transition-colors">Terms</a>
            </div>
        </div>
    </div>
</div>
@endsection
