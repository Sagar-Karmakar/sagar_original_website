@extends('layouts.app')

@section('title', 'Sagar Karmakar | Clarity & Creation')

@section('background')
    <!-- Dynamic Background Canvas -->
    <canvas id="bg-canvas" class="fixed top-0 left-0 w-full h-full -z-10 opacity-40"></canvas>
@endsection

@section('content')
    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center relative pt-16">
        <!-- Background Blobs -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-[120px] opacity-20 animate-blob"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-[120px] opacity-20 animate-blob animation-delay-2000"></div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight text-white reveal">
                Your Relationships Shape<br>
                <span class="text-gradient">Your Life</span>
            </h1>
            
            <p class="text-gray-300 text-lg md:text-2xl mb-4 max-w-3xl mx-auto leading-relaxed reveal" style="transition-delay: 100ms">
                Helping you build healthy relationships with yourself and others through
            </p>
            
            <p class="text-secondary font-medium text-lg md:text-xl mb-10 tracking-wide reveal" style="transition-delay: 200ms">
                Self-Respect • Emotional Maturity • Communication
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-10 reveal" style="transition-delay: 300ms">
                <a href="{{ route('insights') }}" class="px-8 py-4 rounded-full bg-primary text-dark font-bold hover:bg-white hover:text-dark transition-colors shadow-lg shadow-primary/20">
                    Explore Insights
                </a>
                <a href="{{ route('contact') }}" class="px-8 py-4 rounded-full border border-secondary/40 text-secondary hover:bg-secondary/10 transition-colors backdrop-blur-sm">
                    Start Your Relationship Journey
                </a>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#why-relationships-matter" class="text-gray-500 hover:text-secondary transition-colors">
                <i class="fas fa-arrow-down text-xl"></i>
            </a>
        </div>
    </section>

    <!-- Section: Why Relationships Matter -->
    <section id="why-relationships-matter" class="py-24 relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 md:p-14 reveal shadow-2xl shadow-black/50 border-t border-primary/20">
                <h2 class="text-3xl md:text-4xl font-bold mb-10 text-center text-white"><span class="border-b-2 border-secondary pb-2">Why Relationships Matter</span></h2>
                
                <div class="space-y-8 text-lg md:text-xl text-gray-300 leading-relaxed font-light">
                    <p class="text-center italic text-2xl text-white font-serif mb-12">
                        "Most problems in life are not really career problems or money problems.<br>
                        <span class="text-primary not-italic font-sans font-semibold mt-4 block">They are relationship problems.</span>"
                    </p>
                    
                    <div class="flex flex-col md:flex-row gap-6 justify-center my-10 py-8 border-y border-white/10">
                        <div class="text-center md:text-right flex-1 border-b md:border-b-0 md:border-r border-white/10 pb-6 md:pb-0 md:pr-6">
                            <i class="fas fa-user mb-4 text-3xl text-secondary"></i>
                            <p class="font-medium text-white">The relationship you have with yourself.</p>
                        </div>
                        <div class="text-center md:text-left flex-1 pt-6 md:pt-0 md:pl-6">
                            <i class="fas fa-users mb-4 text-3xl text-primary"></i>
                            <p class="font-medium text-white">The relationship you have with others.</p>
                        </div>
                    </div>

                    <p>
                        When these relationships are healthy, life becomes clearer, calmer, and more meaningful.
                    </p>
                    <p>
                        But most people were never taught how relationships actually work. We learn math, science, and history in school, but no one teaches us how to build healthy relationships, understand emotions, or communicate with maturity.
                    </p>
                    <div class="mt-8 p-6 bg-primary/10 rounded-xl border-l-4 border-secondary text-white font-medium">
                        That’s what this work is about. Understanding the psychology of relationships so we can create healthier connections and live more peaceful lives.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: The Three Foundations of Healthy Relationships -->
    <section class="py-24 bg-dark/50 relative border-y border-white/5">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-primary/5 to-transparent pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">The Three Foundations</h2>
                <p class="text-xl text-primary mb-6">of Healthy Relationships</p>
                <div class="w-24 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
                <p class="mt-8 text-gray-300 max-w-2xl mx-auto">Healthy relationships are built on three essential pillars.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Pillar 1 -->
                <div class="glass p-8 md:p-10 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal flex flex-col h-full border-t border-white/10">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fas fa-seedling text-9xl text-white"></i>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-primary/20 flex items-center justify-center mb-6 border border-primary/30">
                        <i class="fas fa-heart text-2xl text-primary"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Self-Respect</h3>
                    <p class="text-secondary text-sm uppercase tracking-wider font-semibold mb-6">The Beginning</p>
                    <div class="text-gray-300 space-y-4 flex-grow relative z-10">
                        <p class="font-medium text-white italic">Every relationship begins with the relationship you have with yourself.</p>
                        <p>Self-respect means understanding your value, setting boundaries, and not losing yourself in the process of loving someone else.</p>
                        <p>Without self-respect, relationships often become imbalanced.</p>
                    </div>
                </div>

                <!-- Pillar 2 -->
                <div class="glass p-8 md:p-10 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal flex flex-col h-full border-t border-white/10" style="transition-delay: 100ms">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fas fa-brain text-9xl text-white"></i>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-secondary/20 flex items-center justify-center mb-6 border border-secondary/30">
                        <i class="fas fa-spa text-2xl text-secondary"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Emotional Maturity</h3>
                    <p class="text-secondary text-sm uppercase tracking-wider font-semibold mb-6">The Navigator</p>
                    <div class="text-gray-300 space-y-4 flex-grow relative z-10">
                        <p>Emotional maturity is the ability to understand your emotions and respond thoughtfully instead of reacting impulsively.</p>
                        <p>It helps you navigate conflict, handle insecurity, and build emotional stability in relationships.</p>
                        <p class="font-medium text-white">Emotionally mature relationships create safety and understanding.</p>
                    </div>
                </div>

                <!-- Pillar 3 -->
                <div class="glass p-8 md:p-10 rounded-2xl relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300 reveal flex flex-col h-full border-t border-white/10" style="transition-delay: 200ms">
                    <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                        <i class="fas fa-comments text-9xl text-white"></i>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mb-6 border border-white/20">
                        <i class="fas fa-comment-dots text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-white">Communication</h3>
                    <p class="text-secondary text-sm uppercase tracking-wider font-semibold mb-6">The Bridge</p>
                    <div class="text-gray-300 space-y-4 flex-grow relative z-10">
                        <p>Many relationships struggle not because of lack of love, but because of lack of communication.</p>
                        <p>Healthy communication means expressing your feelings honestly, listening without defensiveness, and resolving conflicts with respect.</p>
                        <p class="font-medium text-white">Communication transforms relationships.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: What You Will Learn Here -->
    <section class="py-24 relative">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6 text-white">What You Will Learn Here</h2>
                    <p class="text-xl text-gray-300 mb-8">Through my content, I share insights about:</p>
                    
                    <ul class="space-y-4 font-medium text-lg text-white">
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            relationship psychology
                        </li>
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            emotional maturity
                        </li>
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            self-respect and boundaries
                        </li>
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            communication in relationships
                        </li>
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            toxic relationship patterns
                        </li>
                        <li class="flex items-center gap-4 group">
                            <span class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-dark transition-colors"><i class="fas fa-check text-sm"></i></span>
                            healthy love and connection
                        </li>
                    </ul>
                </div>
                
                <div class="reveal">
                    <div class="glass p-10 rounded-3xl border-l-4 border-primary text-center md:text-left">
                        <h3 class="text-2xl font-bold mb-6 text-white">The goal is simple.</h3>
                        <p class="text-xl leading-relaxed text-gray-300 italic font-serif">
                            To help you build relationships that bring <span class="text-secondary font-sans font-bold not-italic">clarity, peace, and growth</span> instead of confusion and emotional chaos.
                        </p>
                        <div class="mt-10 pt-8 border-t border-white/10">
                            <a href="{{ route('insights') }}" class="inline-flex items-center gap-3 text-white font-bold group hover:text-primary transition-colors">
                                Read the Insights <i class="fas fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // Canvas Particle Network configured for Teal 950 Theme
    const canvas = document.getElementById('bg-canvas');
    if (canvas) {
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
                ctx.fillStyle = '#14b8a6'; // Teal 500
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
            let numberOfParticles = (canvas.height * canvas.width) / 10000;
            for (let i = 0; i < numberOfParticles; i++) {
                let size = (Math.random() * 2) + 0.5;
                let x = (Math.random() * ((innerWidth - size * 2) - (size * 2)) + size * 2);
                let y = (Math.random() * ((innerHeight - size * 2) - (size * 2)) + size * 2);
                let directionX = (Math.random() * 0.4) - 0.2; 
                let directionY = (Math.random() * 0.4) - 0.2; 
                let color = '#14b8a6';

                particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
            }
        }
        
        function drawLines() {
            let opacityValue = 1;
            for (let a = 0; a < particlesArray.length; a++) {
                for (let b = a; b < particlesArray.length; b++) {
                    let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x)) + 
                                   ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                    
                    if (distance < (canvas.width/7) * (canvas.height/7)) {
                        opacityValue = 1 - (distance / 20000);
                        ctx.strokeStyle = 'rgba(94, 234, 212,' + (opacityValue * 0.3) + ')'; // Teal 300
                        ctx.lineWidth = 1;
                        ctx.beginPath();
                        ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                        ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                        ctx.stroke();
                    }
                }
            }
        }

        function animate() {
            requestAnimationFrame(animate);
            ctx.clearRect(0, 0, innerWidth, innerHeight);

            for (let i = 0; i < particlesArray.length; i++) {
                particlesArray[i].update();
            }
            drawLines();
        }

        init();
        animate();
    }
</script>
@endpush
