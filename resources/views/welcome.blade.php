@extends('layouts.app')

@section('title', 'Align With Sagar | You Know You\'re Meant For More.')

@push('styles')
<style>
    @media (max-width: 1023px) {
        .hero-bg-mobile-custom {
            background-position: 75% center !important;
        }
    }

    .btn-shiny-gold {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #dfd2bc 0%, #b89047 50%, #906e30 100%);
        border: 1px solid rgba(223, 210, 188, 0.8);
        color: #020617 !important;
        box-shadow: 0 0 20px rgba(184, 144, 71, 0.2);
        transition: all 0.3s ease;
    }
    .btn-shiny-gold::after {
        content: '';
        position: absolute;
        top: 0;
        left: -150%;
        width: 50%;
        height: 100%;
        background: linear-gradient(
            to right,
            rgba(255, 255, 255, 0) 0%,
            rgba(255, 255, 255, 0.6) 50%,
            rgba(255, 255, 255, 0) 100%
        );
        transform: skewX(-25deg);
        animation: shine 4s infinite;
    }
    @keyframes shine {
        0% { left: -150%; }
        12% { left: 150%; }
        100% { left: 150%; }
    }
</style>
@endpush

@section('background')
    <!-- Dynamic Background Decor (Nebula glows) -->
    <div class="fixed top-0 left-0 w-full h-full -z-20 bg-[#020617] overflow-hidden pointer-events-none">
        <div class="absolute top-[10%] right-[-10%] w-[600px] h-[600px] bg-primary/10 rounded-full filter blur-[150px] animate-pulse"></div>
        <div class="absolute bottom-[10%] left-[-10%] w-[700px] h-[700px] bg-cyan-500/5 rounded-full filter blur-[180px] animate-pulse duration-[8000ms]"></div>
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-black"></div>
    </div>
@endsection

@section('content')

    <!-- HERO / BANNER SECTION -->
    <section id="home" class="relative min-h-screen flex items-center pt-28 pb-20 overflow-hidden bg-[#020617]">
        <!-- Full-screen background image -->
        <div class="absolute inset-0 bg-cover bg-center lg:bg-center bg-no-repeat z-0 opacity-90 hero-bg-mobile-custom" style="background-image: url('{{ asset('images/Banner-Image-Home.jpeg') }}');"></div>
        
        <!-- Left-to-right dark gradient overlay to blend the image and make text readable -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#020617] via-[#020617]/60 to-transparent z-10"></div>
        <!-- Bottom-to-top gradient for section blending -->
        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent z-10 opacity-80"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
            <div class="max-w-3xl space-y-8 reveal active lg:bg-transparent bg-transparent lg:p-0 p-6 sm:p-8 rounded-2xl backdrop-blur-none lg:backdrop-blur-none border-none lg:border-none shadow-none lg:shadow-none">
                
                <!-- Spaced Subheading Tagline -->
                <div class="flex items-center gap-3">
                    <span class="w-8 h-[1px] bg-primary"></span>
                    <span class="text-[10px] font-bold tracking-[0.25em] text-primary uppercase">Align Your Mind. Design Your Future.</span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-[1.15] tracking-tight text-white font-sans">
                    You Know You're Meant For More.
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-[#22d3ee] drop-shadow-[0_0_15px_rgba(6,182,212,0.3)]">So Why Do You Still Feel Stuck?</span>
                </h1>
                
                <div class="w-20 h-0.5 bg-primary/50"></div>

                <!-- Symptoms and context -->
                <div class="space-y-4 text-gray-300 text-sm sm:text-base leading-relaxed font-light">
                    <p>
                        You've read the books. <br>
                        You've watched the videos. <br>
                        You've set goals before.
                    </p>
                    <p class="text-white font-semibold">
                        Yet somehow, you keep finding yourself in the same place.
                    </p>
                </div>

                <!-- Symptoms tags -->
                <div class="flex flex-wrap gap-2.5 pt-2">
                    <span class="px-3.5 py-2 rounded-lg bg-white/5 border border-white/10 text-xs font-medium text-gray-300 backdrop-blur-md">Overthinking</span>
                    <span class="px-3.5 py-2 rounded-lg bg-white/5 border border-white/10 text-xs font-medium text-gray-300 backdrop-blur-md">Second-guessing yourself</span>
                    <span class="px-3.5 py-2 rounded-lg bg-white/5 border border-white/10 text-xs font-medium text-gray-300 backdrop-blur-md">Starting and stopping</span>
                    <span class="px-3.5 py-2 rounded-lg bg-white/5 border border-white/10 text-xs font-medium text-gray-300 backdrop-blur-md">Waiting for the "right time"</span>
                </div>

                <!-- Realization transition -->
                <div class="space-y-3 border-l-2 border-primary/50 pl-5 py-1">
                    <span class="text-[9px] font-bold uppercase tracking-widest text-gray-500 block">The truth is...</span>
                    <p class="text-base text-gray-200 leading-snug">You don't need more motivation.</p>
                    <p class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-[#14b8a6] tracking-tight">You need alignment.</p>
                </div>

                <!-- Summary helper paragraph -->
                <!-- <p class="text-gray-300 text-sm sm:text-base leading-relaxed font-light">
                    I help people align their thoughts, emotions, identity, and actions so they can finally move forward with clarity, confidence, and momentum.
                </p> -->

                <!-- CTA Button -->
                <div class="pt-4 text-center lg:text-left">
                    <a href="https://wa.me/916291373748?text=Hello%20Sagar,%20I%20want%20to%20book%20an%20alignment%20call." target="_blank" class="px-8 py-4 rounded text-black font-bold tracking-wider uppercase text-xs inline-block btn-shiny-gold">
                        Book Your Alignment Call ➔
                    </a>
                </div>
            </div>
        </div>
    </section>


    <!-- THE INVISIBLE STRUGGLE SECTION -->
    <section id="invisible-struggle" class="py-24 relative overflow-hidden border-t border-white/5 bg-[#020617]">
        <!-- Full-screen background image for Section -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0 opacity-90" style="background-image: url('{{ asset('images/the-invisible-strugle.jpeg') }}');"></div>
        
        <!-- Dark gradient overlays to keep text readable -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#020617] via-[#020617]/85 to-transparent z-10"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-[#020617] z-10 opacity-90"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Column: Tagline & Headline -->
                <div class="lg:col-span-5 space-y-6 reveal">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-[1px] bg-primary"></span>
                        <span class="text-[10px] font-bold tracking-[0.25em] text-primary uppercase">The Invisible Struggle</span>
                    </div>
                    
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-sans tracking-tight text-white leading-tight">
                        From The Outside, <br>
                        Everything Looks Fine.
                    </h2>
                    
                    <p class="text-gray-400 text-sm sm:text-base leading-relaxed font-light">
                        To family, friends, and colleagues, you have it all under control. You play your part. Nobody sees the internal friction.
                    </p>
                    
                    <div class="text-[#c5a880] text-xs font-semibold uppercase tracking-wider">
                        But inside...
                    </div>
                </div>

                <!-- Right Column: Symptom Cards -->
                <div class="lg:col-span-7 space-y-4 reveal animate-delay-200" style="transition-delay: 150ms">
                    <!-- Card 1: Drifting -->
                    <div class="glass p-6 rounded-lg border border-white/5 hover:border-primary/20 transition-all duration-300 flex gap-4 items-start group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary flex-shrink-0 drop-shadow-[0_0_4px_rgba(6,182,212,0.2)]">
                            <i class="fas fa-wind text-sm"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-white font-bold tracking-wider text-xs uppercase">Drifting</h3>
                            <p class="text-gray-400 text-xs sm:text-sm leading-relaxed font-light">
                                You feel like you're drifting. You have dreams that excite you, but they never seem to become reality.
                            </p>
                        </div>
                    </div>

                    <!-- Card 2: Fading Momentum -->
                    <div class="glass p-6 rounded-lg border border-white/5 hover:border-primary/20 transition-all duration-300 flex gap-4 items-start group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary flex-shrink-0 drop-shadow-[0_0_4px_rgba(6,182,212,0.2)]">
                            <i class="fas fa-tachometer-alt text-sm"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-white font-bold tracking-wider text-xs uppercase">Fading Momentum</h3>
                            <p class="text-gray-400 text-xs sm:text-sm leading-relaxed font-light">
                                You start things with enthusiasm, then lose momentum. You make plans, then abandon them.
                            </p>
                        </div>
                    </div>

                    <!-- Card 3: Subconscious Blocks -->
                    <div class="glass p-6 rounded-lg border border-white/5 hover:border-primary/20 transition-all duration-300 flex gap-4 items-start group">
                        <div class="w-10 h-10 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary flex-shrink-0 drop-shadow-[0_0_4px_rgba(6,182,212,0.2)]">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <div class="space-y-1">
                            <h3 class="text-white font-bold tracking-wider text-xs uppercase">Subconscious Blocks</h3>
                            <p class="text-gray-400 text-xs sm:text-sm leading-relaxed font-light">
                                You know what needs to be done, but something always seems to hold you back.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Section: Yearly Cycle & Core Truth -->
            <div class="mt-20 max-w-4xl mx-auto space-y-8 text-center reveal" style="transition-delay: 250ms">
                <!-- Yearly Cycle Card -->
                <div class="glass rounded-xl p-8 sm:p-10 border border-white/5 shadow-lg relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary/5 rounded-full filter blur-[40px] pointer-events-none"></div>
                    <div class="space-y-3">
                        <p class="text-gray-400 text-sm leading-relaxed font-light">Every year begins with hope.</p>
                        <p class="text-lg sm:text-xl text-white font-semibold">Every year ends with the same question:</p>
                        <p class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-[#14b8a6] tracking-tight drop-shadow-[0_0_15px_rgba(6,182,212,0.2)]">
                            "Why am I still here?"
                        </p>
                    </div>
                </div>

                <!-- Final Core Truth Statement -->
                <div class="pt-6">
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-bold block">And the hardest part?</p>
                    <p class="text-2xl sm:text-3xl font-serif italic text-white leading-relaxed mt-2 font-light">
                        You know you're capable of more. <br class="sm:hidden"> <span class="text-primary font-bold not-italic">Much more.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>


    <!-- THE REAL PROBLEM SECTION -->
    <section id="real-problem" class="py-24 relative border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 w-full">
            
            <!-- Category Tag -->
            <div class="text-center max-w-3xl mx-auto mb-16 reveal">
                <p class="text-primary font-bold uppercase tracking-[0.25em] text-[10px] mb-3">The Real Problem</p>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold font-sans tracking-tight text-white">
                    You Are Simply Out of Alignment.
                </h2>
                <div class="w-16 h-0.5 bg-primary/40 mx-auto mt-4"></div>
            </div>

            <!-- Debunking Myths Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <!-- Card 1: Not Lazy -->
                <div class="glass p-6 rounded-lg border border-white/5 text-center space-y-4 hover:border-red-500/20 transition-all">
                    <div class="w-12 h-12 rounded-full bg-red-950/20 border border-red-500/30 flex items-center justify-center mx-auto text-red-500 relative">
                        <i class="fas fa-bed text-sm"></i>
                        <div class="absolute inset-0 flex items-center justify-center text-red-600"><i class="fas fa-ban text-lg"></i></div>
                    </div>
                    <h3 class="text-white font-bold tracking-wider text-xs uppercase">You Are Not Lazy.</h3>
                </div>

                <!-- Card 2: Not Broken -->
                <div class="glass p-6 rounded-lg border border-white/5 text-center space-y-4 hover:border-cyan-500/20 transition-all">
                    <div class="w-12 h-12 rounded-full bg-cyan-950/20 border border-cyan-500/30 flex items-center justify-center mx-auto text-cyan-400 drop-shadow-[0_0_6px_rgba(6,182,212,0.3)]">
                        <i class="fas fa-heart text-sm"></i>
                    </div>
                    <h3 class="text-white font-bold tracking-wider text-xs uppercase">You Are Not Broken.</h3>
                </div>

                <!-- Card 3: Not Lacking Potential -->
                <div class="glass p-6 rounded-lg border border-white/5 text-center space-y-4 hover:border-[#af863f]/20 transition-all">
                    <div class="w-12 h-12 rounded-full bg-yellow-950/20 border border-[#af863f]/30 flex items-center justify-center mx-auto text-[#af863f]">
                        <i class="fas fa-star text-sm animate-spin-slow"></i>
                    </div>
                    <h3 class="text-white font-bold tracking-wider text-xs uppercase">You Are Not Lacking Potential.</h3>
                </div>
            </div>

            <!-- Alignment Pipeline Header -->
            <div class="mt-24 text-center max-w-2xl mx-auto reveal" style="transition-delay: 100ms">
                <p class="text-gray-400 text-sm font-light leading-relaxed">
                    Most people think success is about working harder. It's not.
                </p>
                <p class="text-lg text-white font-bold mt-2">
                    Success happens when your core layers all move in the same direction:
                </p>
            </div>

            <!-- Horizontal Flow Pipeline (Thoughts -> Emotions -> Identity -> Decisions -> Actions) -->
            <div class="mt-12 max-w-5xl mx-auto reveal" style="transition-delay: 150ms">
                <div class="glass rounded-xl p-8 border border-white/5 grid grid-cols-2 md:grid-cols-5 gap-6 text-center items-center shadow-lg relative">
                    <!-- Thoughts -->
                    <div class="flex flex-col items-center space-y-3 relative group">
                        <div class="w-14 h-14 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.25)]">
                            <i class="fas fa-brain text-lg animate-pulse"></i>
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Thoughts</span>
                    </div>

                    <!-- Emotions -->
                    <div class="flex flex-col items-center space-y-3 relative group">
                        <div class="w-14 h-14 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.25)]">
                            <i class="fas fa-heart text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Emotions</span>
                    </div>

                    <!-- Identity -->
                    <div class="flex flex-col items-center space-y-3 relative group">
                        <div class="w-14 h-14 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.25)]">
                            <i class="fas fa-user-circle text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Identity</span>
                    </div>

                    <!-- Decisions -->
                    <div class="flex flex-col items-center space-y-3 relative group">
                        <div class="w-14 h-14 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.25)]">
                            <i class="fas fa-code-branch text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Decisions</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col items-center space-y-3 relative group">
                        <div class="w-14 h-14 rounded-full bg-primary/10 border border-primary/20 flex items-center justify-center text-primary group-hover:scale-110 transition-all duration-300 drop-shadow-[0_0_8px_rgba(6,182,212,0.25)]">
                            <i class="fas fa-arrow-circle-right text-lg"></i>
                        </div>
                        <span class="text-xs font-bold text-white uppercase tracking-wider">Actions</span>
                    </div>
                </div>
            </div>

            <!-- Car pedal analogy split container -->
            <div class="mt-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-5xl mx-auto">
                <div class="space-y-6 reveal" style="transition-delay: 200ms">
                    <span class="text-[9px] font-bold tracking-widest text-[#c5a880] uppercase">The Car Analogy</span>
                    <h3 class="text-2xl font-bold text-white">When They Don't Move Together...</h3>
                    <p class="text-gray-400 text-sm sm:text-base leading-relaxed font-light">
                        Life feels like driving with one foot on the accelerator and one foot on the brake. 
                    </p>
                    <p class="text-gray-400 text-sm sm:text-base leading-relaxed font-light">
                        No matter how hard you push, progress feels exhausting. That's why motivation fades. That's why discipline feels difficult. That's why change never lasts.
                    </p>
                </div>

                <!-- Custom Dashboard Pedals Visual Graphic -->
                <div class="reveal" style="transition-delay: 250ms">
                    <div class="glass p-8 rounded-xl border border-white/5 relative flex justify-around items-center max-w-sm mx-auto shadow-lg min-h-[180px]">
                        <!-- Left Pedal: Brake -->
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-12 h-24 bg-red-950/20 border border-red-500/40 rounded shadow-[0_0_15px_rgba(239,68,68,0.15)] flex flex-col justify-end p-2 relative group transform translate-y-3 transition-transform">
                                <div class="w-full h-8 bg-red-500 rounded-sm"></div>
                            </div>
                            <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Brake</span>
                            <span class="text-[8px] text-gray-500 uppercase">Misalignment</span>
                        </div>

                        <!-- Friction line glows in the center -->
                        <div class="flex flex-col items-center justify-center text-red-500 animate-pulse">
                            <i class="fas fa-exchange-alt text-2xl"></i>
                            <span class="text-[8px] font-bold uppercase tracking-widest mt-1 text-red-400">Friction</span>
                        </div>

                        <!-- Right Pedal: Accelerator -->
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-10 h-28 bg-cyan-950/20 border border-cyan-500/40 rounded shadow-[0_0_15px_rgba(6,182,212,0.15)] flex flex-col justify-end p-2 relative group transform translate-y-4 transition-transform">
                                <div class="w-full h-8 bg-primary rounded-sm"></div>
                            </div>
                            <span class="text-[10px] font-bold text-primary uppercase tracking-widest">Gas</span>
                            <span class="text-[8px] text-gray-500 uppercase">Effort</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consequences Row -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto reveal" style="transition-delay: 200ms">
                <!-- Motivation fades -->
                <div class="glass p-6 rounded-lg border border-white/5 flex gap-4 items-center group">
                    <div class="w-10 h-10 rounded-full bg-red-950/20 border border-red-500/20 flex items-center justify-center text-red-400 flex-shrink-0">
                        <i class="fas fa-fire-alt text-sm"></i>
                    </div>
                    <span class="text-gray-300 font-medium text-xs uppercase tracking-wide">Motivation Fades</span>
                </div>

                <!-- Discipline difficult -->
                <div class="glass p-6 rounded-lg border border-white/5 flex gap-4 items-center group">
                    <div class="w-10 h-10 rounded-full bg-yellow-950/20 border border-yellow-500/20 flex items-center justify-center text-yellow-400 flex-shrink-0">
                        <i class="fas fa-dumbbell text-sm"></i>
                    </div>
                    <span class="text-gray-300 font-medium text-xs uppercase tracking-wide">Discipline feels difficult</span>
                </div>

                <!-- Change never lasts -->
                <div class="glass p-6 rounded-lg border border-white/5 flex gap-4 items-center group">
                    <div class="w-10 h-10 rounded-full bg-cyan-950/20 border border-cyan-500/20 flex items-center justify-center text-cyan-400 flex-shrink-0">
                        <i class="fas fa-hourglass-end text-sm"></i>
                    </div>
                    <span class="text-gray-300 font-medium text-xs uppercase tracking-wide">Change never lasts</span>
                </div>
            </div>

            <!-- Core Callout -->
            <div class="mt-20 max-w-3xl mx-auto text-center reveal" style="transition-delay: 250ms">
                <div class="bg-gradient-to-r from-primary/10 to-cyan-500/5 rounded-xl p-8 border border-primary/20 shadow-lg">
                    <p class="text-gray-400 text-xs uppercase tracking-widest font-bold block">The Bottom Line</p>
                    <p class="text-2xl sm:text-3xl font-serif text-white font-medium leading-relaxed mt-2">
                        The problem isn't effort. <br class="sm:hidden"> The real problem is <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#b89047] to-[#af863f] font-bold">misalignment.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>

@endsection
