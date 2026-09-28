{{-- Admin Top Utility Banner --}}
<div id="adminTopBanner" class="flex w-full shrink-0 items-center border-b border-slate-200 bg-[#F8FAFC] px-4 sm:px-6 lg:px-8" style="height:52px;">

    {{-- LEFT: Hamburger + Portal label --}}
    <div class="flex items-center gap-3 mr-auto">
        {{-- Hamburger sidebar toggle --}}
        <button type="button"
                id="topBannerSidebarToggle"
                aria-label="Toggle sidebar"
                title="Toggle Sidebar"
                class="group flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-[#1E4FA3] hover:bg-[#EEF4FF] hover:text-[#1E4FA3]">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                <line x1="4" x2="20" y1="6"  y2="6"/>
                <line x1="4" x2="20" y1="12" y2="12"/>
                <line x1="4" x2="20" y1="18" y2="18"/>
            </svg>
        </button>

        {{-- Divider --}}
        <span class="h-4 w-px bg-slate-200"></span>

        {{-- Portal name --}}
        <span class="hidden text-[12px] font-bold uppercase tracking-[0.2em] text-[#16A34A] sm:inline">वनको खबर</span>
    </div>

    {{-- RIGHT items --}}
    <div class="ml-auto flex items-center">

    {{-- System Time --}}
    <div class="flex items-center gap-1.5 border-l border-slate-200 px-3 sm:px-4">
        <svg class="h-3 w-3 shrink-0 text-[#1E4FA3]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"/>
            <path stroke-linecap="round" d="M12 6v6l4 2"/>
        </svg>
        <span id="topBannerClock" class="font-mono text-[13px] font-semibold tabular-nums text-slate-700">
            {{ now()->setTimezone('Asia/Kathmandu')->format('h:i:s A') }}
        </span>
    </div>

    {{-- Last Login --}}
    <div class="flex items-center gap-1.5 border-l border-slate-200 px-3 sm:px-4">
        <svg class="h-3 w-3 shrink-0 text-[#22C55E]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/>
        </svg>
        <span class="hidden text-[12px] font-medium text-slate-400 sm:inline">Last&nbsp;login:</span>
        <span class="text-[13px] font-semibold text-slate-600">
            @if(Auth::user()?->last_login_at)
                {{ Auth::user()->last_login_at->setTimezone('Asia/Kathmandu')->format('M d, h:i A') }}
            @else
                {{ now()->setTimezone('Asia/Kathmandu')->format('M d, h:i A') }}
            @endif
        </span>
    </div>

    {{-- Fullscreen Toggle --}}
    <button type="button"
            id="topBannerFullscreen"
            title="Toggle Fullscreen"
            aria-label="Toggle fullscreen mode"
            class="flex h-full items-center px-3 text-slate-400 transition hover:text-[#1E4FA3] border-l border-slate-200 sm:px-4">
        <svg id="iconExpand" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
        </svg>
        <svg id="iconCompress" class="hidden h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v3a2 2 0 0 1-2 2H3m18 0h-3a2 2 0 0 1-2-2V3m0 18v-3a2 2 0 0 1 2-2h3M3 16h3a2 2 0 0 1 2 2v3"/>
        </svg>
    </button>

    {{-- Logged-in User --}}
    <div class="flex flex-col items-center justify-center gap-0.5 border-l border-slate-200 px-3 sm:px-4">
        <img src="{{ asset('image/logo.png') }}" alt="Admin avatar" class="h-5 w-5 rounded-full object-cover ring-1 ring-slate-200 shadow-sm">
        <span class="block max-w-[110px] truncate text-[12px] font-semibold leading-none text-slate-700">
            KB Bhurtel
        </span>
    </div>
    </div>
</div>

<script>
    (function () {
        // Live clock
        const topClock = document.getElementById('topBannerClock');
        function tickTopClock() {
            if (!topClock) return;
            topClock.textContent = new Date().toLocaleTimeString('en-US', {
                hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true
            });
        }
        setInterval(tickTopClock, 1000);

        // Fullscreen toggle
        const btnFs       = document.getElementById('topBannerFullscreen');
        const iconExpand   = document.getElementById('iconExpand');
        const iconCompress = document.getElementById('iconCompress');

        function syncFsIcons() {
            const isFs = !!document.fullscreenElement;
            if (iconExpand)   iconExpand.classList.toggle('hidden', isFs);
            if (iconCompress) iconCompress.classList.toggle('hidden', !isFs);
        }

        if (btnFs) {
            btnFs.addEventListener('click', () => {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(() => {});
                } else {
                    document.exitFullscreen().catch(() => {});
                }
            });
        }
        document.addEventListener('fullscreenchange', syncFsIcons);
        syncFsIcons();

        // Hamburger in top banner — reuses same sidebar toggle logic
        const topToggle = document.getElementById('topBannerSidebarToggle');
        if (topToggle) {
            topToggle.addEventListener('click', () => {
                const sidebar  = document.getElementById('adminSidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                if (!sidebar) return;

                const isMobile = window.innerWidth < 1024;
                if (isMobile) {
                    const isOpen = !sidebar.classList.contains('-translate-x-full');
                    sidebar.classList.toggle('-translate-x-full', isOpen);
                    if (backdrop) backdrop.classList.toggle('hidden', isOpen);
                } else {
                    sidebar.classList.toggle('w-[260px]');
                    sidebar.classList.toggle('w-[82px]');
                    sidebar.classList.toggle('is-collapsed');
                    window.dispatchEvent(new CustomEvent('sidebar-toggle', {
                        detail: { collapsed: sidebar.classList.contains('is-collapsed') }
                    }));
                }
            });
        }
    })();
</script>
