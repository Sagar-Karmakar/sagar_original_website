@extends('layouts.app')

@section('title', 'This Is Not Laziness | Review Copy')

@push('styles')
<style>
    /* Book 3D Effect */
    .book-cover-3d {
        border-radius: 4px;
        box-shadow: 
            -10px 10px 20px rgba(0,0,0,0.5),
            -2px 2px 4px rgba(255,255,255,0.1) inset;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        transform: perspective(1000px) rotateY(-5deg);
    }
    .book-cover-3d:hover {
        transform: perspective(1000px) rotateY(0deg) translateY(-5px);
        box-shadow: 
            0 20px 40px rgba(0,0,0,0.4),
            0 0 20px rgba(129, 140, 248, 0.2); 
    }
</style>
@endpush

@section('background')
    <!-- Background Elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-0 right-0 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[120px] opacity-10 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-[120px] opacity-10 animate-blob"></div>
    </div>
@endsection

@section('menu')
    <a href="#pricing" class="px-5 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/10 text-white text-sm font-medium transition-all">
        Get Review Copy
    </a>
@endsection

@section('content')
    <!-- Hero -->
    <header class="pt-32 pb-20 lg:pt-48 lg:pb-32 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                
                <!-- Content -->
                <div class="lg:w-1/2 text-center lg:text-left reveal active">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-xs font-bold tracking-widest uppercase mb-8">
                        Reviewers Edition
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-bold mb-6 leading-tight">
                        This Is Not <br>
                        <span class="text-gradient font-serif italic">Laziness.</span>
                    </h1>
                    
                    <p class="text-xl text-gray-400 mb-8 font-light leading-relaxed">
                        Why you procrastinate on the things that matter most, <br class="hidden lg:block">
                        and how to make action feel natural again.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center lg:items-start gap-4 justify-center lg:justify-start">
                        <button onclick="scrollToPricing()" class="px-8 py-4 rounded-full bg-white text-dark font-bold hover:bg-gray-200 transition-colors shadow-lg shadow-white/5 flex items-center gap-2">
                            Start Reading Free <i class="ph-bold ph-arrow-right"></i>
                        </button>
                        <span class="text-sm text-gray-500 uppercase tracking-widest py-4">Open Access</span>
                    </div>
                </div>

                <!-- Book Image -->
                <div class="lg:w-1/2 flex justify-center reveal active" style="transition-delay: 200ms;">
                    <div class="relative group">
                        <!-- Removed fake background glow -->
                        <img src="{{ asset('images/this-is-not-laziness-cover.png') }}" 
                             alt="Book Cover" 
                             class="relative z-10 w-[300px] md:w-[360px] max-w-full drop-shadow-2xl hover:scale-105 transition-transform duration-500"
                             onerror="this.src='https://placehold.co/400x600/1e293b/e2e8f0?text=Cover+Image+Missing';">
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- The Problem (Hook) -->
    <section class="py-24 bg-black/20">
        <div class="max-w-3xl mx-auto px-4 text-center reveal">
            <div class="space-y-6 text-xl md:text-2xl text-gray-300 font-light leading-relaxed">
                <p>You already know what you need to do.</p>
                <p>You’ve known for a while.</p>
                <p class="text-white font-medium">It’s not unclear. It’s not complicated.</p>
                
                <div class="my-12 p-8 glass rounded-2xl border-l-4 border-secondary">
                    <p class="font-serif text-3xl text-white italic">
                        "And yet, somehow, you’re still not doing it."
                    </p>
                </div>
            </div>

            <div class="mt-16 grid gap-6 text-left max-w-lg mx-auto">
                <div class="flex gap-4 items-start text-gray-400 reveal" style="transition-delay: 100ms;">
                    <i class="ph-fill ph-x-circle text-red-400 text-xl mt-1"></i>
                    <p>Maybe you told yourself you’re just undisciplined.</p>
                </div>
                <div class="flex gap-4 items-start text-gray-400 reveal" style="transition-delay: 200ms;">
                    <i class="ph-fill ph-x-circle text-red-400 text-xl mt-1"></i>
                    <p>Maybe you blamed your habits, your routine, or your phone.</p>
                </div>
                <div class="flex gap-4 items-start text-gray-400 reveal" style="transition-delay: 300ms;">
                    <i class="ph-fill ph-x-circle text-red-400 text-xl mt-1"></i>
                    <p>Maybe you promised yourself you’d “get serious” next Monday.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- The Insight -->
    <section class="py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/5 to-transparent opacity-30"></div>
        
        <div class="max-w-4xl mx-auto px-4 text-center reveal">
            <div class="inline-flex items-center justify-center p-3 mb-8 bg-secondary/10 rounded-full">
                <i class="ph-fill ph-lightbulb text-3xl text-secondary"></i>
            </div>
            
            <h2 class="text-3xl md:text-5xl font-bold mb-8">The Truth Most Advice Never Tells You</h2>
            
            <div class="prose prose-xl prose-invert mx-auto text-gray-300">
                <p class="mb-6">
                    You are not procrastinating because you’re lazy.
                </p>
                <p class="mb-8">
                    You are procrastinating because some part of you believes that <span class="text-white underline decoration-secondary underline-offset-4">taking action will cost you something you can’t afford to lose.</span>
                </p>
                
                <div class="grid md:grid-cols-2 gap-8 mt-16 text-left">
                    <div class="glass p-8 rounded-2xl hover:bg-white/5 transition-colors">
                        <h3 class="text-xl font-bold text-white mb-2">Old Question</h3>
                        <p class="font-serif italic text-2xl text-gray-400">“Why can’t I just do it?”</p>
                        <p class="text-sm text-gray-500 mt-4">Leads to shame and force.</p>
                    </div>
                    <div class="glass p-8 rounded-2xl border border-secondary/30 relative">
                        <div class="absolute -top-3 -right-3 bg-secondary text-dark text-xs font-bold px-3 py-1 rounded-full">TRY THIS</div>
                        <h3 class="text-xl font-bold text-white mb-2">New Question</h3>
                        <p class="font-serif italic text-2xl text-secondary">“What does this task threaten inside me?”</p>
                        <p class="text-sm text-gray-400 mt-4">Leads to safety and release.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What's Inside -->
    <section class="py-24 bg-black/40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <h2 class="text-3xl font-bold mb-8">This book is <span class="text-gradient">precision</span>.</h2>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="bg-primary/20 p-2 rounded-lg text-primary"><i class="ph-bold ph-check"></i></div>
                            <div>
                                <h4 class="text-white font-bold">The Anatomy of Resistance</h4>
                                <p class="text-gray-400 text-sm">See exactly how procrastination starts in the body before it reaches the mind.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-primary/20 p-2 rounded-lg text-primary"><i class="ph-bold ph-check"></i></div>
                            <div>
                                <h4 class="text-white font-bold">The 4 Internal Threats</h4>
                                <p class="text-gray-400 text-sm">Identify which specific fear (Failure, Success, Loss of Control, or Separation) is blocking you.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-primary/20 p-2 rounded-lg text-primary"><i class="ph-bold ph-check"></i></div>
                            <div>
                                <h4 class="text-white font-bold">The 14-Day Reset</h4>
                                <p class="text-gray-400 text-sm">A gentle, non-aggressive protocol to restore trust with yourself—without burning out.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="glass p-1 h-full rounded-2xl reveal relative" style="transition-delay: 100ms;">
                     <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent rounded-2xl pointer-events-none"></div>
                     <div class="bg-dark/80 backdrop-blur-md rounded-xl p-8 h-full flex flex-col justify-center items-center text-center">
                        <i class="ph-duotone ph-quotes text-6xl text-gray-700 mb-6"></i>
                        <p class="text-xl text-gray-300 font-serif italic mb-6">
                            "I stopped trying to force myself to work, and started asking why I was resisting. The work just... happened."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center">S</div>
                            <span class="text-sm font-bold text-gray-500">Early Reader</span>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main CTA / Form -->
    <section id="pricing" class="py-24 relative">
        <div class="max-w-4xl mx-auto px-4 z-10 relative">
            <div class="text-center mb-12 reveal">
                <span class="text-secondary font-bold tracking-wider text-sm uppercase">Limited Access</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-4">Start Reading Today</h2>
                <p class="text-gray-400">No payment required. Just an open mind.</p>
            </div>

            <div class="glass rounded-3xl overflow-hidden shadow-2xl shadow-primary/10 reveal transform transition-all hover:scale-[1.01]">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-12">
                        
                        <!-- Details -->
                        <div class="md:w-1/2 border-b md:border-b-0 md:border-r border-white/10 pb-8 md:pb-0 md:pr-8">
                            <h3 class="text-2xl font-bold text-white mb-6">Reviewer Package</h3>
                            <ul class="space-y-4 text-gray-300">
                                <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-secondary rounded-full"></span> Full Digital PDF Book</li>
                                <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-secondary rounded-full"></span> The 14-Day Reset Protocol</li>
                                <li class="flex items-center gap-3"><span class="w-1.5 h-1.5 bg-secondary rounded-full"></span> Internal Resistance Framework</li>
                            </ul>
                            
                            <div class="mt-8 pt-8 border-t border-white/10">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-4xl font-bold text-white">Free</span>
                                    <span class="text-lg text-gray-500 line-through decoration-red-500/50 decoration-2">$249</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">100% discount applied for reviewers.</p>
                            </div>
                        </div>

                        <!-- Form -->
                        <div class="md:w-1/2 flex flex-col justify-center">
                            @if(session('success'))
                                <div class="bg-green-900/20 border border-green-500/30 text-green-200 p-6 rounded-xl mb-6 text-center">
                                    <i class="ph-fill ph-check-circle text-2xl mb-2 block"></i>
                                    {!! session('success') !!}
                                </div>
                            @endif

                            <form action="{{ route('book.send') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Full Name</label>
                                    <input type="text" name="name" required placeholder="Your Name"
                                           class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder-gray-600">
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">Email Address</label>
                                    <input type="email" name="email" required placeholder="you@example.com"
                                           class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder-gray-600">
                                </div>
                                
                                <div>
                                    <label class="block text-sm text-gray-400 mb-1">WhatsApp / Phone Number</label>
                                    <input type="text" name="phone" required placeholder="+91 98765 43210"
                                           class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors placeholder-gray-600">
                                </div>

                                <button type="submit" class="w-full bg-white text-dark font-bold text-lg py-3 rounded-lg hover:bg-gray-200 transition-colors mt-2 shadow-lg shadow-white/5">
                                    I want the book to review
                                </button>
                                
                                <p class="text-center text-xs text-gray-500 mt-4">
                                    By resetting, you agree to treat yourself with patience.
                                </p>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function scrollToPricing() {
            document.getElementById('pricing').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
@endpush
