<!DOCTYPE html>
<html lang="ne" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="वनको खबर - नेपाली वन, वातावरण, जलवायु परिवर्तन र वन्यजन्तु समाचारको आधुनिक पोर्टल।">
        <link rel="icon" type="image/png" href="{{ asset('image/fev icon.png') }}">
        <title>@yield('title', 'वनको खबर | नेपाली वन र वातावरण समाचार')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#F8FAF5] text-[#212121] antialiased transition-colors duration-300 dark:bg-[#0f1720] dark:text-[#edf5ee]">
        <header class="sticky top-0 z-50 border-b border-green-900/10 bg-white/80 backdrop-blur-xl transition-all duration-300 dark:border-white/10 dark:bg-[#0f1720]/80">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-3 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="flex min-w-0 items-center overflow-hidden rounded-2xl border border-[#dfeae0] bg-[#edf7ee]/80 p-1.5 shadow-sm shadow-green-900/10 transition hover:shadow-md sm:p-2">
                    <img src="{{ asset('image/logo.png') }}" alt="वनको खबर logo" class="h-10 w-auto max-w-[160px] object-contain sm:h-14 sm:max-w-[220px]">
                </a>

                <nav class="hidden items-center gap-6 text-sm font-medium text-[#2b3a2d] lg:flex dark:text-[#e9f0eb]">
                    <a href="{{ route('home') }}" class="transition hover:text-[#2E7D32] {{ request()->routeIs('home') ? 'text-[#2E7D32]' : '' }}">गृहपृष्ठ</a>
                    <a href="{{ route('home') }}#news" class="transition hover:text-[#2E7D32]">समाचार</a>
                    <a href="{{ route('home') }}#categories" class="transition hover:text-[#2E7D32]">वन संरक्षण</a>
                    <a href="{{ route('home') }}#wildlife" class="transition hover:text-[#2E7D32]">वन्यजन्तु</a>
                    <a href="{{ route('home') }}#environment" class="transition hover:text-[#2E7D32]">वातावरण</a>
                    <a href="{{ route('home') }}#climate" class="transition hover:text-[#2E7D32]">जलवायु परिवर्तन</a>
                    <a href="{{ route('gallery') }}" class="transition hover:text-[#2E7D32] {{ request()->routeIs('gallery') ? 'text-[#2E7D32]' : '' }}">ग्यालरी</a>
                    <a href="{{ route('about') }}" class="transition hover:text-[#2E7D32] {{ request()->routeIs('about') ? 'text-[#2E7D32]' : '' }}">हाम्रो बारेमा</a>
                    <a href="{{ route('contact') }}" class="transition hover:text-[#2E7D32] {{ request()->routeIs('contact') ? 'text-[#2E7D32]' : '' }}">सम्पर्क</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('search') }}" aria-label="Search" class="hidden h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-[#1B5E20] transition hover:border-[#2E7D32] hover:text-[#2E7D32] dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee] sm:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="6"></circle>
                            <path d="M16 16L21 21"></path>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}" class="hidden rounded-full bg-[#2E7D32] px-4 py-2 text-sm font-semibold text-white shadow-md shadow-[#2E7D32]/20 transition hover:bg-[#1B5E20] sm:inline-flex">Login</a>
                    <a href="{{ route('register') }}" class="hidden rounded-full border border-[#2E7D32] px-4 py-2 text-sm font-semibold text-[#1B5E20] transition hover:bg-[#2E7D32] hover:text-white sm:inline-flex dark:text-[#edf5ee]">Register</a>
                    <button type="button" data-menu-toggle aria-expanded="false" aria-label="Toggle navigation menu" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-[#1B5E20] transition hover:border-[#2E7D32] lg:hidden dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <nav data-mobile-menu class="hidden bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] lg:hidden">
                <div class="mx-auto flex min-h-[calc(100vh-72px)] max-w-7xl flex-col gap-3 px-4 py-5 text-sm font-medium text-[#2b3a2d]">
                    <a href="{{ route('home') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('home') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">गृहपृष्ठ</a>
                    <a href="{{ route('home') }}#news" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">समाचार</a>
                    <a href="{{ route('home') }}#categories" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वन संरक्षण</a>
                    <a href="{{ route('home') }}#wildlife" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वन्यजन्तु</a>
                    <a href="{{ route('home') }}#environment" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वातावरण</a>
                    <a href="{{ route('home') }}#climate" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">जलवायु परिवर्तन</a>
                    <a href="{{ route('gallery') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('gallery') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">ग्यालरी</a>
                    <a href="{{ route('about') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('about') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">हाम्रो बारेमा</a>
                    <a href="{{ route('contact') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('contact') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">सम्पर्क</a>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="mt-20 border-t border-[#dfeae0] bg-[#f3f8f1] dark:border-white/10 dark:bg-[#101b1f]">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-14 w-14 rounded-2xl object-cover shadow-lg shadow-green-900/20 sm:h-16 sm:w-16">
                            <div>
                                <div class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#dfead5]">वनको खबर</div>
                                <div class="text-[10px] uppercase tracking-[0.25em] text-[#6b7a6c] dark:text-[#a4b4a5]">Forest News</div>
                            </div>
                        </div>
                        <p class="mt-5 max-w-md text-sm leading-7 text-[#4e5b51] dark:text-[#cfe2cf]">
                            नेपाली जंगल, वन्यजन्तु, जलवायु परिवर्तन, र वातावरणीय रिपोर्टिङमा आधारित तथ्यपरक समाचार पोर्टल।
                        </p>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Quick Links</h3>
                        <ul class="mt-5 space-y-3 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">
                            <li><a href="{{ route('home') }}" class="hover:text-[#2E7D32]">गृहपृष्ठ</a></li>
                            <li><a href="{{ route('home') }}#news" class="hover:text-[#2E7D32]">समाचार</a></li>
                            <li><a href="{{ route('gallery') }}" class="hover:text-[#2E7D32]">ग्यालरी</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-[#2E7D32]">हाम्रो बारेमा</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Categories</h3>
                        <ul class="mt-5 space-y-3 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">
                            <li>वन संरक्षण</li>
                            <li>वन्यजन्तु</li>
                            <li>वातावरण</li>
                            <li>जलवायु परिवर्तन</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-[#1B5E20] dark:text-[#edf5ee]">Contact</h3>
                        <ul class="mt-5 space-y-3 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">
                            <li>काठमाडौं, नेपाल</li>
                            <li>editorial@vankokhabar.com.np</li>
                            <li>+977-1-4567890</li>
                            <li>Facebook • Instagram</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 flex flex-col items-center justify-between border-t border-[#dfeae0] pt-6 text-sm text-[#4e5b51] dark:border-white/10 dark:text-[#d3e3d5] md:flex-row">
                    <p>© २०८१ वनको खबर. सबै हक सुरक्षित।</p>
                    <div class="mt-3 flex gap-5 md:mt-0">
                        <a href="#" class="hover:text-[#2E7D32]">Privacy</a>
                        <a href="#" class="hover:text-[#2E7D32]">Terms</a>
                        <a href="#" class="hover:text-[#2E7D32]">Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
