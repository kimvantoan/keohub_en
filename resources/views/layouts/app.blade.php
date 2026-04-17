<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Football Predictions and Latest Football News')">
    <title>@yield('title', 'KeoHub - Football Predictions & Articles')</title>

    <!-- Tailwind v4 (App CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen @if(View::hasSection('is_dashboard')) h-screen overflow-hidden @endif">
    
    <!-- Header -->
    <header class="bg-white text-gray-800 shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-outfit font-bold text-primary flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 4.14A6.002 6.002 0 0115.86 11H9V4.14zm-2 0V11H2.14A6.002 6.002 0 017 4.14zM2.14 13H7v6.86A6.002 6.002 0 012.14 13zm7 0h6.86A6.002 6.002 0 019 19.86V13z"></path></svg>
                KeoHub
            </a>

            <!-- Navigation (Desktop) -->
            <nav class="hidden md:flex gap-8 font-semibold text-[15px]">
                <a href="/" class="{{ request()->is('/') ? 'text-primary underline underline-offset-8 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">Home</a>
                <a href="#" class="{{ request()->is('match*') ? 'text-primary underline underline-offset-8 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">Match</a>
                <a href="/news" class="{{ request()->is('news*') ? 'text-primary underline underline-offset-8 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">News</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-gray-800 hover:text-primary focus:outline-none transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>

        <!-- Mobile Navigation Panel -->
        <div id="mobile-menu" class="hidden md:hidden absolute left-0 w-full top-full bg-white border-t border-gray-100 shadow-xl">
            <nav class="flex flex-col px-6 py-6 gap-5 font-semibold text-[15px]">
                <a href="/" class="{{ request()->is('/') ? 'text-primary underline underline-offset-4 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">Home</a>
                <a href="#" class="{{ request()->is('match*') ? 'text-primary underline underline-offset-4 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">Match</a>
                <a href="/news" class="{{ request()->is('news*') ? 'text-primary underline underline-offset-4 decoration-2' : 'text-gray-600 hover:text-primary transition-colors' }}">News</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow w-full @if(View::hasSection('is_dashboard')) flex flex-col overflow-hidden @else container mx-auto px-4 md:px-6 lg:px-8 py-8 max-w-7xl @endif">
        @yield('content')
    </main>

    <!-- Footer -->
    @if(!View::hasSection('is_dashboard'))
    <footer class="bg-secondary text-gray-400 pt-16 pb-8 border-t border-gray-800 mt-auto">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <!-- Column 1: Brand & Description -->
                <div>
                    <h3 class="text-primary font-outfit text-xl font-bold mb-4">KeoHub</h3>
                    <p class="text-gray-400 leading-relaxed mb-6 font-sans">
                        High-end editorial coverage and expert predictions for the beautiful game. Built for the modern football supporter.
                    </p>
                    <div class="flex items-center gap-4 text-primary">
                        <!-- Football Icon -->
                        <a href="#" class="hover:text-primary-dark transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3 3"></path>
                            </svg>
                        </a>
                        <!-- News Icon -->
                        <a href="#" class="hover:text-primary-dark transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                            </svg>
                        </a>
                        <!-- Monitor Icon -->
                        <a href="#" class="hover:text-primary-dark transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Top Leagues -->
                <div>
                    <h3 class="text-white font-outfit text-xl font-bold mb-4">Top Leagues</h3>
                    <ul class="flex flex-col gap-3 font-sans">
                        <li><a href="#" class="hover:text-white transition-colors">Premier League</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">La Liga</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Champions League</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Transfer News</a></li>
                    </ul>
                </div>

                <!-- Column 3: Information -->
                <div>
                    <h3 class="text-white font-outfit text-xl font-bold mb-4">Information</h3>
                    <ul class="flex flex-col gap-3 font-sans">
                        <li><a href="/about" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="/contact" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="/privacy" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="/disclaimer" class="hover:text-white transition-colors">Disclaimer</a></li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="border-t border-gray-800 pt-8 text-center md:text-right font-sans text-sm">
                <p>&copy; {{ date('Y') }} KeoHub. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @endif

    <!-- JavaScript for Mobile Menu -->
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                // Optional: Change icon to 'Close' X
                this.innerHTML = '<svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            } else {
                menu.classList.add('hidden');
                // Revert to hamburger icon
                this.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>';
            }
        });
    </script>
</body>
</html>
