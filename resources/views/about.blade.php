@extends('layouts.app')

@section('title', 'About Sagar Karmakar')

@section('content')
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 bg-[#042f2e] overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
        <div class="absolute bottom-1/4 right-10 w-72 h-72 bg-secondary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
    </div>

    <!-- About Content -->
    <section class="min-h-screen pt-32 pb-24 relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-16 reveal">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">About Sagar</h1>
                <div class="w-20 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>

            <div class="glass rounded-3xl p-8 md:p-14 reveal shadow-2xl shadow-black/50 border-t border-primary/20">
                <div class="space-y-8 text-lg text-gray-300 leading-relaxed font-light">
                    
                    <p class="text-2xl font-serif text-white italic text-center mb-10">
                        My name is Sagar Karmakar.
                    </p>

                    <p>
                        I believe that the quality of our lives is deeply connected to the quality of our relationships.
                    </p>
                    
                    <div class="flex flex-col md:flex-row gap-6 justify-center my-10 py-8 border-y border-white/10">
                        <div class="text-center md:text-right flex-1 border-b md:border-b-0 md:border-r border-white/10 pb-6 md:pb-0 md:pr-6">
                            <i class="fas fa-user mb-4 text-3xl text-secondary"></i>
                            <p class="font-medium text-white">The relationship we have with ourselves.</p>
                        </div>
                        <div class="text-center md:text-left flex-1 pt-6 md:pt-0 md:pl-6">
                            <i class="fas fa-users mb-4 text-3xl text-primary"></i>
                            <p class="font-medium text-white">The relationship we have with others.</p>
                        </div>
                    </div>

                    <p>
                        When these relationships are healthy, life becomes more peaceful, meaningful, and aligned.
                    </p>
                    
                    <p>
                        But many people struggle with relationships not because they are incapable of love, but because they were never taught the skills required to build healthy relationships.
                    </p>

                    <div class="my-10 p-8 bg-dark/40 rounded-2xl border border-white/5">
                        <p class="mb-6 font-medium text-white">That’s why I focus on three key areas:</p>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-4 text-xl font-bold text-white group">
                                <span class="w-2 h-2 rounded-full bg-secondary group-hover:scale-150 transition-transform"></span>
                                Self-Respect
                            </li>
                            <li class="flex items-center gap-4 text-xl font-bold text-white group">
                                <span class="w-2 h-2 rounded-full bg-primary group-hover:scale-150 transition-transform"></span>
                                Emotional Maturity
                            </li>
                            <li class="flex items-center gap-4 text-xl font-bold text-white group">
                                <span class="w-2 h-2 rounded-full bg-secondary group-hover:scale-150 transition-transform"></span>
                                Communication
                            </li>
                        </ul>
                    </div>

                    <p>
                        Through my work, I aim to help people understand the deeper psychology of relationships and develop the awareness needed to create healthier connections.
                    </p>
                    
                    <p class="text-xl font-medium text-primary mt-8">
                        This platform is dedicated to exploring the ideas, patterns, and principles that shape the way we relate to ourselves and others.
                    </p>
                </div>
                
                <div class="mt-14 pt-8 border-t border-white/10 text-center">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-primary text-dark font-bold hover:bg-white hover:text-dark transition-all duration-300 shadow-lg shadow-primary/20 hover:-translate-y-1">
                        Get in Touch <i class="fas fa-paper-plane"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
