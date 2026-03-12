@extends('layouts.app')

@section('title', 'Get in Touch | Sagar Karmakar')

@section('content')
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full -z-10 bg-[#042f2e] overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-10 w-72 h-72 bg-primary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob"></div>
        <div class="absolute bottom-1/4 right-10 w-72 h-72 bg-secondary/20 rounded-full mix-blend-screen filter blur-[100px] animate-blob animation-delay-2000"></div>
    </div>

    <!-- Contact Content -->
    <section class="min-h-screen pt-32 pb-24 relative flex items-center justify-center">
        <div class="max-w-3xl w-full mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="text-center mb-12 reveal">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white">Get in Touch</h1>
                <div class="w-20 h-1 bg-gradient-to-r from-primary to-secondary mx-auto rounded-full"></div>
            </div>

            <div class="glass rounded-3xl p-8 md:p-14 reveal shadow-2xl shadow-black/50 border-t border-primary/20 text-center">
                <div class="space-y-8 text-lg text-gray-300 leading-relaxed font-light">
                    
                    <p class="text-xl text-white">
                        If you would like to connect, collaborate, or discuss ideas related to relationships and emotional growth, feel free to reach out.
                    </p>

                    <div class="my-10 py-10 border-y border-white/10 grid grid-cols-1 lg:grid-cols-2 gap-12 text-left">
                        
                        <!-- Contact Info -->
                        <div class="flex flex-col justify-center border-b lg:border-b-0 lg:border-r border-white/10 pb-8 lg:pb-0 lg:pr-8">
                            <h2 class="text-2xl font-bold text-white mb-6">Direct Contact</h2>
                            <p class="text-gray-400 mb-8 text-base">
                                Prefer email? Reach out directly. I try to reply to all thoughtful messages.
                            </p>
                            <p class="text-sm font-bold uppercase tracking-widest text-primary mb-2">Email</p>
                            <a href="mailto:hello@sagarkarmakar.com" class="text-xl md:text-2xl font-bold text-white hover:text-secondary transition-colors block">
                                hello@sagarkarmakar.com
                            </a>
                        </div>

                        <!-- Contact Form -->
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-6">Send a Message</h2>
                            <form id="contact-form" class="space-y-4 text-base">
                                @csrf
                                <div>
                                    <input type="text" id="contact-name" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="Your Name" required>
                                </div>
                                <div>
                                    <input type="email" id="contact-email" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="Email Address" required>
                                </div>
                                <div class="relative">
                                    <select id="contact-option" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors appearance-none cursor-pointer">
                                        <option class="bg-[#042f2e] text-gray-300" value="" disabled selected>Select an option...</option>
                                        <option class="bg-[#042f2e] text-gray-300" value="Discussion / Ideas">Discussion / Ideas</option>
                                        <option class="bg-[#042f2e] text-gray-300" value="Collaboration">Collaboration</option>
                                        <option class="bg-[#042f2e] text-gray-300" value="Relationship Advice">Relationship Advice</option>
                                        <option class="bg-[#042f2e] text-gray-300" value="Just saying hello">Just saying hello</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-primary">
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                                <div>
                                    <textarea id="contact-message" rows="4" class="w-full bg-black/30 border border-white/10 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-primary transition-colors placeholder-gray-500" placeholder="What's on your mind?" required></textarea>
                                </div>
                                <button type="submit" id="submit-btn" class="w-full bg-primary text-dark font-bold py-3 rounded-lg hover:bg-white transition-colors flex items-center justify-center gap-2">
                                    <span>Send Message</span> <i class="fas fa-paper-plane text-dark text-xl"></i>
                                </button>
                                <div id="form-message" class="text-center mt-3 text-sm font-medium"></div>
                            </form>
                        </div>
                    </div>

                    <p>
                        You can also connect through social platforms where I regularly share insights about relationships and emotional intelligence.
                    </p>
                    
                    <div class="mt-8 flex flex-wrap justify-center gap-6 pt-4">
                        <a href="https://youtube.com/@AlignWithSagar" target="_blank" title="YouTube" class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-primary hover:bg-white/10 transition-all hover:scale-110 duration-300 shadow-lg"><i class="fab fa-youtube text-2xl"></i></a>
                        <a href="https://x.com/AlignWithSagar" target="_blank" title="X (Twitter)" class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-primary hover:bg-white/10 transition-all hover:scale-110 duration-300 shadow-lg"><i class="fab fa-twitter text-2xl"></i></a>
                        <a href="https://instagram.com/AlignWithSagar" target="_blank" title="Instagram" class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-primary hover:bg-white/10 transition-all hover:scale-110 duration-300 shadow-lg"><i class="fab fa-instagram text-2xl"></i></a>
                        <a href="https://linkedin.com/in/AlignWithSagar" target="_blank" title="LinkedIn" class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-primary hover:bg-white/10 transition-all hover:scale-110 duration-300 shadow-lg"><i class="fab fa-linkedin text-xl"></i></a>
                        <a href="https://wa.me/916291373748" target="_blank" title="WhatsApp (+91-6291373748)" class="w-14 h-14 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white/50 hover:text-primary hover:bg-white/10 transition-all hover:scale-110 duration-300 shadow-lg"><i class="fab fa-whatsapp text-2xl"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('contact-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('submit-btn');
        const msgDiv = document.getElementById('form-message');
        const originalBtnContent = btn.innerHTML;

        // Disable button and show loading state
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        msgDiv.textContent = '';
        msgDiv.className = 'text-center mt-3 text-sm font-medium';

        const formData = {
            name: document.getElementById('contact-name').value,
            email: document.getElementById('contact-email').value,
            option: document.getElementById('contact-option').value,
            message: document.getElementById('contact-message').value,
            _token: document.querySelector('input[name="_token"]').value
        };

        try {
            const response = await fetch('/contact-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': formData._token
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (response.ok) {
                msgDiv.textContent = result.message || 'Message sent successfully!';
                msgDiv.classList.add('text-secondary'); 
                document.getElementById('contact-form').reset();
            } else {
                throw new Error(result.message || 'Failed to send message.');
            }
        } catch (error) {
            msgDiv.textContent = error.message;
            msgDiv.classList.add('text-red-400');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalBtnContent;
        }
    });
</script>
@endpush
