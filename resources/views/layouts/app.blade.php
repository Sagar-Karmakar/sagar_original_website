<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sagar Karmakar')</title>
    
    <!-- Fonts & Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Tangerine:wght@700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        logo: ['Tangerine', 'cursive'],
                    },
                    colors: {
                        primary: '#818cf8', // Soft Indigo
                        secondary: '#2dd4bf', // Teal
                        dark: '#0f172a',    // Slate 900
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
        html, body {
            overflow-x: hidden;
            width: 100%;
            position: relative;
        }

        body {
            background-color: #0f172a;
            color: #e2e8f0;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #818cf8; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #2dd4bf; }

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

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        .quote-border { border-left: 3px solid #2dd4bf; }
    </style>
    @stack('styles')
</head>
<body class="antialiased selection:bg-teal-500 selection:text-white flex flex-col min-h-screen">

    @yield('background')

    <!-- Navigation -->
    <nav class="fixed w-full z-[70] transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex-shrink-0 cursor-pointer group relative z-[70]">
                    <span class="text-5xl font-bold font-logo text-white group-hover:text-primary transition-colors pt-2 block">Sagar</span>
                </a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        @yield('menu')
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden relative z-[70]">
                    <button type="button" onclick="toggleMenu()" class="p-2 text-white hover:text-primary transition-colors focus:outline-none" aria-label="Toggle menu">
                        <div class="w-6 h-5 relative flex flex-col justify-between">
                            <span class="w-full h-0.5 bg-current transform transition-all duration-300 origin-left" id="bar1"></span>
                            <span class="w-full h-0.5 bg-current transform transition-all duration-300" id="bar2"></span>
                            <span class="w-full h-0.5 bg-current transform transition-all duration-300 origin-left" id="bar3"></span>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        
    </nav>

    <!-- Mobile Menu Overlay (Moved outside nav to prevent backdrop-filter clipping) -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-slate-900/70 backdrop-blur-2xl z-[60] transform translate-x-full transition-all duration-500 cubic-bezier(0.4, 0, 0.2, 1) flex flex-col justify-center items-center border-l border-white/10 shadow-2xl">
        <div class="absolute inset-0 bg-gradient-to-b from-primary/10 to-transparent pointer-events-none"></div>
        <div class="w-full max-w-lg mx-auto px-6 flex flex-col items-center justify-center space-y-8 opacity-0 transition-all duration-500 delay-100 scale-95" id="mobile-menu-content">
            @yield('mobile-menu')
        </div>
    </div>

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('glass-nav');
            } else {
                nav.classList.remove('glass-nav');
            }
        });

        // Mobile Menu Logic
        const menuOverlay = document.getElementById('mobile-menu-overlay');
        const menuContent = document.getElementById('mobile-menu-content');
        const bar1 = document.getElementById('bar1');
        const bar2 = document.getElementById('bar2');
        const bar3 = document.getElementById('bar3');
        let isMenuOpen = false;

        function toggleMenu() {
            isMenuOpen = !isMenuOpen;
            
            if (isMenuOpen) {
                // Open Menu
                menuOverlay.classList.remove('translate-x-full');
                document.body.style.overflow = 'hidden';
                
                // Animate Icon to X
                bar1.classList.add('rotate-45');
                bar2.classList.add('opacity-0');
                bar3.classList.add('-rotate-45');
                
                // Fade in content
                setTimeout(() => {
                    menuContent.classList.remove('opacity-0', 'scale-95');
                    menuContent.classList.add('scale-100');
                }, 150);
            } else {
                // Close Menu
                menuOverlay.classList.add('translate-x-full');
                document.body.style.overflow = 'auto';
                
                // Animate Icon back to Hamburger
                bar1.classList.remove('rotate-45');
                bar2.classList.remove('opacity-0');
                bar3.classList.remove('-rotate-45');
                
                // Fade out content
                menuContent.classList.add('opacity-0', 'scale-95');
                menuContent.classList.remove('scale-100');
            }
        }

        // Close menu on resize if open
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768 && isMenuOpen) {
                toggleMenu();
            }
        });

        // Close menu when clicking a link inside it
        const mobileLinks = menuContent ? menuContent.querySelectorAll('a') : [];
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                if(isMenuOpen) toggleMenu();
            });
        });

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
        reveal();
    </script>
    @stack('scripts')
</body>
</html>
