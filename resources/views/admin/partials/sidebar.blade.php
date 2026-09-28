{{-- Modern Newsroom Admin Dashboard Sidebar Partial --}}
{{-- Mobile Backdrop Overlay --}}
<div id="sidebarBackdrop" class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-xs transition-opacity lg:hidden" onclick="closeAdminSidebar()"></div>

{{-- Sidebar Container --}}
<aside id="adminSidebar" 
       class="fixed inset-y-0 left-0 z-50 flex w-[260px] -translate-x-full flex-col justify-between bg-[#173B27] p-4 text-white shadow-2xl transition-all duration-300 ease-in-out lg:relative lg:inset-auto lg:z-auto lg:translate-x-0 lg:shadow-none shrink-0 overflow-y-auto">
    
    <div>
        {{-- Brand / Header --}}
        <div class="flex items-center justify-between border-b border-white/10 pb-4">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/15 shadow-sm">
                    <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-8 w-8 rounded-xl object-cover">
                </div>
                <div class="sidebar-brand-text min-w-0 transition-opacity duration-200">
                    <div class="truncate text-lg font-bold leading-tight text-white">वनको खबर</div>
                    <div class="text-[10px] font-semibold uppercase tracking-[0.24em] text-[#98D28E]">Newsroom CMS</div>
                </div>
            </a>

            {{-- Mobile Close Button --}}
            <button type="button" 
                    onclick="closeAdminSidebar()" 
                    aria-label="Close sidebar"
                    class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 text-white/80 hover:bg-white/20 hover:text-white lg:hidden">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation Links --}}
        <nav class="mt-6 space-y-1.5">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" 
               class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1"/>
                            <rect width="7" height="5" x="14" y="3" rx="1"/>
                            <rect width="7" height="9" x="14" y="12" rx="1"/>
                            <rect width="7" height="5" x="3" y="16" rx="1"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Dashboard</span>
                </span>
                <span class="rounded-full bg-[#98D28E] px-2 py-0.5 text-[9px] font-bold text-[#173B27]">Live</span>
            </a>

            {{-- Articles --}}
            <a href="{{ route('admin.articles') }}" 
               class="sidebar-item {{ request()->routeIs('admin.articles') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
                            <path d="M18 14h-8"/>
                            <path d="M15 18h-5"/>
                            <path d="M10 6h8v4h-8V6Z"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Articles</span>
                </span>
            </a>

            {{-- Categories --}}
            <a href="{{ route('admin.categories') }}" 
               class="sidebar-item {{ request()->routeIs('admin.categories') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Categories</span>
                </span>
            </a>

            {{-- Gallery --}}
            <a href="{{ route('admin.gallery') }}" 
               class="sidebar-item {{ request()->routeIs('admin.gallery') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                            <circle cx="9" cy="9" r="2"/>
                            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Gallery</span>
                </span>
            </a>

            {{-- Users --}}
            <a href="{{ route('admin.users') }}" 
               class="sidebar-item {{ request()->routeIs('admin.users') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Users</span>
                </span>
            </a>

            {{-- Reports --}}
            <a href="{{ route('admin.reports') }}" 
               class="sidebar-item {{ request()->routeIs('admin.reports') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18"/>
                            <path d="m19 9-5 5-4-4-3 3"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Reports</span>
                </span>
            </a>

            {{-- Settings --}}
            <a href="{{ route('admin.settings') }}" 
               class="sidebar-item {{ request()->routeIs('admin.settings') ? 'active bg-white/15 text-white shadow-sm ring-1 ring-white/20' : 'text-[#DFEEE0] hover:bg-white/5 hover:text-white' }} group flex items-center justify-between rounded-2xl px-3.5 py-3 text-sm font-medium transition-all duration-150">
                <span class="flex items-center gap-3">
                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-white/10 text-[#98D28E] transition-colors group-hover:bg-[#98D28E] group-hover:text-[#173B27]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Settings</span>
                </span>
            </a>
        </nav>
    </div>
</aside>

<script>
    function closeAdminSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (sidebar) sidebar.classList.add('-translate-x-full');
        if (backdrop) backdrop.classList.add('hidden');
    }
</script>
