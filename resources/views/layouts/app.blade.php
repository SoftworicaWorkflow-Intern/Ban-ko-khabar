<!DOCTYPE html>
<html lang="ne" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="वनको खबर - नेपाली वन, वातावरण, जलवायु परिवर्तन र वन्यजन्तु समाचारको आधुनिक पोर्टल।">
        <link rel="icon" type="image/png" href="{{ asset('image/fev icon.png') }}">
        <title>@yield('title', 'वनको खबर | नेपाली वन र वातावरण समाचार')</title>
        {{-- In production, Vite assets are served from the compiled build manifest. --}}
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-[#F8FAF5] text-[#212121] antialiased transition-colors duration-300 dark:bg-[#0f1720] dark:text-[#edf5ee]">
        @if (request()->routeIs('home'))
            <header class="relative">
                <div class="border-b border-[#e5ece5] bg-white text-[#1d2a1d] dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                    <div class="mx-auto grid max-w-7xl grid-cols-[auto_minmax(0,1fr)] items-center gap-3 px-3 py-3 sm:grid-cols-[auto_minmax(0,1fr)_auto] sm:gap-5 sm:px-6 lg:px-8">
                        <a href="{{ route('home') }}" aria-label="वनको खबर गृहपृष्ठ" class="col-start-1 row-start-1 flex items-center">
                            <img src="{{ asset('image/logo.png') }}" alt="वनको खबर logo" class="h-12 w-auto max-w-[140px] object-contain sm:h-14 sm:max-w-[220px]">
                        </a>

                        <div aria-label="Social media" class="col-start-2 row-start-1 flex items-center justify-self-end gap-2 sm:col-start-3 sm:gap-3">
                            <span title="Facebook" class="flex h-12 w-12 items-center justify-center rounded-full bg-[#1877F2] text-xl font-bold text-white shadow-sm sm:h-14 sm:w-14 sm:text-2xl">f</span>
                            <span title="YouTube" class="flex h-12 w-12 items-center justify-center rounded-full bg-[#FF0000] text-white shadow-sm sm:h-14 sm:w-14">
                                <span aria-hidden="true" class="ml-0.5 h-0 w-0 border-y-[7px] border-y-transparent border-l-[12px] border-l-white"></span>
                            </span>
                        </div>

                        <div class="relative col-span-2 row-start-2 min-w-0 sm:col-span-1 sm:col-start-2 sm:row-start-1">
                            @if (isset($homeAdvertisements) && $homeAdvertisements->has('header'))
                                @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('header')])
                            @else
                                <div class="relative min-w-0 overflow-hidden border-l-4 border-[#f5c64a] bg-[#b5162a] text-white shadow-md shadow-red-950/10">
                                    <div class="relative grid grid-cols-[48px_minmax(0,1fr)] items-center gap-2 px-3 py-3 md:grid-cols-[64px_minmax(0,1fr)_230px] md:gap-3 md:px-4">
                                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=180&h=220&q=85" alt="व्यवसाय प्रतिनिधि" class="h-14 w-12 rounded-sm object-cover object-top md:h-[66px] md:w-16">
                                        <div class="min-w-0 text-center md:text-left">
                                            <p class="text-[8px] font-bold uppercase tracking-[0.12em] text-[#ffe59a] sm:text-[9px]">Education · Skills · Careers</p>
                                            <h2 class="mt-0.5 font-display text-base font-black leading-tight sm:text-lg">तपाईंको उज्ज्वल भविष्यको सुरुवात</h2>
                                            <div class="mt-1.5 flex flex-wrap justify-center gap-1 md:justify-start">
                                                <span class="rounded-sm bg-white/15 px-1.5 py-0.5 text-[8px] font-semibold">उच्च शिक्षा</span>
                                                <span class="rounded-sm bg-white/15 px-1.5 py-0.5 text-[8px] font-semibold">प्राविधिक सीप</span>
                                                <span class="rounded-sm bg-white/15 px-1.5 py-0.5 text-[8px] font-semibold">करियर तालिम</span>
                                            </div>
                                        </div>
                                        <div class="col-span-2 border-t border-white/25 pt-2 text-center text-[9px] leading-4 md:col-span-1 md:border-l md:border-t-0 md:pl-3 md:pt-0 md:text-left md:text-[10px] md:leading-5">
                                            <p class="font-bold">Bharatpur · Gaindakot · Kawasoti</p>
                                            <p>056-594273 · 078-540086 · 9855063983</p>
                                            <a href="https://www.centralcollege.com.np" target="_blank" rel="noopener noreferrer" class="mt-1 inline-flex rounded-sm bg-[#f5c64a] px-2 py-1 font-extrabold text-[#54202a] transition hover:bg-white">www.centralcollege.com.np <span aria-hidden="true" class="ml-1">↗</span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </header>
        @elseif (! request()->routeIs('admin.*'))
            <header class="relative">
                <div class="border-b border-[#e5ece5] bg-white text-[#1d2a1d] dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                    <div class="mx-auto grid max-w-7xl grid-cols-[auto_minmax(0,1fr)] items-center gap-3 px-3 py-3 sm:grid-cols-[auto_minmax(0,1fr)_auto] sm:gap-5 sm:px-6 lg:px-8">
                        <a href="{{ route('home') }}" aria-label="वनको खबर गृहपृष्ठ" class="col-start-1 row-start-1 flex items-center">
                            <img src="{{ asset('image/logo.png') }}" alt="वनको खबर logo" class="h-12 w-auto max-w-[140px] object-contain sm:h-14 sm:max-w-[220px]">
                        </a>

                        <div aria-label="Social media" class="col-start-2 row-start-1 flex items-center justify-self-end gap-2 sm:col-start-3 sm:gap-3">
                            <span title="Facebook" class="flex h-12 w-12 items-center justify-center rounded-full bg-[#1877F2] text-xl font-bold text-white shadow-sm sm:h-14 sm:w-14 sm:text-2xl">f</span>
                            <span title="YouTube" class="flex h-12 w-12 items-center justify-center rounded-full bg-[#FF0000] text-white shadow-sm sm:h-14 sm:w-14">
                                <span aria-hidden="true" class="ml-0.5 h-0 w-0 border-y-[7px] border-y-transparent border-l-[12px] border-l-white"></span>
                            </span>
                        </div>

                        @if (isset($sharedHeaderAdvertisements) && $sharedHeaderAdvertisements->isNotEmpty())
                            <div class="relative col-span-2 row-start-2 min-w-0 sm:col-span-1 sm:col-start-2 sm:row-start-1">
                                @include('partials.advertisement-placement', ['advertisements' => $sharedHeaderAdvertisements])
                            </div>
                        @endif
                    </div>
                </div>
            </header>
        @endif

        <header class="sticky top-0 z-50 border-b border-green-900/10 bg-[#0f3d24]/90 text-white shadow-lg shadow-green-900/10 backdrop-blur-xl transition-all duration-300 dark:border-white/10 dark:bg-[#0f1720]/90">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-3 py-4 sm:gap-5 sm:px-6 sm:py-5 lg:px-8">
                <nav class="hidden items-center gap-7 text-base font-medium text-white/90 lg:flex dark:text-[#e9f0eb]">
                    <details class="group relative">
                        <summary class="flex cursor-pointer list-none items-center gap-1 py-2 transition hover:text-[#d4f6d8] [&::-webkit-details-marker]:hidden {{ request()->routeIs('home') ? 'text-[#d4f6d8]' : '' }}">
                            गृहपृष्ठ
                            <svg class="h-3.5 w-3.5 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.09 1.03l-4.25 4.5a.75.75 0 0 1-1.09 0l-4.25-4.5a.75.75 0 0 1 .02-1.05Z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="absolute left-0 top-full z-50 mt-3 hidden min-w-56 overflow-hidden rounded-lg border border-[#dfeae0] bg-white py-2 text-sm text-[#263d2b] shadow-xl shadow-black/10 group-open:block dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                            <a href="{{ route('home') }}#news" class="block px-4 py-2.5 transition hover:bg-[#edf6ee] hover:text-[#2E7D32] dark:hover:bg-[#20332d]">मुख्य समाचार</a>
                            <a href="{{ route('home') }}#categories" class="block px-4 py-2.5 transition hover:bg-[#edf6ee] hover:text-[#2E7D32] dark:hover:bg-[#20332d]">विषयगत क्षेत्र</a>
                            <a href="{{ route('home') }}#environment" class="block px-4 py-2.5 transition hover:bg-[#edf6ee] hover:text-[#2E7D32] dark:hover:bg-[#20332d]">फोटो ग्यालरी</a>
                            <a href="{{ route('home') }}#mission" class="block px-4 py-2.5 transition hover:bg-[#edf6ee] hover:text-[#2E7D32] dark:hover:bg-[#20332d]">मिशन</a>
                        </div>
                    </details>
                    <a href="{{ route('home') }}#news" class="py-2 transition hover:text-[#d4f6d8]">समाचार</a>
                    <a href="{{ route('category.show', ['slug' => 'forest-conservation']) }}" class="py-2 transition hover:text-[#d4f6d8]">वन संरक्षण</a>
                    <a href="{{ route('category.show', ['slug' => 'wildlife']) }}" class="py-2 transition hover:text-[#d4f6d8]">वन्यजन्तु</a>
                    <a href="{{ route('category.show', ['slug' => 'environment']) }}" class="py-2 transition hover:text-[#d4f6d8]">वातावरण</a>
                    <a href="{{ route('category.show', ['slug' => 'climate-change']) }}" class="py-2 transition hover:text-[#d4f6d8]">जलवायु परिवर्तन</a>
                    <a href="{{ route('gallery') }}" class="py-2 transition hover:text-[#d4f6d8] {{ request()->routeIs('gallery') ? 'text-[#d4f6d8]' : '' }}">ग्यालरी</a>
                    <a href="{{ route('about') }}" class="py-2 transition hover:text-[#d4f6d8] {{ request()->routeIs('about') ? 'text-[#d4f6d8]' : '' }}">हाम्रो बारेमा</a>
                    <a href="{{ route('contact') }}" class="py-2 transition hover:text-[#d4f6d8] {{ request()->routeIs('contact') ? 'text-[#d4f6d8]' : '' }}">सम्पर्क</a>
                </nav>

                <div class="flex items-center gap-2 sm:gap-3">
                    <a href="{{ route('search') }}" aria-label="खोज्नुहोस्" title="Search" class="flex h-10 items-center justify-center gap-1.5 rounded-full border border-[#dfeae0] bg-white px-2.5 text-[#1B5E20] transition hover:border-[#2E7D32] hover:text-[#2E7D32] sm:h-11 sm:gap-2 sm:px-3 dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="6"></circle>
                            <path d="M16 16L21 21"></path>
                        </svg>
                        <span class="text-[10px] font-semibold sm:text-xs">खोज्नुहोस्</span>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex h-10 items-center rounded-full bg-[#2E7D32] px-3 text-xs font-semibold text-white shadow-md shadow-[#2E7D32]/20 transition hover:bg-[#1B5E20] sm:h-11 sm:px-4 sm:text-sm">Login</a>
                    <a href="{{ route('register') }}" class="inline-flex h-10 items-center rounded-full border border-white px-3 text-xs font-semibold text-white transition hover:bg-white hover:text-[#1B5E20] sm:h-11 sm:px-4 sm:text-sm dark:text-[#edf5ee]">Register</a>
                    <button type="button" data-menu-toggle aria-expanded="false" aria-label="Toggle navigation menu" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-[#1B5E20] transition hover:border-[#2E7D32] sm:h-11 sm:w-11 lg:hidden dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 7h16M4 12h16M4 17h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <nav data-mobile-menu class="hidden bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] lg:hidden">
                <div class="mx-auto flex min-h-[calc(100vh-72px)] max-w-7xl flex-col gap-3 px-4 py-5 text-sm font-medium text-[#2b3a2d]">
                    <details class="group rounded-xl">
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] [&::-webkit-details-marker]:hidden {{ request()->routeIs('home') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">
                            गृहपृष्ठ
                            <svg class="h-4 w-4 transition-transform group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.09 1.03l-4.25 4.5a.75.75 0 0 1-1.09 0l-4.25-4.5a.75.75 0 0 1 .02-1.05Z" clip-rule="evenodd"/></svg>
                        </summary>
                        <div class="ml-3 flex flex-col border-l border-[#dfeae0] py-1 pl-3 dark:border-white/10">
                            <a href="{{ route('home') }}#news" class="rounded-lg px-3 py-2.5 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">मुख्य समाचार</a>
                            <a href="{{ route('home') }}#categories" class="rounded-lg px-3 py-2.5 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">विषयगत क्षेत्र</a>
                            <a href="{{ route('home') }}#environment" class="rounded-lg px-3 py-2.5 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">फोटो ग्यालरी</a>
                            <a href="{{ route('home') }}#mission" class="rounded-lg px-3 py-2.5 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">मिशन</a>
                        </div>
                    </details>
                    <a href="{{ route('home') }}#news" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">समाचार</a>
                    <a href="{{ route('category.show', ['slug' => 'forest-conservation']) }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वन संरक्षण</a>
                    <a href="{{ route('category.show', ['slug' => 'wildlife']) }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वन्यजन्तु</a>
                    <a href="{{ route('category.show', ['slug' => 'environment']) }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">वातावरण</a>
                    <a href="{{ route('category.show', ['slug' => 'climate-change']) }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32]">जलवायु परिवर्तन</a>
                    <a href="{{ route('gallery') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('gallery') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">ग्यालरी</a>
                    <a href="{{ route('about') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('about') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">हाम्रो बारेमा</a>
                    <a href="{{ route('contact') }}" class="rounded-xl px-3 py-3 transition hover:bg-[#eef7ee] hover:text-[#2E7D32] {{ request()->routeIs('contact') ? 'bg-[#eef7ee] text-[#2E7D32]' : '' }}">सम्पर्क</a>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        @if (request()->routeIs('home') && isset($homeAdvertisements) && $homeAdvertisements->has('footer'))
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('footer')])
            </div>
        @endif

        <footer class="mt-20 border-t border-green-900/20 bg-[#0f3d24] text-green-50 dark:border-white/10 dark:bg-[#101b1f]">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-14 w-14 rounded-2xl object-cover shadow-lg shadow-green-900/20 sm:h-16 sm:w-16">
                            <div>
                                <div class="font-display text-2xl font-bold text-white dark:text-[#dfead5]">वनको खबर</div>
                                <div class="text-[10px] uppercase tracking-[0.25em] text-green-200 dark:text-[#a4b4a5]">Forest News</div>
                            </div>
                        </div>
                        <p class="mt-5 max-w-md text-sm leading-7 text-green-100/80 dark:text-[#cfe2cf]">
                            नेपाली जंगल, वन्यजन्तु, जलवायु परिवर्तन, र वातावरणीय रिपोर्टिङमा आधारित तथ्यपरक समाचार पोर्टल।
                        </p>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-white dark:text-[#edf5ee]">Quick Links</h3>
                        <ul class="mt-5 space-y-3 text-sm text-green-50/85 dark:text-[#d3e3d5]">
                            <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">गृहपृष्ठ</a></li>
                            <li><a href="{{ route('home') }}#news" class="hover:text-white transition-colors">समाचार</a></li>
                            <li><a href="{{ route('gallery') }}" class="hover:text-white transition-colors">ग्यालरी</a></li>
                            <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">हाम्रो बारेमा</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-white dark:text-[#edf5ee]">Categories</h3>
                        <ul class="mt-5 space-y-3 text-sm text-green-50/85 dark:text-[#d3e3d5]">
                            <li>वन संरक्षण</li>
                            <li>वन्यजन्तु</li>
                            <li>वातावरण</li>
                            <li>जलवायु परिवर्तन</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-display text-lg font-semibold text-white dark:text-[#edf5ee]">Contact</h3>
                        <ul class="mt-5 space-y-3 text-sm text-green-50/85 dark:text-[#d3e3d5]">
                            <li>काठमाडौं, नेपाल</li>
                            <li>editorial@vankokhabar.com.np</li>
                            <li>+977-1-4567890</li>
                            <li>Facebook • Instagram</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 flex flex-col items-center justify-between border-t border-[#dfeae0] pt-6 text-sm text-green-50/85 dark:border-white/10 dark:text-[#d3e3d5] md:flex-row">
                    <p>© २०८१ वनको खबर. सबै हक सुरक्षित।</p>
                    <div class="mt-3 flex flex-wrap items-center justify-center gap-5 md:mt-0 md:justify-end">
                        <a href="{{ route('privacy') }}" class="hover:text-white transition-colors">Privacy</a>
                        <a href="{{ route('terms') }}" class="hover:text-white transition-colors">Terms</a>
                        <a href="{{ route('support') }}" class="hover:text-white transition-colors">Support</a>
                        <div class="flex items-center gap-2 text-xs text-green-50/85" aria-label="Powered by Softworica">
                            <span>Powered by</span>
                            <div class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-[#171078] shadow-sm" role="img" aria-label="Softworica">
                                <svg class="h-5 w-7 shrink-0" viewBox="0 0 32 24" fill="none" aria-hidden="true">
                                    <path d="M2 17 15 10M4 21l11-6M8 13l7-4M12 5l8-4" stroke="#18C65A" stroke-width="2.6" stroke-linecap="round"/>
                                    <path d="m17 8 12-6-5 10-10 7 3-7 8-5-9 3 1-2Z" fill="#21158D"/>
                                </svg>
                                <span class="text-sm font-bold text-[#171078]">Softworica</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
