<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healing Support Form | Sagar Karmakar</title>
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
                        primary: '#818cf8',
                        secondary: '#2dd4bf',
                        dark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0f172a;
            color: #e2e8f0;
            overflow: hidden; /* Prevent scrolling */
        }
        
        .question-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 800px;
            padding: 2rem;
            opacity: 0;
            pointer-events: none;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
            transform: translate(-50%, 50px); /* Start slightly lower */
        }

        .question-container.active {
            opacity: 1;
            pointer-events: all;
            transform: translate(-50%, -50%);
        }

        .question-container.prev {
            opacity: 0;
            transform: translate(-50%, -100px); /* Move up */
        }

        .question-container.next {
            opacity: 0;
            transform: translate(-50%, 100px); /* Move down */
        }

        /* Minimal Input Styles */
        .tf-input {
            background: transparent;
            border: none;
            border-bottom: 2px solid rgba(255,255,255,0.2);
            font-size: 2rem;
            width: 100%;
            padding: 0.5rem 0;
            color: #2dd4bf;
            outline: none;
            transition: border-color 0.3s;
        }
        .tf-input::placeholder {
            color: rgba(255,255,255,0.15);
        }
        .tf-input:focus {
            border-color: #2dd4bf;
        }

        /* Radio Buttons Typeform Style */
        .tf-radio-group {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .tf-radio-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1.25rem;
        }
        .tf-radio-option:hover {
            background: rgba(255,255,255,0.05);
            border-color: #818cf8;
        }
        .tf-radio-option.selected {
            background: rgba(129, 140, 248, 0.1);
            border-color: #818cf8;
            color: #818cf8;
        }
        .key-hint {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 4px;
            font-size: 0.75rem;
            margin-right: 12px;
            color: rgba(255,255,255,0.5);
        }

        /* Progress Bar */
        .progress-bar-bg {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255,255,255,0.1);
        }
        .progress-bar-fill {
            height: 100%;
            background: #2dd4bf;
            width: 0%;
            transition: width 0.5s ease;
        }

        /* Next Button Floating */
        .nav-controls {
            position: fixed;
            bottom: 40px;
            right: 40px;
            display: flex;
            gap: 10px;
        }
        .nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            background: #818cf8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0.5;
            transition: all 0.2s;
        }
        .nav-btn:hover {
            opacity: 1;
        }
        .nav-btn:disabled {
            background: gray;
            cursor: not-allowed;
        }

        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.3;
        }
        
        /* Shake Animation */
        @keyframes shake {
            0%, 100% { transform: translate(-50%, -50%) translateX(0); }
            25% { transform: translate(-50%, -50%) translateX(-10px); }
            75% { transform: translate(-50%, -50%) translateX(10px); }
        }
        .shake {
            animation: shake 0.4s ease-in-out;
        }
    </style>
</head>
<body>

    <canvas id="bg-canvas"></canvas>

    <!-- Branding Top Left -->
    <div class="fixed top-8 left-8 z-50">
        <span class="text-4xl font-logo text-white">Sagar</span>
    </div>

    <!-- Main Form Container -->
    <form id="tf-form" onsubmit="event.preventDefault();" autocomplete="off">
        
        <!-- STEP 1: WELCOME -->
        <div class="question-container active" data-step="1">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Healing Support Form
            </h1>
            <p class="text-xl text-gray-400 mb-8 leading-relaxed max-w-2xl">
                This helps me understand where you are right now. Take your time. <br>
                There are no right or wrong answers.
            </p>
            <button type="button" class="bg-primary hover:bg-opacity-90 text-white text-xl px-8 py-4 rounded transition-all" onclick="nextStep()">
                Begin <i class="fas fa-arrow-right ml-2"></i>
            </button>
            <div class="mt-4 text-sm text-gray-500">
                <span class="key-hint">Enter ↵</span> to continue
            </div>
        </div>

        <!-- STEP 2: NAME -->
        <div class="question-container next" data-step="2">
            <label class="block text-xl md:text-2xl text-primary mb-4">1. What is your full name?</label>
            <input type="text" name="name" class="tf-input" placeholder="Type your answer here..." required>
            <button type="button" class="mt-8 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded transition-all" onclick="nextStep()">
                OK <i class="fas fa-check ml-2"></i>
            </button>
        </div>

        <!-- STEP 3: PHONE -->
        <div class="question-container next" data-step="3">
            <label class="block text-xl md:text-2xl text-primary mb-4">2. Your Phone / WhatsApp Number?</label>
            <p class="text-gray-400 mb-6 text-sm">Ideally one connected to WhatsApp.</p>
            <input type="tel" name="phone" class="tf-input" placeholder="+91..." required>
            <button type="button" class="mt-8 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded transition-all" onclick="nextStep()">
                OK <i class="fas fa-check ml-2"></i>
            </button>
        </div>

        <!-- STEP 4: EMAIL -->
        <div class="question-container next" data-step="4">
            <label class="block text-xl md:text-2xl text-primary mb-4">3. Your Email Address?</label>
            <input type="email" name="email" class="tf-input" placeholder="name@example.com" required>
            <button type="button" class="mt-8 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded transition-all" onclick="nextStep()">
                OK <i class="fas fa-check ml-2"></i>
            </button>
        </div>

        <!-- STEP 5: PREFERRED CONTACT -->
        <div class="question-container next" data-step="5">
            <label class="block text-xl md:text-2xl text-primary mb-4">4. How should I contact you?</label>
            <div class="tf-radio-group">
                <div class="tf-radio-option" onclick="selectRadio(this, 'contact', 'Phone')">
                    <span class="key-hint">A</span> Phone Call
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'contact', 'WhatsApp')">
                    <span class="key-hint">B</span> WhatsApp
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'contact', 'Email')">
                    <span class="key-hint">C</span> Email
                </div>
            </div>
            <input type="hidden" name="contact" required>
        </div>

        <!-- STEP 6: TREATMENT -->
        <div class="question-container next" data-step="6" data-type="logic">
            <label class="block text-xl md:text-2xl text-primary mb-4">5. Are you currently taking treatment from a doctor or therapist?</label>
            <div class="tf-radio-group">
                <div class="tf-radio-option" onclick="selectRadio(this, 'treatment', 'yes'); setLogicFlag('treatment', true)">
                    <span class="key-hint">Y</span> Yes
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'treatment', 'no'); setLogicFlag('treatment', false)">
                    <span class="key-hint">N</span> No
                </div>
            </div>
            <input type="hidden" name="treatment" required>
        </div>

        <!-- STEP 7: REPLACEMENT (CONDITIONAL) -->
        <div class="question-container next" data-step="7" id="step-replacement">
            <label class="block text-xl md:text-2xl text-red-400 mb-4">6. Is this session meant to replace that treatment?</label>
            <div class="p-4 bg-red-900/20 border border-red-500/30 rounded-lg mb-6 text-red-200 text-sm">
                 <i class="fas fa-triangle-exclamation mr-2"></i> Important: I cannot provide medical replacements.
            </div>
            <div class="tf-radio-group">
                <div class="tf-radio-option" onclick="selectRadio(this, 'replacement', 'yes')">
                    <span class="key-hint">Y</span> Yes
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'replacement', 'no')">
                    <span class="key-hint">N</span> No
                </div>
            </div>
            <input type="hidden" name="replacement">
        </div>

        <!-- STEP 8: REASON -->
        <div class="question-container next" data-step="8">
            <label class="block text-xl md:text-2xl text-primary mb-4">7. What made you reach out today?</label>
            <p class="text-gray-400 mb-4 text-sm">Briefly describe what's on your mind.</p>
            <textarea name="reason" class="tf-input text-lg" rows="1" placeholder="Type here..." required oninput="autoResize(this)"></textarea>
            <button type="button" class="mt-8 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded transition-all" onclick="nextStep()">
                OK <i class="fas fa-check ml-2"></i>
            </button>
        </div>

        <!-- STEP 9: INTENSITY -->
        <div class="question-container next" data-step="9">
            <label class="block text-xl md:text-2xl text-primary mb-8">8. How heavy does this issue feel right now?</label>
            <div class="flex items-center justify-center mb-8">
                <span id="intensity-display" class="text-8xl font-bold text-secondary">5</span>
                <span class="text-2xl text-gray-500 ml-2">/ 10</span>
            </div>
            <input type="range" name="intensity" min="0" max="10" value="5" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer" oninput="document.getElementById('intensity-display').innerText = this.value">
            <div class="flex justify-between text-sm text-gray-400 mt-4">
                <span>Light as a feather</span>
                <span>Unbearably heavy</span>
            </div>
            <button type="button" class="mt-12 bg-white/10 hover:bg-white/20 text-white px-6 py-3 rounded transition-all" onclick="nextStep()">
                OK <i class="fas fa-check ml-2"></i>
            </button>
        </div>

        <!-- STEP 10: STATE -->
        <div class="question-container next" data-step="10">
            <label class="block text-xl md:text-2xl text-primary mb-4">9. Which feels closest to your current state?</label>
            <div class="tf-radio-group">
                <div class="tf-radio-option" onclick="selectRadio(this, 'state', 'calm')">
                    <span class="key-hint">A</span> Mostly calm, just thinking
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'state', 'heavy')">
                    <span class="key-hint">B</span> Emotionally tired or heavy
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'state', 'anxious')">
                    <span class="key-hint">C</span> Anxious or restless
                </div>
                <div class="tf-radio-option" onclick="selectRadio(this, 'state', 'numb')">
                    <span class="key-hint">D</span> Numb or disconnected
                </div>
            </div>
            <input type="hidden" name="state" required>
        </div>

        <!-- STEP 11: DONE -->
        <div class="question-container next" data-step="11" id="step-submit">
            <h1 class="text-4xl font-bold mb-6 text-white">Thank you.</h1>
            <p class="text-xl text-gray-300 mb-8 max-w-lg">
                I've received your details. I'll read through them carefully before we connect.
            </p>
            <button type="button" class="bg-secondary hover:bg-opacity-90 text-dark font-bold text-xl px-8 py-4 rounded transition-all transform hover:scale-105" onclick="submitForm()">
                Submit Now
            </button>
        </div>

    </form>

    <!-- Navigation UI -->
    <div class="nav-controls">
        <button class="nav-btn" onclick="prevStep()"><i class="fas fa-chevron-up"></i></button>
        <button class="nav-btn" onclick="nextStep()"><i class="fas fa-chevron-down"></i></button>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar-bg">
        <div class="progress-bar-fill" id="progress-fill"></div>
    </div>


    <script>
        let currentStep = 1;
        const totalSteps = 11;
        let logicFlags = {
            treatment: false
        };

        // Initialize display
        updateUI();
        initParticles();

        function updateUI() {
            // Update Progress
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            document.getElementById('progress-fill').style.width = `${progress}%`;

            // Active Class Management
            const containers = document.querySelectorAll('.question-container');
            containers.forEach(el => {
                const step = parseInt(el.dataset.step);
                el.classList.remove('active', 'prev', 'next');
                
                if (step === currentStep) {
                    el.classList.add('active');
                    // Focus input if exists
                    const input = el.querySelector('input:not([type="hidden"]), textarea');
                    if(input) setTimeout(() => input.focus(), 500);
                } else if (step < currentStep) {
                    el.classList.add('prev');
                } else {
                    el.classList.add('next');
                }
            });
        }

        function setLogicFlag(key, value) {
            logicFlags[key] = value;
        }

        function nextStep() {
            // Validate current step
            const currentEl = document.querySelector(`.question-container[data-step="${currentStep}"]`);
            const input = currentEl.querySelector('input[required], textarea[required]');
            
            if (input && !input.value.trim()) {
                currentEl.classList.add('shake');
                setTimeout(() => currentEl.classList.remove('shake'), 400);
                return;
            }

            // Logic for skipping replacement step
            if (currentStep === 6 && logicFlags['treatment'] === false) {
                // If treatment is NO, skip replacement (step 7) and go to 8
                currentStep = 8;
            } else {
                if (currentStep < totalSteps) {
                    currentStep++;
                }
            }
            updateUI();
        }

        function prevStep() {
            if (currentStep > 1) {
                // Logic reverse skip
                if (currentStep === 8 && logicFlags['treatment'] === false) {
                    currentStep = 6;
                } else {
                    currentStep--;
                }
                updateUI();
            }
        }

        function selectRadio(element, inputName, value) {
            // Update Visuals
            const parent = element.parentElement;
            parent.querySelectorAll('.tf-radio-option').forEach(el => el.classList.remove('selected'));
            element.classList.add('selected');

            // Update Hidden Input
            const hidden = parent.parentElement.querySelector(`input[name="${inputName}"]`);
            if(hidden) hidden.value = value;

            // Auto-advance after small delay
            setTimeout(() => {
                nextStep();
            }, 400);
        }

        function autoResize(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';
        }

        function submitForm() {
            alert('Form Submitted! (This is a demo)');
            // window.location.href = '/';
        }

        // Global Key Listeners
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                // If it's a textarea, Enter allows new line unless Shift is held? 
                // Typeform usually does Enter = Next, Shift+Enter = New Line
                const currentEl = document.querySelector(`.question-container[data-step="${currentStep}"]`);
                const textarea = currentEl.querySelector('textarea');
                
                if (textarea) {
                    if (!e.shiftKey) {
                        e.preventDefault();
                        nextStep();
                    }
                } else {
                    nextStep();
                }
            }
            // Optional: Keyboard shortcuts for A, B, C, D (need checks for focus)
        });

        // --- Particles BG (Reused) ---
        function initParticles() {
            const canvas = document.getElementById('bg-canvas');
            const ctx = canvas.getContext('2d');
            let particlesArray;

            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            class Particle {
                constructor(x, y, size) {
                    this.x = x;
                    this.y = y;
                    this.size = size;
                    this.weight = Math.random() * 1.5 + 1.5;
                    this.directionX = Math.random() * 0.4 - 0.2;
                }
                update() {
                    this.y -= this.weight;
                    this.x += this.directionX;
                    if (this.size >= 0.3) this.size -= 0.05;
                    if (this.size <= 0.3 || this.y < 0) {
                        this.x = Math.random() * canvas.width;
                        this.y = canvas.height;
                        this.size = Math.random() * 2 + 1;
                        this.weight = Math.random() * 1.5 + 0.5;
                    }
                }
                draw() {
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(45, 212, 191, 0.2)'; // Teal faint
                    ctx.fill();
                }
            }

            function init() {
                particlesArray = [];
                for (let i = 0; i < 60; i++) {
                    const x = Math.random() * canvas.width;
                    const y = Math.random() * canvas.height;
                    const size = Math.random() * 2 + 1;
                    particlesArray.push(new Particle(x, y, size));
                }
            }

            function animate() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (let i = 0; i < particlesArray.length; i++) {
                    particlesArray[i].update();
                    particlesArray[i].draw();
                }
                requestAnimationFrame(animate);
            }

            init();
            animate();
            
            window.addEventListener('resize', () => {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
                init();
            });
        }
    </script>
</body>
</html>
