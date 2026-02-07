@extends('layouts.app')

@section('title', 'Privacy Policy | Sagar Karmakar')

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
            <h1 class="text-4xl md:text-5xl font-bold mb-12 font-serif text-white">Privacy Policy</h1>
            
            <div class="prose prose-lg prose-invert max-w-none">
                <p><strong>Your privacy matters.</strong> This Privacy Policy explains how information is collected, used, and protected when you visit or interact with this website (sagarkarmakar.com).</p>

                <p>By using this website, you agree to the practices described below.</p>

                <h2>Information We Collect</h2>
                <p>We may collect limited personal information when you voluntarily provide it, such as:</p>
                <ul>
                    <li>Your name</li>
                    <li>Your email address</li>
                    <li>Any message or information you submit through a form</li>
                </ul>
                <p>We do not collect sensitive personal data unless you explicitly choose to share it.</p>

                <h2>How Your Information Is Used</h2>
                <p>Any information you provide is used only to:</p>
                <ul>
                    <li>Respond to your inquiry</li>
                    <li>Communicate with you when requested</li>
                    <li>Improve the clarity and usefulness of this website</li>
                </ul>
                <p>We do not sell, rent, or trade your personal information to third parties.</p>

                <h2>Cookies and Tracking</h2>
                <p>This website may use basic cookies or analytics tools to understand how visitors interact with the site. This helps improve performance and user experience.</p>
                <p>You can disable cookies through your browser settings if you prefer.</p>

                <h2>Third-Party Services</h2>
                <p>We may use trusted third-party tools for:</p>
                <ul>
                    <li>Website analytics</li>
                    <li>Email communication</li>
                    <li>Advertising platforms such as Facebook or Google</li>
                </ul>
                <p>These services may collect data according to their own privacy policies. We are not responsible for how third-party platforms manage their data.</p>

                <h2>Data Security</h2>
                <p>Reasonable measures are taken to protect your information. However, no method of transmission over the internet is 100 percent secure, and absolute security cannot be guaranteed.</p>

                <h2>Your Rights</h2>
                <p>You may request:</p>
                <ul>
                    <li>Access to the personal information you shared</li>
                    <li>Correction or deletion of that information</li>
                </ul>
                <p>To do so, contact us using the details below.</p>

                <h2>Contact</h2>
                <p>If you have questions about this Privacy Policy or how your information is handled, you can contact:</p>
                <p>Email: <a href="mailto:contact@sagarkarmakar.com" class="text-secondary hover:text-white transition-colors">contact@sagarkarmakar.com</a></p>

                <h2>Updates to This Policy</h2>
                <p>This Privacy Policy may be updated occasionally. Any changes will be posted on this page.</p>
            </div>
        </div>
    </div>
@endsection
