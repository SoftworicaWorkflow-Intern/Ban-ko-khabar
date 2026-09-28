@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body { background: #edf3f7; }
        header, footer { display: none !important; }
        .dashboard-shell { height: 100vh; width: 100%; overflow: hidden; }
        .sidebar-item.active {
            background: rgba(255,255,255,0.14);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.12);
        }
        #adminSidebar.is-collapsed {
            width: 82px;
        }
        #adminSidebar.is-collapsed .sidebar-label,
        #adminSidebar.is-collapsed .sidebar-brand-text,
        #adminSidebar.is-collapsed .sidebar-footer-widget {
            display: none;
        }
        #adminSidebar.is-collapsed .sidebar-item {
            justify-content: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .stat-card {
            border: 1px solid rgba(15, 40, 77, 0.06);
        }
    </style>

    <section class="dashboard-shell w-full">
        <div class="relative flex h-full overflow-hidden bg-[#edf4f8] shadow-[0_28px_80px_rgba(11,30,52,0.14)] ring-1 ring-[#dfeaf2]">
            @include('admin.partials.sidebar')

            <div class="flex min-h-0 min-w-0 flex-1 flex-col">
                @include('admin.partials.topbanner')

                <main class="min-h-0 flex-1 overflow-y-auto bg-[#f3f7fb] p-4 sm:p-6 lg:p-8 transition-all duration-300">
                    @include('admin.partials.navbar')

                <div class="mb-6">
                    <h1 class="text-4xl font-black tracking-tight text-[#1b2433]">Newsroom Dashboard</h1>
                </div>

                <div class="rounded-[22px] bg-gradient-to-r from-[#173b27] via-[#1f5d3a] to-[#2f7d4d] p-5 text-white shadow-[0_18px_40px_rgba(23,59,39,0.28)]">
                    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
                        <div>
                            <h2 class="text-[32px] font-bold leading-none">Good Morning, गण्डकी</h2>
                            <p class="mt-3 text-sm text-[#edf7ee]">Live counts from this database — articles, views, and newsroom activity</p>

                            <div class="mt-6 flex flex-wrap gap-8">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold">2</span>
                                    <div>
                                        <div class="text-2xl font-black leading-none">2</div>
                                        <div class="text-xs text-[#edf7ee]">Published today</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold">12</span>
                                    <div>
                                        <div class="text-2xl font-black leading-none">12</div>
                                        <div class="text-xs text-[#edf7ee]">Breaking now</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="min-w-[220px] text-left xl:text-right">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#edf7ee]">Views on today's stories</div>
                            <div class="mt-2 text-5xl font-black leading-none">162</div>
                            <div class="mt-2 text-sm text-[#edf7ee]">Sum of views on articles published today</div>
                            <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#2f7d4d] px-3 py-1.5 text-xs font-semibold text-white">
                                <span>↗</span>
                                New this month vs last
                            </div>
                        </div>
                    </div>
                </div>

                <div id="overview" class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Total views</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fee2e2] text-xl text-[#ef4444]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">1.84M</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#ef4444]">
                            <span>↘</span>
                            <span>New articles this month vs last</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Published today</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#dcfce7] text-xl text-[#16a34a]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">2</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#16a34a]">
                            <span>↗</span>
                            <span>+100% vs yesterday</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Articles with views</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3e8ff] text-xl text-[#8b5cf6]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">100%</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#8b5cf6]">
                            <span>↗</span>
                            <span>8 reactions of published stories</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Active ads</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fef3c7] text-xl text-[#f59e0b]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">2</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#f59e0b]">
                            <span>•</span>
                            <span>2 total from advertisements</span>
                        </div>
                    </div>
                </div>

                <div id="news" class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                    <div class="flex items-center justify-between">
                        <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Cloudflare page visits</div>
                        <div class="rounded-full bg-[#eef5ff] px-3 py-1 text-xs font-semibold text-[#0f2b54]">Ban ko khabar</div>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-4">
                        <div class="text-center">
                            <div class="text-[11px] uppercase tracking-[0.16em] text-[#51657c]">Today</div>
                            <div class="mt-2 text-4xl font-black text-[#0f2b54]">0</div>
                            <div class="mt-2 text-xs text-[#6b7280]">page views</div>
                        </div>
                        <div class="text-center">
                            <div class="text-[11px] uppercase tracking-[0.16em] text-[#51657c]">14 days</div>
                            <div class="mt-2 text-4xl font-black text-[#0f2b54]">0</div>
                            <div class="mt-2 text-xs text-[#6b7280]">page views</div>
                        </div>
                        <div class="text-center">
                            <div class="text-[11px] uppercase tracking-[0.16em] text-[#51657c]">Unique (14 days)</div>
                            <div class="mt-2 text-4xl font-black text-[#0f2b54]">0</div>
                            <div class="mt-2 text-xs text-[#6b7280]">visitors</div>
                        </div>
                        <div class="text-center">
                            <div class="text-[11px] uppercase tracking-[0.16em] text-[#51657c]">Requests (14 days)</div>
                            <div class="mt-2 text-4xl font-black text-[#0f2b54]">0</div>
                            <div class="mt-2 text-xs text-[#6b7280]">HTTP hits</div>
                        </div>
                    </div>
                </div>
            </main>
            </div>{{-- end flex-col wrapper --}}
        </div>
    </section>
@endsection
