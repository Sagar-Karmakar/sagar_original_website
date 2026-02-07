@extends('layouts.app')

@section('title', 'Terms and Conditions | Sagar Karmakar')

@push('styles')
<style>
    .prose h2 { color: #f8fafc; margin-top: 2em; margin-bottom: 1em; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; }
    .prose h3 { color: #e2e8f0; margin-top: 1.5em; margin-bottom: 0.75em; font-weight: 600; font-size: 1.25rem; }
    .prose p { margin-bottom: 1.25em; line-height: 1.75; color: #cbd5e1; }
    .prose ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1.25em; color: #cbd5e1; }
    .prose li { margin-bottom: 0.5em; }
</style>
@endpush

@section('menu')
    <a href="{{ url()->previous() }}" class="text-sm font-medium hover:text-white transition-colors text-gray-300">&larr; Back</a>
@endsection

@section('content')
    <div class="pt-32 pb-20 px-4">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-12 font-serif text-white">Terms and Conditions</h1>
            
            <div class="prose prose-lg prose-invert max-w-none">
                <p>By accessing or using this website (sagarkarmakar.com), you agree to the following terms and conditions. If you do not agree, please do not use this site.</p>

                <h2>Use of the Website</h2>
                <p>This website is provided for informational and educational purposes only. You agree to use it responsibly and lawfully.</p>
                <p>You may not:</p>
                <ul>
                    <li>Attempt to disrupt or damage the site</li>
                    <li>Use the content for unlawful purposes</li>
                    <li>Misrepresent your identity or intentions</li>
                </ul>

                <h2>No Professional Guarantees</h2>
                <p>Any content on this website reflects personal insights, experiences, or general guidance. It does not constitute medical, legal, or financial advice.</p>
                <p>Results may vary from person to person, and no guarantees are made regarding outcomes.</p>

                <h2>Intellectual Property</h2>
                <p>All content on this website, including text, design, and branding, is the property of Sagar Karmakar unless otherwise stated.</p>
                <p>You may not copy, reproduce, or distribute content without prior written permission.</p>

                <h2>External Links</h2>
                <p>This website may contain links to external websites. We are not responsible for the content, policies, or practices of any third-party sites.</p>

                <h2>Limitation of Liability</h2>
                <p>We are not liable for any direct or indirect loss or damage arising from the use of this website or reliance on its content.</p>
                <p>Use of the site is at your own discretion and risk.</p>

                <h2>Changes to These Terms</h2>
                <p>These terms may be updated at any time without prior notice. Continued use of the website means you accept the revised terms.</p>

                <h2>Governing Law</h2>
                <p>These terms are governed by applicable local laws, without regard to conflict of law principles.</p>

                <h2>Contact</h2>
                <p>If you have questions about these Terms and Conditions, contact:</p>
                <p>Email: <a href="mailto:contact@sagarkarmakar.com" class="text-secondary hover:text-white transition-colors">contact@sagarkarmakar.com</a></p>
            </div>
        </div>
    </div>
@endsection
