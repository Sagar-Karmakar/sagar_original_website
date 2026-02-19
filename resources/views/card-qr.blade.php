@extends('layouts.app')

@section('title', 'Surprise Coming Soon | Sagar Karmakar')

@section('content')
    <section class="min-h-screen flex items-center justify-center relative bg-gradient-to-br from-gray-900 to-black overflow-hidden">
        <!-- Dynamic Background Canvas (Optional, re-using if global js handles it, otherwise just a nice gradient) -->
        <div class="absolute inset-0 bg-[url('/img/noise.png')] opacity-10 mix-blend-overlay"></div>
        
        <!-- Background Blobs -->
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob animation-delay-2000"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <div class="glass p-12 rounded-3xl border border-white/10 shadow-2xl backdrop-blur-xl">
                <i class="fas fa-gift text-6xl text-primary mb-8 animate-bounce"></i>
                
                <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
                    Wait for a <span class="text-gradient">surprise...</span>
                </h1>
                
                <p class="text-gray-300 text-lg md:text-xl mb-12 max-w-2xl mx-auto leading-relaxed">
                    We are building something big for you.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ url('/') }}" class="group px-8 py-4 rounded-full border border-white/20 hover:bg-white/5 transition-all duration-300 backdrop-blur-sm flex items-center justify-center gap-2">
                        <i class="fas fa-home group-hover:-translate-x-1 transition-transform"></i>
                        <span>Go Back Home</span>
                    </a>
                    
                    <a href="{{ url('/healing-form') }}" class="group px-8 py-4 rounded-full bg-white text-dark font-bold hover:bg-gray-200 transition-all duration-300 shadow-lg shadow-white/5 flex items-center justify-center gap-2">
                        <span>Book a Session</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
            
        </div>
    </section>
@endsection
