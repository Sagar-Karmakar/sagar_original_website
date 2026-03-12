<footer class="border-t border-white/5 bg-black/40 pt-12 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left">
            <div class="mb-4 md:mb-0">
                <span class="text-3xl font-bold font-logo text-white block">Sagar Karmakar</span>
                <span class="text-sm font-medium text-primary tracking-widest uppercase mt-1 block">Relationship Alignment</span>
                <p class="text-gray-400 text-sm mt-3 max-w-sm">Helping people build healthy relationships through<br>
                <span class="text-white font-medium">Self-Respect • Emotional Maturity • Communication</span></p>
            </div>
            <div class="text-gray-500 text-sm flex flex-col items-center md:items-end mt-6 md:mt-0">
                <p>&copy; {{ date('Y') }} Sagar Karmakar.</p>
                <div class="mt-2 space-x-4 text-xs">
                    <a href="{{ route('privacy') }}" class="hover:text-primary transition-colors">Privacy Policy</a>
                    <span>|</span>
                    <a href="{{ route('terms') }}" class="hover:text-primary transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>
