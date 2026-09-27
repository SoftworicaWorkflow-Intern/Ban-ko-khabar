@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body { background: #edf3f7; }
        header, footer { display: none !important; }
        .dashboard-shell { min-height: 100vh; }
        .sidebar-item.active {
            background: rgba(255,255,255,0.12);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
        }
        .stat-card {
            border: 1px solid rgba(15, 40, 77, 0.06);
        }
    </style>

    <section class="dashboard-shell mx-auto max-w-[1600px] px-3 py-4 sm:px-5 lg:px-6">
        <div class="flex overflow-hidden rounded-[26px] bg-[#edf4f8] shadow-[0_28px_80px_rgba(11,30,52,0.14)] ring-1 ring-[#dfeaf2]">
            <aside class="w-[250px] bg-[#173b27] p-4 text-white">
                <div class="flex items-center gap-3 border-b border-white/10 pb-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10">
                        <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-8 w-8 rounded-xl object-cover">
                    </div>
                    <div>
                        <div class="text-xl font-bold leading-none">गण्डकी आज</div>
                        <div class="mt-1 text-[10px] uppercase tracking-[0.26em] text-[#dfeee0]">Newsroom</div>
                    </div>
                </div>

                <nav class="mt-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center justify-between rounded-2xl px-3 py-3 text-sm font-medium text-white">
                        <span class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#98d28e]"></span>
                            Dashboard
                        </span>
                        <span class="rounded-full bg-[#98d28e] px-2 py-1 text-[10px] font-bold text-[#173b27]">Live</span>
                    </a>
                    <a href="{{ route('admin.articles') }}" class="sidebar-item {{ request()->routeIs('admin.articles') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Articles</a>
                    <a href="{{ route('admin.categories') }}" class="sidebar-item {{ request()->routeIs('admin.categories') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Categories</a>
                    <a href="{{ route('admin.gallery') }}" class="sidebar-item {{ request()->routeIs('admin.gallery') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Gallery</a>
                    <a href="{{ route('admin.users') }}" class="sidebar-item {{ request()->routeIs('admin.users') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Users</a>
                    <a href="{{ route('admin.reports') }}" class="sidebar-item {{ request()->routeIs('admin.reports') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Reports</a>
                    <a href="{{ route('admin.settings') }}" class="sidebar-item {{ request()->routeIs('admin.settings') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Settings</a>
                </nav>

                <div class="mt-8 rounded-[20px] bg-white/5 p-4 ring-1 ring-white/10">
                    <p class="text-[10px] uppercase tracking-[0.26em] text-[#dfeee0]">Quick note</p>
                    <p class="mt-3 text-sm leading-6 text-[#edf7ee]">Your latest climate coverage is performing better than the weekly average.</p>
                    <button type="button" class="mt-4 w-full rounded-full bg-[#98d28e] px-4 py-2.5 text-sm font-semibold text-[#173b27] shadow-sm transition hover:bg-[#b2e0a8]">Publish report</button>
                </div>
            </aside>

            <main class="flex-1 bg-[#f3f7fb] p-5 sm:p-6">
                <header class="mb-6 flex flex-wrap items-center justify-between gap-4 rounded-[18px] border border-[#dfe8f0] bg-[#f7f9fc] px-4 py-3 shadow-sm">
                    <div class="flex items-center gap-3">
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe5ee] bg-white text-lg text-[#1b2a3d] shadow-sm">☰</button>
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe5ee] bg-white text-lg text-[#1b2a3d] shadow-sm">◫</button>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#0f2b54] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            Live clock
                            <strong class="ml-1 text-[#0f2b54]">12:13:12</strong>
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-medium text-[#3b4a5f] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            वैशाख २९, २०८१
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-medium text-[#3b4a5f] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            Last login
                        </div>
                        <div class="flex items-center gap-3 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 shadow-sm">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#fbbf24] text-sm font-bold text-[#0f2b54]">H</div>
                            <div class="text-sm font-semibold text-[#1c2438]">हरि</div>
                        </div>
                    </div>
                </header>

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
        </div>
    </section>
@endsection
