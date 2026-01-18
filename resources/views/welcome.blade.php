<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sagar Karmakar | Clarity & Creation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Tangerine:wght@700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        logo: ['Tangerine', 'cursive'],
                    },
                    colors: {
                        primary: '#818cf8', // Soft Indigo
                        secondary: '#2dd4bf', // Teal (Calm/Healing)
                        dark: '#0f172a',
                        paper: 'rgba(30, 41, 59, 0.7)'
                    },
                    animation: {
                        'blob': 'blob 10s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0f172a;
            color: #e2e8f0;
            overflow-x: hidden;
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }
        ::-webkit-scrollbar-thumb {
            background: #818cf8;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2dd4bf;
        }

        /* Glassmorphism Utilities */
        .glass {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .glass-nav {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Text Gradient */
        .text-gradient {
            background: linear-gradient(to right, #818cf8, #2dd4bf, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% auto;
            animation: gradient 8s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Canvas Positioning */
        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.5;
        }

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .quote-border {
            border-left: 3px solid #2dd4bf;
        }
    </style>
</head>
<body class="antialiased selection:bg-teal-500 selection:text-white">

    <!-- Dynamic Background Canvas -->
    <canvas id="bg-canvas"></canvas>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0 cursor-pointer group" onclick="window.scrollTo(0,0)">
                    <span class="text-5xl font-bold font-logo text-white group-hover:text-primary transition-colors pt-2 block">Sagar</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="#home" class="text-sm font-medium hover:text-primary transition-colors text-gray-300">Start</a>
                        <a href="#story" class="text-sm font-medium hover:text-primary transition-colors text-gray-300">My Story</a>
                        <a href="#philosophy" class="text-sm font-medium hover:text-primary transition-colors text-gray-300">Philosophy</a>
                        <a href="#services" class="text-sm font-medium hover:text-primary transition-colors text-gray-300">Services</a>
                        <a href="#contact" class="px-5 py-2 rounded-full bg-white/5 border border-white/10 hover:bg-white/10 text-white text-sm font-medium transition-all">Work With Me</a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button type="button" onclick="toggleMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-white/10 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Panel -->
        <div class="hidden md:hidden glass border-t border-white/5" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" onclick="toggleMenu()" class="block px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white/10">Start</a>
                <a href="#story" onclick="toggleMenu()" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">My Story</a>
                <a href="#philosophy" onclick="toggleMenu()" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">Philosophy</a>
                <a href="#services" onclick="toggleMenu()" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/10">Services</a>
                <a href="#contact" onclick="toggleMenu()" class="block px-3 py-2 rounded-md text-base font-medium text-secondary hover:text-white hover:bg-white/10">Work With Me</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="min-h-screen flex items-center justify-center relative pt-16">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-[100px] opacity-20 animate-blob animation-delay-2000"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/5 border border-white/10 text-sm tracking-wider text-gray-300 mb-6 animate-float">A HUMAN BECOMING</span>
            
            <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight">
                Clarity. Creation.<br>
                <span class="text-gradient">Freedom.</span>
            </h1>
            
            <p class="text-gray-300 text-lg md:text-xl mb-6 max-w-2xl mx-auto leading-relaxed">
                I help people quiet the noise, find clarity, and move forward with dignity.
                I’m not here to sell a perfect life. I’m here to build a real one.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10">
                <a href="#contact" class="px-8 py-4 rounded-full bg-white text-dark font-bold hover:bg-gray-200 transition-colors shadow-lg shadow-white/5">
                    Work With Me
                </a>
                <a href="#story" class="px-8 py-4 rounded-full border border-white/20 hover:bg-white/5 transition-colors backdrop-blur-sm">
                    Read My Story
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#story" class="text-gray-500 hover:text-white transition-colors">
                <i class="fas fa-arrow-down text-xl"></i>
            </a>
        </div>
    </section>

    <!-- Who I Am & My Story -->
    <section id="story" class="py-24 relative">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Short Intro -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-24 reveal">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Who I Am</h2>
                    <p class="text-lg text-gray-300 leading-relaxed mb-6">
                        I’m a deep thinker, system builder, and guide for people who feel stuck between survival and their real potential.
                    </p>
                    <p class="text-lg text-gray-300 leading-relaxed mb-6">
                        I build tools, conversations, and experiences that help the mind calm down and the next step become obvious.
                        I believe clarity is not motivation — <span class="text-white font-semibold">it’s relief.</span>
                    </p>
                </div>
                <div class="glass p-8 rounded-2xl border-l-4 border-primary">
                    <h3 class="text-xl font-bold mb-4 text-white">My Current Focus</h3>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-center gap-3"><i class="fas fa-check text-primary"></i> Stabilizing people with dignity</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-primary"></i> Building execution habits</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-primary"></i> Creating useful digital tools</li>
                        <li class="flex items-center gap-3"><i class="fas fa-check text-primary"></i> Preparing for deeper work</li>
                    </ul>
                    <p class="mt-6 text-sm italic text-gray-500">"This is a foundation phase — not a performance phase."</p>
                </div>
            </div>

            <!-- The Honest Version -->
            <div class="glass rounded-3xl p-8 md:p-12 reveal">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-3xl font-bold mb-8 text-center"><span class="text-gradient">The Honest Version</span></h2>
                    
                    <div class="space-y-6 text-lg text-gray-300">
                        <p>
                            For years, my life looked like motion on the inside and stagnation on the outside.
                            I could think deeply. Create for hours. Build systems. Imagine futures.
                        </p>
                        <p>
                            But money pressure, family conflict, and constant judgment kept my nervous system in survival mode.
                            I learned something the hard way:
                        </p>
                        
                        <div class="my-8 p-6 bg-white/5 rounded-xl text-center">
                            <h3 class="text-2xl font-serif italic text-white">"When the mind is loud, execution disappears."</h3>
                        </div>

                        <p>
                            So I stopped chasing hacks and started rebuilding fundamentals — safety, rhythm, clarity, and self‑trust.
                            This website is not a highlight reel. It’s a marker of a turning point.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What I Believe -->
    <section id="philosophy" class="py-24 bg-black/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">What I Believe</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal">
                    <i class="fas fa-lightbulb text-3xl text-secondary mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Clarity beats motivation.</h3>
                    <p class="text-gray-400">Motivation is fleeting. Clarity provides the map to keep going.</p>
                </div>
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal" style="transition-delay: 100ms">
                    <i class="fas fa-shield-alt text-3xl text-primary mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Action follows safety.</h3>
                    <p class="text-gray-400">You cannot build a future when your nervous system is fighting for survival.</p>
                </div>
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal" style="transition-delay: 200ms">
                    <i class="fas fa-brain text-3xl text-purple-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Consistency is a skill.</h3>
                    <p class="text-gray-400">It's not about willpower; it's about regulating your nervous system.</p>
                </div>
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal">
                    <i class="fas fa-coins text-3xl text-yellow-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Money is not evil.</h3>
                    <p class="text-gray-400">Fear around money is the problem. Healing and earning can coexist.</p>
                </div>
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal" style="transition-delay: 100ms">
                    <i class="fas fa-shoe-prints text-3xl text-green-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Small honest steps.</h3>
                    <p class="text-gray-400">They compound faster than big fantasies ever will.</p>
                </div>
                <div class="glass p-6 rounded-xl hover:bg-white/5 transition-colors reveal" style="transition-delay: 200ms">
                    <i class="fas fa-feather text-3xl text-pink-400 mb-4"></i>
                    <h3 class="text-xl font-bold mb-2">Quiet change.</h3>
                    <p class="text-gray-400">Real transformation doesn't scream. It whispers and builds.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services / What I Do -->
    <section id="services" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">How I Help</h2>
                <div class="w-16 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>

            <!-- Who I Help -->
            <div class="mb-20 reveal">
                <div class="glass rounded-2xl p-8 border border-white/5 bg-gradient-to-br from-white/5 to-transparent">
                    <h3 class="text-2xl font-bold mb-6 text-center">Is this you?</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-center">
                        <div class="p-4">
                            <i class="fas fa-user-astronaut text-2xl text-gray-400 mb-3"></i>
                            <p class="text-gray-300">Think deeply but feel stuck</p>
                        </div>
                        <div class="p-4">
                            <i class="fas fa-layer-group text-2xl text-gray-400 mb-3"></i>
                            <p class="text-gray-300">Professional with mental overload</p>
                        </div>
                        <div class="p-4">
                            <i class="fas fa-pen-nib text-2xl text-gray-400 mb-3"></i>
                            <p class="text-gray-300">Creator blocked by fear</p>
                        </div>
                        <div class="p-4">
                            <i class="fas fa-heart-broken text-2xl text-gray-400 mb-3"></i>
                            <p class="text-gray-300">Rebuilding after burnout</p>
                        </div>
                    </div>
                    <p class="text-center mt-8 text-primary font-medium">If you feel life is close but untouchable — you’re not alone.</p>
                </div>
            </div>

            <!-- Offerings -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="glass p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-comments text-9xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">1:1 Clarity Sessions</h3>
                    <p class="text-gray-400 mb-6 min-h-[80px]">Short, focused conversations that reduce overthinking and restore direction.</p>
                    <ul class="space-y-2 mb-8 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Calm anxiety</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Fix decision fatigue</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Remove self-doubt</li>
                    </ul>
                </div>

                <!-- Service 2 -->
                <div class="glass p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal" style="transition-delay: 100ms">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-laptop-code text-9xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Tools for the Mind</h3>
                    <p class="text-gray-400 mb-6 min-h-[80px]">Simple digital tools designed to help you focus, reflect, and calm down.</p>
                    <ul class="space-y-2 mb-8 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Practice gratitude</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Regain focus</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Reflect with honesty</li>
                    </ul>
                </div>

                <!-- Service 3 -->
                <div class="glass p-8 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal" style="transition-delay: 200ms">
                    <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="fas fa-pencil-alt text-9xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Writing & Frameworks</h3>
                    <p class="text-gray-400 mb-6 min-h-[80px]">Essays and guides on rebuilding life from survival mode.</p>
                    <ul class="space-y-2 mb-8 text-sm text-gray-300">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Clarity over chaos</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Execution without burnout</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-secondary"></i> Freedom as a practice</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Work With Me / Contact -->
    <section id="contact" class="py-24 relative bg-gradient-to-t from-black/60 to-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Left Side: Options -->
                <div class="reveal">
                    <h2 class="text-4xl font-bold mb-8">Work With Me</h2>
                    
                    <div class="space-y-6">
                        <div class="p-6 glass rounded-xl border-l-4 border-primary hover:bg-white/5 transition-colors cursor-pointer">
                            <h3 class="font-bold text-lg mb-1">Option 1: 15‑Minute Mind Reset</h3>
                            <p class="text-gray-400 text-sm">A short session to calm the mind and clarify the next step.</p>
                        </div>

                        <div class="p-6 glass rounded-xl border-l-4 border-secondary hover:bg-white/5 transition-colors cursor-pointer">
                            <h3 class="font-bold text-lg mb-1">Option 2: Deep Clarity Session (45–60 min)</h3>
                            <p class="text-gray-400 text-sm">For decision‑making, life direction, and emotional regulation.</p>
                        </div>

                        <div class="p-6 glass rounded-xl border-l-4 border-purple-500 hover:bg-white/5 transition-colors cursor-pointer">
                            <h3 class="font-bold text-lg mb-1">Option 3: Custom Tools</h3>
                            <p class="text-gray-400 text-sm">Personalized prompts, frameworks, or clarity systems.</p>
                        </div>
                    </div>

                    <div class="mt-12">
                        <h3 class="font-bold text-xl mb-4 text-white">A Note on Results</h3>
                        <div class="quote-border pl-6 py-2">
                            <p class="text-gray-300 italic mb-4">
                                "I don’t promise miracles. I promise presence, honesty, clarity, and grounded next steps. Real change is quiet at first."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Contact & Gratitude -->
                <div class="reveal">
                    <div class="glass p-8 rounded-2xl mb-8">
                        <h3 class="text-2xl font-bold mb-6">Request a Session</h3>
                        <form onsubmit="event.preventDefault(); sendToWhatsapp();" class="space-y-4">
                            <div>
                                <input type="text" id="contact-name" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="Your Name" required>
                            </div>
                            <div>
                                <input type="email" id="contact-email" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="Email Address" required>
                            </div>
                            <div class="relative">
                                <select id="contact-option" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors appearance-none cursor-pointer">
                                    <option class="bg-slate-900 text-gray-300" value="" disabled selected>Select an option...</option>
                                    <option class="bg-slate-900 text-gray-300" value="15-Minute Mind Reset">15-Minute Mind Reset</option>
                                    <option class="bg-slate-900 text-gray-300" value="Deep Clarity Session">Deep Clarity Session</option>
                                    <option class="bg-slate-900 text-gray-300" value="Custom Tools">Custom Tools</option>
                                    <option class="bg-slate-900 text-gray-300" value="Just saying hello">Just saying hello</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-primary">
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <textarea id="contact-message" rows="4" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="What's on your mind?" required></textarea>
                            </div>
                            <button type="submit" class="w-full bg-white text-dark font-bold py-3 rounded-lg hover:bg-gray-200 transition-colors flex items-center justify-center gap-2">
                                Send Request via WhatsApp <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </button>
                        </form>
                    </div>
                    
                    <div class="text-center md:text-left">
                        <p class="text-gray-400 text-sm mb-2">Or email me directly:</p>
                        <a href="mailto:hello@sagarkarmakar.com" class="text-xl font-bold text-white hover:text-primary transition-colors">hello@sagarkarmakar.com</a>
                    </div>
                </div>
            </div>
            
            <!-- Gratitude Section -->
            <div class="mt-24 text-center max-w-2xl mx-auto reveal">
                <i class="fas fa-infinity text-3xl text-gray-500 mb-6"></i>
                <p class="text-gray-300 text-lg mb-4">
                    If you’re reading this, thank you.<br>
                    This space exists because I chose action over paralysis — one step at a time.
                </p>
                <p class="text-gray-400">
                    If something here resonates, you’re welcome to walk with me for a while.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-white/5 bg-black/40 pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="text-5xl font-bold font-logo text-white">Sagar</span>
                </div>
                <div class="text-gray-500 text-sm flex flex-col items-center md:items-end">
                    <p>&copy; 2026 Sagar Karmakar.</p>
                    <p class="mt-1 text-primary/70">Built with clarity, not noise.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        function sendToWhatsapp() {
            const name = document.getElementById('contact-name').value;
            const email = document.getElementById('contact-email').value;
            const option = document.getElementById('contact-option').value;
            const message = document.getElementById('contact-message').value;

            const phoneNumber = "918961373748";
            
            // Construct the message with proper formatting
            const text = `*New Session Request*\n\n*Name:* ${name}\n*Email:* ${email}\n*Interest:* ${option}\n*Message:* ${message}`;
            
            // Encode the text for URL and open WhatsApp
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        // Mobile Menu Toggle
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Scroll Reveal Animation
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        // Trigger once on load
        reveal();

        // Canvas Particle Network (Slightly slower/calmer for this persona)
        const canvas = document.getElementById('bg-canvas');
        const ctx = canvas.getContext('2d');
        let particlesArray;

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            init();
        });

        const mouse = {
            x: null,
            y: null,
            radius: 150
        }

        window.addEventListener('mousemove', (event) => {
            mouse.x = event.x;
            mouse.y = event.y;
        });

        class Particle {
            constructor(x, y, directionX, directionY, size, color) {
                this.x = x;
                this.y = y;
                this.directionX = directionX;
                this.directionY = directionY;
                this.size = size;
                this.color = color;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
                ctx.fillStyle = '#818cf8'; 
                ctx.fill();
            }
            update() {
                if (this.x > canvas.width || this.x < 0) {
                    this.directionX = -this.directionX;
                }
                if (this.y > canvas.height || this.y < 0) {
                    this.directionY = -this.directionY;
                }

                let dx = mouse.x - this.x;
                let dy = mouse.y - this.y;
                let distance = Math.sqrt(dx*dx + dy*dy);
                
                // Gentle push away from mouse
                if (distance < mouse.radius + this.size){
                    if (mouse.x < this.x && this.x < canvas.width - this.size * 10) {
                        this.x += 1;
                    }
                    if (mouse.x > this.x && this.x > this.size * 10) {
                        this.x -= 1;
                    }
                    if (mouse.y < this.y && this.y < canvas.height - this.size * 10) {
                        this.y += 1;
                    }
                    if (mouse.y > this.y && this.y > this.size * 10) {
                        this.y -= 1;
                    }
                }
                
                this.x += this.directionX;
                this.y += this.directionY;
                this.draw();
            }
        }

        function init() {
            particlesArray = [];
            // Fewer particles for a cleaner look
            let numberOfParticles = (canvas.height * canvas.width) / 12000;
            for (let i = 0; i < numberOfParticles; i++) {
                let size = (Math.random() * 2) + 0.5;
                let x = (Math.random() * ((innerWidth - size * 2) - (size * 2)) + size * 2);
                let y = (Math.random() * ((innerHeight - size * 2) - (size * 2)) + size * 2);
                // Slower movement
                let directionX = (Math.random() * 0.4) - 0.2; 
                let directionY = (Math.random() * 0.4) - 0.2; 
                let color = '#818cf8';

                particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
            }
        }

        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, innerWidth, innerHeight);

            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update();
            }
            connect();
        }

        function connect() {
            let opacityValue = 1;
            for (let a = 0; a < particlesArray.length; a++) {
                for (let b = a; b < particlesArray.length; b++) {
                    let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x)) + 
                                   ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                    
                    if (distance < (canvas.width/7) * (canvas.height/7)) {
                        opacityValue = 1 - (distance / 20000);
                        ctx.strokeStyle = 'rgba(129, 140, 248,' + (opacityValue * 0.5) + ')'; // Lighter lines
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                        ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        init();
        animate();
    </script>
</body>
</html>
