@extends('layouts.app')

@section('title', 'Relationship Insights | Sagar Karmakar')

@section('content')
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 bg-[#042f2e] overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
        <div class="absolute bottom-1/4 right-10 w-72 h-72 bg-secondary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
    </div>

    <!-- Insights Content -->
    <section class="min-h-screen pt-32 pb-24 relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-16 reveal">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">Relationship Insights</h1>
                <div class="w-20 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>

            <div class="glass rounded-3xl p-8 md:p-14 reveal shadow-2xl shadow-black/50 border-t border-primary/20">
                <div class="space-y-8 text-lg text-gray-300 leading-relaxed font-light">
                    
                    <p class="text-xl md:text-2xl text-white font-medium text-center mb-10">
                        This space is dedicated to exploring the psychology of relationships.
                    </p>

                    <p>
                        Here you will find ideas and reflections about:
                    </p>
                    
                    <div class="my-10 p-8 bg-dark/40 rounded-2xl border border-white/5 mx-auto max-w-2xl">
                        <ul class="space-y-4 text-lg">
                            <li class="flex items-center gap-4 text-white group">
                                <span class="w-2 h-2 rounded-full bg-secondary group-hover:scale-150 transition-transform"></span>
                                building healthy relationships
                            </li>
                            <li class="flex items-center gap-4 text-white group">
                                <span class="w-2 h-2 rounded-full bg-primary group-hover:scale-150 transition-transform"></span>
                                understanding emotional patterns
                            </li>
                            <li class="flex items-center gap-4 text-white group">
                                <span class="w-2 h-2 rounded-full bg-secondary group-hover:scale-150 transition-transform"></span>
                                developing emotional maturity
                            </li>
                            <li class="flex items-center gap-4 text-white group">
                                <span class="w-2 h-2 rounded-full bg-primary group-hover:scale-150 transition-transform"></span>
                                strengthening communication
                            </li>
                            <li class="flex items-center gap-4 text-white group">
                                <span class="w-2 h-2 rounded-full bg-secondary group-hover:scale-150 transition-transform"></span>
                                recognizing toxic dynamics
                            </li>
                        </ul>
                    </div>

                    <p class="text-center italic text-xl">
                        The goal is not simply to give advice, but to help people understand relationships more deeply.
                    </p>
                </div>
                
                <div class="mt-14 pt-10 border-t border-white/10 text-center">
                    <p class="text-2xl font-bold text-gradient font-serif tracking-wide">
                        Because when understanding grows, better choices follow.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
