{{-- Modern Newsroom Admin Dashboard Top Navigation Bar --}}
<header class="sticky top-0 z-40 mb-6 h-[76px] rounded-[20px] border border-[#E5E7EB] bg-white/95 px-3 sm:px-5 shadow-[0_10px_30px_rgba(15,23,42,0.06)] backdrop-blur-md transition-all duration-300">
    <div class="flex h-full items-center gap-2 sm:gap-4">
        
        {{-- ================= LEFT SECTION ================= --}}
        <div class="flex shrink-0 items-center gap-2 sm:gap-2.5">
            {{-- 1. Hamburger Menu Button (Sidebar Toggle) --}}
            <button type="button" 
                    id="adminSidebarToggle" 
                    aria-label="Toggle Navigation Sidebar" 
                    title="Toggle Sidebar"
                    class="group relative flex h-11 w-11 items-center justify-center rounded-2xl border border-[#E5E7EB] bg-[#F1F5F9] text-[#1F2937] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#1E4FA3] hover:bg-white hover:text-[#1E4FA3] hover:shadow-md active:translate-y-0 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#1E4FA3]/20">
                <svg class="h-5 w-5 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" x2="20" y1="6" y2="6"/>
                    <line x1="4" x2="20" y1="12" y2="12"/>
                    <line x1="4" x2="20" y1="18" y2="18"/>
                </svg>
            </button>

            {{-- 2. Language / Website Button --}}
            <div class="relative" id="websiteMenuContainer">
                <button type="button" 
                        id="btnWebsiteToggle" 
                        aria-expanded="false" 
                        aria-label="Website & Language Options"
                        title="Website & Language"
                        class="group relative flex h-11 w-11 items-center justify-center rounded-2xl border border-[#E5E7EB] bg-[#F1F5F9] text-[#1F2937] shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-[#1E4FA3] hover:bg-white hover:text-[#1E4FA3] hover:shadow-md active:translate-y-0 active:scale-95 focus:outline-none focus:ring-2 focus:ring-[#1E4FA3]/20">
                    <svg class="h-5 w-5 transition-transform duration-200 group-hover:rotate-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
                        <path d="M2 12h20"/>
                    </svg>
                </button>

                {{-- Language / Website Dropdown Menu --}}
                <div id="websiteDropdown" class="hidden absolute left-0 mt-2.5 w-64 origin-top-left rounded-2xl border border-[#E5E7EB] bg-white p-2.5 shadow-xl shadow-slate-900/10 ring-1 ring-black/5 z-50 transition-all duration-200 animate-in fade-in zoom-in-95">
                    <div class="px-3 py-2 border-b border-[#E5E7EB]">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#1E4FA3]">News Portal</p>
                        <p class="text-xs font-semibold text-[#1F2937] mt-0.5">Ban ko khabar (वनको खबर)</p>
                    </div>
                    
                    <div class="py-1.5 space-y-1">
                        <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-semibold text-[#1F2937] hover:bg-[#EEF4FF] hover:text-[#1E4FA3] transition">
                            <span class="flex items-center gap-2.5">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#1E4FA3]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </span>
                                <span>Visit Live Portal</span>
                            </span>
                            <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-[9px] font-bold text-emerald-700">Live</span>
                        </a>

                        <div class="px-3 py-1.5 text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Language / भाषा</div>
                        
                        <div class="flex items-center justify-between rounded-xl bg-[#EEF4FF] px-3 py-2 text-xs font-semibold text-[#1E4FA3]">
                            <span class="flex items-center gap-2">
                                <span>🇳🇵</span>
                                <span>नेपाली (वि.सं.)</span>
                            </span>
                            <span class="flex h-2 w-2 rounded-full bg-[#22C55E]"></span>
                        </div>

                        <div class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium text-slate-500 hover:bg-slate-50 transition cursor-pointer">
                            <span class="flex items-center gap-2">
                                <span>🌐</span>
                                <span>English (International)</span>
                            </span>
                            <span class="text-[10px] text-slate-400">Default</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= CENTER SECTION (4 PILL CARDS) ================= --}}
        {{-- Desktop Horizontal Flex (Visible on lg and larger screens) --}}
        <div class="hidden flex-1 min-w-0 items-center justify-center gap-2.5 lg:flex xl:gap-3.5">
            
            {{-- 1. Live Clock Card --}}
            <div class="flex items-center gap-2.5 rounded-full border border-[#FCA5A5]/60 bg-white/95 px-3.5 py-2 shadow-sm shadow-red-100/50 backdrop-blur-sm transition-all duration-200 hover:border-[#EF4444] hover:shadow-md hover:shadow-red-100/80">
                <div class="relative flex h-2.5 w-2.5 items-center justify-center">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#EF4444] opacity-75"></span>
                    <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-[#EF4444] shadow-[0_0_8px_rgba(239,68,68,0.8)]"></span>
                </div>
                <div class="flex flex-col text-left">
                    <span class="text-[9px] font-bold uppercase tracking-[0.18em] text-[#EF4444]">Live Clock</span>
                    <span id="navLiveClock" class="font-mono text-xs font-bold tracking-tight text-[#1F2937] xl:text-[13px]">
                        {{ now()->setTimezone('Asia/Kathmandu')->format('h:i:s A') }}
                    </span>
                </div>
            </div>

            {{-- 2. Nepali Patro Card --}}
            <div class="flex items-center gap-2.5 rounded-full border border-[#BBF7D0] bg-[#F0FDF4]/90 px-3.5 py-2 shadow-sm shadow-emerald-100/50 backdrop-blur-sm transition-all duration-200 hover:border-[#22C55E] hover:shadow-md hover:shadow-emerald-100/80">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#DCFCE7] text-[#16A34A] shadow-inner">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                        <line x1="16" x2="16" y1="2" y2="6"/>
                        <line x1="8" x2="8" y1="2" y2="6"/>
                        <line x1="3" x2="21" y1="10" y2="10"/>
                    </svg>
                </div>
                <div class="flex flex-col text-left leading-tight">
                    <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#15803D]">नेपाली पात्रो (वि.सं.)</span>
                    <span id="navNepaliDate" class="text-xs font-bold text-[#166534]">२०८३ असोज ११</span>
                    <span id="navNepaliWeekday" class="text-[10px] font-medium text-[#15803D]">आइतबार</span>
                </div>
            </div>

            {{-- 3. Last Login Card --}}
            <div class="flex items-center gap-2.5 rounded-full border border-[#BFDBFE] bg-[#EEF4FF]/90 px-3.5 py-2 shadow-sm shadow-blue-100/50 backdrop-blur-sm transition-all duration-200 hover:border-[#1E4FA3] hover:shadow-md hover:shadow-blue-100/80">
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#DBEAFE] text-[#1E4FA3] shadow-inner">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                </div>
                <div class="flex flex-col text-left leading-tight">
                    <div class="flex items-center gap-1.5">
                        <span class="text-[9px] font-bold uppercase tracking-[0.16em] text-[#1E4FA3]">Last Login</span>
                        <span class="rounded-full bg-[#1E4FA3] px-1.5 py-0.5 text-[8.5px] font-bold uppercase tracking-wider text-white">Active</span>
                    </div>
                    <span class="text-xs font-semibold text-[#1F2937]">
                        @if(Auth::user()?->last_login_at)
                            {{ Auth::user()->last_login_at->setTimezone('Asia/Kathmandu')->format('M d, Y, h:i A') }}
                        @else
                            {{ now()->setTimezone('Asia/Kathmandu')->format('M d, Y, h:i A') }}
                        @endif
                    </span>
                </div>
            </div>

            {{-- 4. User Greeting Card (with dropdown trigger) --}}
            <div class="relative" id="navUserMenuContainer">
                <button type="button" 
                        id="btnUserGreeting" 
                        aria-expanded="false" 
                        title="User Profile Options"
                        class="group flex items-center gap-2.5 rounded-full border border-[#E5E7EB] bg-white px-3.5 py-2 shadow-sm transition-all duration-200 hover:border-[#1E4FA3] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#1E4FA3]/20">
                    <div class="flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-tr from-[#1E4FA3] to-[#3B82F6] text-xs font-bold text-white shadow-sm ring-1 ring-white">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="text-xs font-semibold text-[#1F2937]">
                        Hi, <span class="font-bold text-[#1E4FA3]">{{ Auth::user()->name ?? 'गण्डकी सम्पादक' }}</span>
                    </div>
                    <svg class="h-3.5 w-3.5 text-slate-400 transition-transform duration-200 group-hover:text-[#1E4FA3]" id="userMenuChevron" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7"/>
                    </svg>
                </button>

                {{-- User Profile Dropdown Card --}}
                <div id="userProfileDropdown" class="hidden absolute right-0 mt-2.5 w-72 origin-top-right rounded-2xl border border-[#E5E7EB] bg-white p-3 shadow-xl shadow-slate-900/10 ring-1 ring-black/5 z-50 transition-all duration-200 animate-in fade-in zoom-in-95">
                    {{-- User Info Header --}}
                    <div class="flex items-center gap-3 rounded-xl bg-[#EEF4FF] p-3 border border-blue-100">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#1E4FA3] text-base font-bold text-white shadow-md">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-sm font-bold text-[#1F2937]">{{ Auth::user()->name ?? 'Admin User' }}</div>
                            <div class="truncate text-[11px] text-slate-500">{{ Auth::user()->email ?? 'admin@vankokhabar.com' }}</div>
                            <div class="mt-1 flex items-center gap-1.5">
                                <span class="inline-flex items-center rounded-full bg-[#1E4FA3] px-2 py-0.5 text-[9px] font-bold uppercase tracking-wider text-white">
                                    {{ Auth::user()->role ?? 'Admin' }}
                                </span>
                                <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-emerald-600">
                                    <span class="h-1.5 w-1.5 rounded-full bg-[#22C55E]"></span> Online
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Action Links --}}
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('admin.settings.password') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#1F2937] transition hover:bg-[#EEF4FF] hover:text-[#1E4FA3]">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                                </svg>
                            </span>
                            <span>Newsroom Settings</span>
                        </a>

                        <a href="{{ route('admin.articles') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#1F2937] transition hover:bg-[#EEF4FF] hover:text-[#1E4FA3]">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v1m2 13a2 2 0 0 1-2-2V7m2 13a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                            </span>
                            <span>Editorial Pipeline</span>
                        </a>

                        <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#1F2937] transition hover:bg-[#EEF4FF] hover:text-[#1E4FA3]">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100 text-slate-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </span>
                            <span>Open Public Website</span>
                        </a>
                    </div>

                    {{-- Divider & Logout Form --}}
                    <div class="mt-2 border-t border-[#E5E7EB] pt-2">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-semibold text-[#EF4444] transition hover:bg-red-50 hover:text-red-700">
                                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-red-100 text-[#EF4444]">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </span>
                                <span>Logout from CMS</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        {{-- Mobile Center Info Bar (Visible on mobile / tablet screens) --}}
        <div class="ml-auto flex items-center gap-2 lg:hidden">
            {{-- Mobile Live Clock Compact Pill --}}
            <div class="flex items-center gap-1.5 rounded-full border border-red-200 bg-white/90 px-2.5 py-1 text-xs shadow-xs">
                <span class="inline-flex h-2 w-2 rounded-full bg-[#EF4444] animate-pulse"></span>
                <span id="navLiveClockMobile" class="font-mono text-[11px] font-bold text-[#1F2937]">{{ now()->setTimezone('Asia/Kathmandu')->format('h:i:s A') }}</span>
            </div>

            {{-- Mobile User Dropdown Trigger --}}
            <button type="button" 
                    id="btnUserGreetingMobile" 
                    aria-label="User Menu"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1E4FA3] text-xs font-bold text-white shadow-sm ring-2 ring-white">
                {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
            </button>
        </div>

        {{-- ================= RIGHT SECTION ================= --}}
        <div class="ml-auto flex shrink-0 items-center gap-2 sm:gap-3 lg:ml-0">
            {{-- 5. Company / Newsroom Logo (Circular Logo Container) --}}
            <a href="{{ route('admin.dashboard') }}" 
               title="Ban ko khabar Newsroom"
               class="group relative flex h-12 w-12 items-center justify-center rounded-full border border-[#E5E7EB] bg-white shadow-sm transition-all duration-300 hover:scale-105 hover:border-[#1E4FA3]/50 hover:shadow-md">
                <img src="{{ asset('image/fev icon.png') }}" 
                     alt="Ban ko khabar logo" 
                     class="h-8 w-8 rounded-full object-cover transition-transform duration-300 group-hover:rotate-6">
                <span class="absolute -bottom-0.5 -right-0.5 h-3.5 w-3.5 rounded-full border-2 border-white bg-[#22C55E]" title="System Status: Live"></span>
            </a>
        </div>

    </div>
</header>

{{-- Real-Time Clock, Bikram Sambat Nepali Date & Dropdown Handlers --}}
<script>
    (function () {
        // Elements
        const liveClock = document.getElementById('navLiveClock');
        const liveClockMobile = document.getElementById('navLiveClockMobile');
        const nepaliDateEl = document.getElementById('navNepaliDate');
        const nepaliWeekdayEl = document.getElementById('navNepaliWeekday');

        // Dropdown triggers & menus
        const btnUserGreeting = document.getElementById('btnUserGreeting');
        const btnUserGreetingMobile = document.getElementById('btnUserGreetingMobile');
        const userProfileDropdown = document.getElementById('userProfileDropdown');
        const userMenuChevron = document.getElementById('userMenuChevron');

        const btnWebsiteToggle = document.getElementById('btnWebsiteToggle');
        const websiteDropdown = document.getElementById('websiteDropdown');

        // Sidebar toggle button
        const adminSidebarToggle = document.getElementById('adminSidebarToggle');

        // 1. REAL-TIME DIGITAL CLOCK (Updates Every Second)
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            if (liveClock) {
                liveClock.textContent = timeString;
            }
            if (liveClockMobile) {
                liveClockMobile.textContent = timeString;
            }
        }

        // 2. NEPALI PATRO (BIKRAM SAMBAT) CALCULATION
        function updateNepaliDate() {
            if (!nepaliDateEl || !nepaliWeekdayEl) return;

            const nepaliMonths = ['बैशाख', 'जेठ', 'असार', 'साउन', 'भदौ', 'असोज', 'कात्तिक', 'मंसिर', 'पुस', 'माघ', 'फागुन', 'चैत'];
            const nepaliDays = ['आइतबार', 'सोमबार', 'मङ्गलबार', 'बुधबार', 'बिहीबार', 'शुक्रबार', 'शनिबार'];
            const toDevanagari = (num) => String(num).replace(/[0-9]/g, d => '०१२३४५६७८९'[d]);

            // Precise Bikram Sambat mapping for contemporary years
            const bsData = {
                2080: { start: new Date('2023-04-14'), days: [31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 29, 31] },
                2081: { start: new Date('2024-04-13'), days: [31, 31, 32, 32, 31, 30, 30, 30, 29, 30, 29, 30] },
                2082: { start: new Date('2025-04-14'), days: [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31] },
                2083: { start: new Date('2026-04-14'), days: [31, 31, 32, 31, 31, 30, 30, 29, 30, 29, 30, 30] },
                2084: { start: new Date('2027-04-14'), days: [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31] },
                2085: { start: new Date('2028-04-13'), days: [31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31] }
            };

            const now = new Date();
            const target = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            let year = 2083;
            for (const y in bsData) {
                const nextY = parseInt(y) + 1;
                const nextStart = bsData[nextY] ? bsData[nextY].start : new Date(bsData[y].start.getTime() + 365 * 86400000);
                if (target >= bsData[y].start && target < nextStart) {
                    year = parseInt(y);
                    break;
                }
            }

            const yearInfo = bsData[year] || bsData[2083];
            let diffDays = Math.floor((target.getTime() - yearInfo.start.getTime()) / (1000 * 60 * 60 * 24));
            let month = 0;
            let day = 1;

            if (diffDays >= 0) {
                for (let m = 0; m < 12; m++) {
                    if (diffDays < yearInfo.days[m]) {
                        month = m;
                        day = diffDays + 1;
                        break;
                    }
                    diffDays -= yearInfo.days[m];
                }
            }

            const weekday = nepaliDays[now.getDay()];
            const formattedDate = toDevanagari(year) + ' ' + nepaliMonths[month] + ' ' + toDevanagari(day);

            nepaliDateEl.textContent = formattedDate;
            nepaliWeekdayEl.textContent = weekday;
        }

        // Initialize Clock & Patro
        updateClock();
        updateNepaliDate();
        setInterval(updateClock, 1000);

        // 3. USER PROFILE DROPDOWN TOGGLE
        function toggleUserDropdown(e) {
            if (e) e.stopPropagation();
            if (!userProfileDropdown) return;
            const isHidden = userProfileDropdown.classList.contains('hidden');
            
            // Close other dropdowns
            if (websiteDropdown) websiteDropdown.classList.add('hidden');
            if (btnWebsiteToggle) btnWebsiteToggle.setAttribute('aria-expanded', 'false');

            if (isHidden) {
                userProfileDropdown.classList.remove('hidden');
                if (btnUserGreeting) btnUserGreeting.setAttribute('aria-expanded', 'true');
                if (userMenuChevron) userMenuChevron.classList.add('rotate-180');
            } else {
                userProfileDropdown.classList.add('hidden');
                if (btnUserGreeting) btnUserGreeting.setAttribute('aria-expanded', 'false');
                if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
            }
        }

        if (btnUserGreeting) {
            btnUserGreeting.addEventListener('click', toggleUserDropdown);
        }
        if (btnUserGreetingMobile) {
            btnUserGreetingMobile.addEventListener('click', toggleUserDropdown);
        }

        // 4. WEBSITE / LANGUAGE DROPDOWN TOGGLE
        if (btnWebsiteToggle && websiteDropdown) {
            btnWebsiteToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = websiteDropdown.classList.contains('hidden');
                
                // Close user profile dropdown
                if (userProfileDropdown) userProfileDropdown.classList.add('hidden');
                if (btnUserGreeting) btnUserGreeting.setAttribute('aria-expanded', 'false');
                if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');

                if (isHidden) {
                    websiteDropdown.classList.remove('hidden');
                    btnWebsiteToggle.setAttribute('aria-expanded', 'true');
                } else {
                    websiteDropdown.classList.add('hidden');
                    btnWebsiteToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }

        // 5. CLICK OUTSIDE & ESCAPE KEY HANDLERS
        document.addEventListener('click', (e) => {
            if (userProfileDropdown && !userProfileDropdown.contains(e.target) && (!btnUserGreeting || !btnUserGreeting.contains(e.target)) && (!btnUserGreetingMobile || !btnUserGreetingMobile.contains(e.target))) {
                userProfileDropdown.classList.add('hidden');
                if (btnUserGreeting) btnUserGreeting.setAttribute('aria-expanded', 'false');
                if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
            }

            if (websiteDropdown && !websiteDropdown.contains(e.target) && (!btnWebsiteToggle || !btnWebsiteToggle.contains(e.target))) {
                websiteDropdown.classList.add('hidden');
                if (btnWebsiteToggle) btnWebsiteToggle.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (userProfileDropdown) {
                    userProfileDropdown.classList.add('hidden');
                    if (btnUserGreeting) btnUserGreeting.setAttribute('aria-expanded', 'false');
                    if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
                }
                if (websiteDropdown) {
                    websiteDropdown.classList.add('hidden');
                    if (btnWebsiteToggle) btnWebsiteToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });

        // 6. SIDEBAR TOGGLE FUNCTIONALITY
        if (adminSidebarToggle) {
            adminSidebarToggle.addEventListener('click', (e) => {
                e.preventDefault();
                const sidebar = document.getElementById('adminSidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                
                if (!sidebar) return;

                // Check if screen is mobile (< 1024px)
                const isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    // Mobile slide-over drawer toggle
                    const isOpen = !sidebar.classList.contains('-translate-x-full');
                    if (isOpen) {
                        sidebar.classList.add('-translate-x-full');
                        if (backdrop) backdrop.classList.add('hidden');
                    } else {
                        sidebar.classList.remove('-translate-x-full');
                        if (backdrop) backdrop.classList.remove('hidden');
                    }
                } else {
                    // Desktop sidebar collapse / expand toggle
                    sidebar.classList.toggle('w-[224px]');
                    sidebar.classList.toggle('w-[82px]');
                    sidebar.classList.toggle('is-collapsed');
                    
                    // Dispatch custom event for listeners
                    window.dispatchEvent(new CustomEvent('sidebar-toggle', {
                        detail: { collapsed: sidebar.classList.contains('is-collapsed') }
                    }));
                }
            });
        }
    })();
</script>
