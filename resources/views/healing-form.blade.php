@extends('layouts.app')

@section('title', 'Healing Support Form | Sagar Karmakar')

@push('styles')
    <style>
        /* Only form-specific styles needed here */
        
        .glass {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        /* Form Controls */
        input[type="text"], 
        input[type="email"],
        input[type="number"],
        textarea, 
        select {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #818cf8;
            box-shadow: 0 0 0 2px rgba(129, 140, 248, 0.2);
        }

        /* Custom Radio/Checkbox Buttons */
        .custom-option input:checked + div {
            border-color: #818cf8;
            background-color: rgba(129, 140, 248, 0.1);
        }
        .custom-option input:checked + div .indicator-dot {
            transform: scale(1);
            background-color: #818cf8;
        }
        .custom-option input:checked + div .indicator-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Range Slider */
        input[type=range] {
            -webkit-appearance: none;
            background: transparent;
        }
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #2dd4bf;
            cursor: pointer;
            margin-top: -8px;
            box-shadow: 0 0 10px rgba(45, 212, 191, 0.5);
        }
        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 4px;
            cursor: pointer;
            background: #334155;
            border-radius: 2px;
        }

        /* Transitions */
        .step-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        .step-content.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Error Shake Animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.3s ease-in-out;
        }

        #bg-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.4;
        }
    </style>
@endpush

@section('content')
    <!-- Background (Handled by Layout but can overlap if needed, or we just remove this local canvas) -->
    <!-- <canvas id="bg-canvas"></canvas> --> 

    <section class="min-h-screen flex items-center justify-center p-4 pt-24">

    <div class="w-full max-w-2xl my-10">
        <!-- Header -->
        <div class="text-center mb-8">
            <span class="text-5xl font-bold font-logo text-white block mb-2">Sagar</span>
            <h1 class="text-2xl font-semibold text-white mb-1">Healing Support</h1>
            <p class="text-primary tracking-widest text-sm uppercase">Pre-Session Form</p>
        </div>

        <!-- Main Form Container -->
        <div class="glass rounded-2xl overflow-hidden relative">
            
            <!-- Progress Bar -->
            <div class="h-1 bg-gray-800 w-full">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-primary to-secondary transition-all duration-500 w-[16%]"></div>
            </div>

            <form id="multi-step-form" class="p-6 md:p-10" onsubmit="event.preventDefault();">
                
                <!-- SECTION 1: BASIC DETAILS -->
                <div class="step-content active" data-step="1">
                    
                    <!-- Intro Text -->
                    <div class="bg-white/5 rounded-xl p-5 mb-8 border border-white/10">
                        <h3 class="text-secondary font-bold mb-3 flex items-center gap-2">
                            <i class="fas fa-leaf"></i> Before You Begin
                        </h3>
                        <p class="text-gray-300 text-sm leading-relaxed mb-3">
                            This form helps me understand your situation better before we talk. There is no right or wrong answer here.
                        </p>
                        <ul class="text-gray-400 text-sm space-y-2 list-disc list-inside">
                            <li>I am not here to judge you in any way.</li>
                            <li>Everything you share is private and confidential.</li>
                            <li>You can write as little or as much as you feel comfortable.</li>
                        </ul>
                    </div>

                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">1</span>
                        <h2 class="text-xl font-bold text-white">Basic Details</h2>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Full Name</label>
                            <input type="text" name="name" class="w-full rounded-lg px-4 py-3 text-sm" placeholder="Your Name" required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Phone / WhatsApp Number</label>
                            <input type="text" name="phone" class="w-full rounded-lg px-4 py-3 text-sm" placeholder="+91..." required>
                        </div>

                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-1">Email Address</label>
                            <input type="email" name="email" class="w-full rounded-lg px-4 py-3 text-sm" placeholder="you@example.com" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-300 text-sm font-medium mb-1">Age (Optional)</label>
                                <input type="number" name="age" class="w-full rounded-lg px-4 py-3 text-sm" placeholder="e.g. 28">
                            </div>
                            <div>
                                <label class="block text-gray-300 text-sm font-medium mb-1">Preferred Contact</label>
                                <select name="contact_pref" class="w-full rounded-lg px-4 py-3 text-sm h-[46px]" required>
                                    <option value="" disabled selected>Select...</option>
                                    <option value="Phone" class="bg-gray-900">Phone</option>
                                    <option value="WhatsApp" class="bg-gray-900">WhatsApp</option>
                                    <option value="Email" class="bg-gray-900">Email</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: SAFETY & CLARITY -->
                <div class="step-content" data-step="2">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">2</span>
                        <h2 class="text-xl font-bold text-white">Safety & Clarity</h2>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Treatment -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Are you currently taking treatment from a doctor, therapist, or psychiatrist?</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="custom-option cursor-pointer group">
                                    <input type="radio" name="treatment" value="yes" class="hidden" required>
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 transition-colors group-hover:border-white/30">
                                        <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Yes</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer group">
                                    <input type="radio" name="treatment" value="no" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 transition-colors group-hover:border-white/30">
                                        <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">No</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Replacement (Critical) -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">If yes, are you coming here to replace that treatment?</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="custom-option cursor-pointer group">
                                    <input type="radio" name="replace_care" value="yes" class="hidden" onchange="checkSafety(this)" required>
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 transition-colors group-hover:border-white/30">
                                        <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Yes</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer group">
                                    <input type="radio" name="replace_care" value="no" class="hidden" onchange="checkSafety(this)">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 transition-colors group-hover:border-white/30">
                                        <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">No</span>
                                    </div>
                                </label>
                            </div>
                            <!-- Safety Alert -->
                            <div id="safety-alert" class="hidden mt-4 p-4 bg-red-900/30 border border-red-500/30 rounded-lg text-red-200 text-sm flex items-start gap-3">
                                <i class="fas fa-exclamation-triangle mt-1"></i>
                                <div>
                                    <p class="font-bold mb-1">Important Note</p>
                                    <p>This session is meant only as support, not as a replacement for professional medical treatment.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Why Now -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">What made you reach out for help at this time?</label>
                            <textarea name="reason" rows="3" class="w-full rounded-lg p-3 text-sm" placeholder="Write in your own words..." required></textarea>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: HOW YOU FEEL RIGHT NOW -->
                <div class="step-content" data-step="3">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">3</span>
                        <h2 class="text-xl font-bold text-white">How You Feel Right Now</h2>
                    </div>

                    <div class="space-y-8">
                        <!-- Intensity Scale -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-4 flex justify-between">
                                <span>Right now, how heavy does this problem feel?</span>
                                <span id="intensity-val" class="text-primary font-bold">5/10</span>
                            </label>
                            <input type="range" min="0" max="10" value="5" class="w-full" oninput="document.getElementById('intensity-val').innerText = this.value + '/10'">
                            <div class="flex justify-between text-xs text-gray-500 mt-2">
                                <span>Very Light (0)</span>
                                <span>Very Heavy (10)</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Which sentence feels closest to how you feel right now?</label>
                            <div class="space-y-2">
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="state" value="calm_thinking" class="hidden" required>
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-secondary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Mostly calm, just thinking a lot</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="state" value="tired_heavy" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-secondary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Emotionally tired or heavy</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="state" value="anxious" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-secondary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Anxious or restless</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="state" value="confused" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-secondary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Confused or stuck</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="state" value="numb" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-secondary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Numb or disconnected</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: HOW THIS SHOWS UP -->
                <div class="step-content" data-step="4">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">4</span>
                        <h2 class="text-xl font-bold text-white">How This Shows Up</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- First Sense -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">When you think about this issue, what comes first?</label>
                            <div class="space-y-2">
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="sense" value="images" class="hidden" required>
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Images or scenes in the mind</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="sense" value="thoughts" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Thoughts or inner talking</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="sense" value="body" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Body feelings (tightness, heaviness, pain)</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-3 rounded-lg border border-white/5 hover:bg-white/5 transition-colors">
                                    <input type="radio" name="sense" value="not_sure" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300">Not sure</span>
                                </label>
                            </div>
                        </div>

                        <!-- Body Location -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">Where do you feel this most in your body (if at all)?</label>
                            <input type="text" name="location" class="w-full rounded-lg px-4 py-3 text-sm" placeholder="e.g. chest, head, stomach, throat..." required>
                        </div>

                        <!-- Time Orientation -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Is this concern mostly about:</label>
                            <div class="space-y-2">
                                <label class="custom-option cursor-pointer flex items-center p-2 rounded-lg hover:bg-white/5">
                                    <input type="radio" name="time" value="past" class="hidden" required>
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">Something from the past</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-2 rounded-lg hover:bg-white/5">
                                    <input type="radio" name="time" value="present" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">Something happening now</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-2 rounded-lg hover:bg-white/5">
                                    <input type="radio" name="time" value="future" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">Something I'm worried about in the future</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center p-2 rounded-lg hover:bg-white/5">
                                    <input type="radio" name="time" value="mix" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center mr-3">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">A mix of these</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 5: IMPACT ON DAILY LIFE -->
                <div class="step-content" data-step="5">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">5</span>
                        <h2 class="text-xl font-bold text-white">Impact on Daily Life</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Impact Level -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">How much does this affect your daily life?</label>
                            <div class="flex gap-4">
                                <label class="custom-option cursor-pointer flex-1">
                                    <input type="radio" name="impact_level" value="little" class="hidden" required>
                                    <div class="border border-white/10 rounded-lg p-3 text-center transition-colors hover:bg-white/5">
                                        <span class="text-gray-300 text-sm">A little</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer flex-1">
                                    <input type="radio" name="impact_level" value="moderately" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 text-center transition-colors hover:bg-white/5">
                                        <span class="text-gray-300 text-sm">Moderately</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer flex-1">
                                    <input type="radio" name="impact_level" value="alot" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 text-center transition-colors hover:bg-white/5">
                                        <span class="text-gray-300 text-sm">A lot</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Areas Affected (Checkboxes) -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Does it affect any of these? (Select all that apply)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="sleep" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Sleep</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="work" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Work / Studies</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="relationships" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Relationships</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="focus" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Focus / Energy</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="mood" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">Mood</span>
                                    </div>
                                </label>
                                <label class="custom-option cursor-pointer">
                                    <input type="checkbox" name="impact_area" value="none" class="hidden">
                                    <div class="border border-white/10 rounded-lg p-3 flex items-center gap-3 hover:bg-white/5">
                                        <div class="w-4 h-4 rounded border border-gray-400 flex items-center justify-center">
                                            <div class="indicator-check w-2 h-2 bg-primary rounded-sm transform scale-0 transition-all"></div>
                                        </div>
                                        <span class="text-gray-300 text-sm">None of these</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- History -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Have you felt something similar before in your life?</label>
                            <div class="flex gap-4">
                                <label class="custom-option cursor-pointer flex items-center gap-2">
                                    <input type="radio" name="history" value="yes" class="hidden" required>
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">Yes</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center gap-2">
                                    <input type="radio" name="history" value="no" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">No</span>
                                </label>
                                <label class="custom-option cursor-pointer flex items-center gap-2">
                                    <input type="radio" name="history" value="not_sure" class="hidden">
                                    <div class="w-4 h-4 rounded-full border border-gray-400 flex items-center justify-center">
                                        <div class="indicator-dot w-2 h-2 bg-primary rounded-full transform scale-0 transition-transform"></div>
                                    </div>
                                    <span class="text-gray-300 text-sm">Not sure</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 6: SUPPORT & READINESS -->
                <div class="step-content" data-step="6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-primary/20 text-primary font-bold text-sm">6</span>
                        <h2 class="text-xl font-bold text-white">Support & Readiness</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Resources -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">What usually helps you even a little when things feel difficult?</label>
                            <textarea name="resources" rows="2" class="w-full rounded-lg p-3 text-sm" placeholder="e.g. rest, walking, prayer, music..." required></textarea>
                        </div>

                        <!-- Session Goal -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-2">What would make this session helpful for you?</label>
                            <textarea name="goal" rows="2" class="w-full rounded-lg p-3 text-sm" placeholder="One or two lines..." required></textarea>
                        </div>

                        <!-- Openness -->
                        <div>
                            <label class="block text-gray-300 text-sm font-medium mb-3">Are you open to gentle exercises during the session (like awareness or imagination), not just talking?</label>
                            <select name="openness" class="w-full rounded-lg px-4 py-3 text-sm cursor-pointer" required>
                                <option value="" disabled selected>Select an option</option>
                                <option value="yes" class="bg-gray-900">Yes</option>
                                <option value="maybe" class="bg-gray-900">Maybe</option>
                                <option value="talking_only" class="bg-gray-900">I prefer only talking</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- SUCCESS MESSAGE (Hidden by default) -->
                <div id="success-message" class="hidden text-center py-12">
                    <div class="w-20 h-20 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-3xl text-secondary"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-4">Thank you for sharing</h3>
                    <div class="max-w-md mx-auto text-gray-300 space-y-4 mb-8 text-sm leading-relaxed">
                        <p>You are not weak for needing support. You are not broken.</p>
                        <p>This form helps me prepare better for you.</p>
                        <p class="text-white font-medium">We will go at your pace, with respect and care.</p>
                    </div>
                    <a href="{{ url('/') }}" class="inline-block px-8 py-3 rounded-full border border-white/20 text-white hover:bg-white/10 transition-colors">Back to Home</a>
                </div>

                <!-- Error Message Container -->
                <div id="step-error-message" class="hidden text-center mt-6 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-200 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i> Please fill in all required fields to continue.
                </div>

                <!-- Navigation Buttons -->
                <div id="nav-buttons" class="flex justify-between mt-6 pt-6 border-t border-white/10">
                    <button type="button" id="prevBtn" class="px-6 py-2 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors disabled:opacity-0" onclick="changeStep(-1)">
                        Back
                    </button>
                    <button type="button" id="nextBtn" class="px-8 py-2 rounded-lg bg-gradient-to-r from-primary to-secondary text-white font-bold hover:opacity-90 transition-opacity" onclick="changeStep(1)">
                        Next Step
                    </button>
                </div>
            </form>
        </div>
    </div>
    </section>
@endsection

@push('scripts')
    <!-- Logic Script -->
    <script>
        let currentStep = 1;
        const totalSteps = 6;
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const progressBar = document.getElementById('progress-bar');
        const safetyAlert = document.getElementById('safety-alert');
        const errorMessage = document.getElementById('step-error-message');
        let safetyLock = false;


        // Form Logic
        function updateUI() {
            // Update Progress Bar
            const progress = (currentStep / totalSteps) * 100;
            progressBar.style.width = `${progress}%`;

            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
            
            // Show current step
            document.querySelector(`.step-content[data-step="${currentStep}"]`).classList.add('active');

            // Button Visibility
            prevBtn.disabled = currentStep === 1;
            prevBtn.style.opacity = currentStep === 1 ? '0' : '1';
            
            if (currentStep === totalSteps) {
                nextBtn.innerText = "Submit Form";
            } else {
                nextBtn.innerText = "Next Step";
            }
        }

        function checkSafety(radio) {
            // Logic: Warn if they say YES to replacement
            if (radio.value === 'yes') {
                safetyLock = false; 
                safetyAlert.classList.remove('hidden');
            } else {
                safetyAlert.classList.add('hidden');
            }
        }

        function validateStep(step) {
            const currentStepEl = document.querySelector(`.step-content[data-step="${step}"]`);
            const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
            let isValid = true;

            // Reset Error Styles
            errorMessage.classList.add('hidden');
            currentStepEl.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

            inputs.forEach(input => {
                let isInputValid = true;

                if (input.type === 'radio') {
                    const name = input.name;
                    const checked = currentStepEl.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        isInputValid = false;
                        // Highlight radio containers
                        const radios = currentStepEl.querySelectorAll(`input[name="${name}"]`);
                        radios.forEach(radio => {
                            const container = radio.nextElementSibling;
                            if (container) container.classList.add('border-red-500');
                        });
                    }
                } else if (input.type === 'checkbox') {
                    // Checkboxes logic if needed
                } else {
                    if (!input.value.trim()) {
                        isInputValid = false;
                        input.classList.add('border-red-500');
                    }
                }

                if (!isInputValid) isValid = false;
            });

            if (!isValid) {
                // Show error text
                errorMessage.classList.remove('hidden');
                
                // Shake button
                nextBtn.classList.add('animate-shake');
                setTimeout(() => nextBtn.classList.remove('animate-shake'), 500);
                return false;
            }
            return true;
        }

        function changeStep(direction) {
            if (direction === 1 && !validateStep(currentStep)) return;

            const newStep = currentStep + direction;

            if (newStep > totalSteps) {
                submitForm();
            } else if (newStep > 0) {
                currentStep = newStep;
                updateUI();
                // Scroll to top of form
                document.querySelector('.glass').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }

        function submitForm() {
            const form = document.getElementById('multi-step-form');
            const duplicateFormData = new FormData(form);
            const data = Object.fromEntries(duplicateFormData.entries());
            
            // Checkboxes adjustment
            const checkboxes = form.querySelectorAll('input[type="checkbox"]:checked');
            if (checkboxes.length > 0) {
                 data.impact_area = Array.from(checkboxes).map(cb => cb.value);
            }

            // Show loading state (optional UI tweak)
            const nextBtn = document.getElementById('nextBtn');
            const originalBtnText = nextBtn.innerText;
            nextBtn.innerText = "Sending...";
            nextBtn.disabled = true;

            fetch('/healing-submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Success UI
                document.getElementById('nav-buttons').style.display = 'none';
                errorMessage.style.display = 'none';
                document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
                document.getElementById('progress-bar').parentElement.style.display = 'none';
                document.getElementById('success-message').classList.remove('hidden');
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('There was an error sending your form. Please try again.');
                nextBtn.innerText = originalBtnText;
                nextBtn.disabled = false;
            });
        }

        // Initialize
        updateUI();

    </script>
@endpush
