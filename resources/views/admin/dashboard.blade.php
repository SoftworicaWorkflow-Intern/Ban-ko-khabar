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
        #adminSidebar.is-collapsed .sidebar-footer-widget,
        #adminSidebar.is-collapsed .sidebar-settings-submenu {
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
                            <h2 class="text-[32px] font-bold leading-none">Welcome, {{ $userName }}</h2>
                            <p class="mt-3 text-sm text-[#edf7ee]">Newsroom totals calculated from published content and registered accounts</p>

                            <div class="mt-6 flex flex-wrap gap-8">
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold">{{ $publishedToday }}</span>
                                    <div>
                                        <div class="text-2xl font-black leading-none">{{ number_format($publishedToday) }}</div>
                                        <div class="text-xs text-[#edf7ee]">Published today</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/15 text-xs font-bold">{{ $categoryCount }}</span>
                                    <div>
                                        <div class="text-2xl font-black leading-none">{{ number_format($categoryCount) }}</div>
                                        <div class="text-xs text-[#edf7ee]">News categories</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="min-w-[220px] text-left xl:text-right">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#edf7ee]">Today's story views</div>
                            <div class="mt-2 text-5xl font-black leading-none">{{ number_format($todayViews) }}</div>
                            <div class="mt-2 text-sm text-[#edf7ee]">Views recorded on stories published today</div>
                            <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#2f7d4d] px-3 py-1.5 text-xs font-semibold text-white">
                                <span>↗</span>
                                {{ number_format($newsCount) }} stories in the database
                            </div>
                        </div>
                    </div>
                </div>

                <div id="overview" class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Total story views</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fee2e2] text-xl text-[#ef4444]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">{{ number_format($viewCount) }}</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#ef4444]">
                            <span>{{ number_format($newsCount) }}</span>
                            <span>articles recorded</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Published today</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#dcfce7] text-xl text-[#16a34a]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">{{ number_format($publishedToday) }}</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#16a34a]">
                            <span>{{ number_format($publishedCount) }}</span>
                            <span>published articles total</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Registered users</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f3e8ff] text-xl text-[#8b5cf6]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">{{ number_format($userCount) }}</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#8b5cf6]">
                            <span>{{ number_format($userCount) }}</span>
                            <span>registered accounts</span>
                        </div>
                    </div>

                    <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">Total articles</div>
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fef3c7] text-xl text-[#f59e0b]">◔</div>
                        </div>
                        <div class="mt-4 text-4xl font-black text-[#0f2b54]">{{ number_format($newsCount) }}</div>
                        <div class="mt-3 flex items-center gap-2 text-xs font-semibold text-[#f59e0b]">
                            <span>{{ number_format($categoryCount) }}</span>
                            <span>editorial categories</span>
                        </div>
                    </div>
                </div>

                @php
                    $maxMonthlyViews = max(1, max(array_column($monthlyNews, 'views')));
                @endphp
                <div class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
                    <section class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]" aria-labelledby="publishing-chart-title">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div>
                                <h2 id="publishing-chart-title" class="text-base font-bold text-[#1b2433]">Monthly publishing</h2>
                                <p class="mt-1 text-xs text-[#51657c]">Articles created over the last 12 months</p>
                            </div>
                            <span class="rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold text-[#173b27]">{{ number_format($newsCount) }} total</span>
                        </div>
                        <div class="mt-6 flex h-48 items-end gap-2 border-b border-slate-200 px-1 sm:gap-3">
                            @foreach ($monthlyNews as $month)
                                @php $barHeight = (int) round($month['articles'] / $maxMonthlyNews * 100); @endphp
                                <div class="flex h-full min-w-0 flex-1 flex-col items-center justify-end gap-2" title="{{ $month['label'] }}: {{ $month['articles'] }} articles, {{ number_format($month['views']) }} views">
                                    <span class="text-[10px] font-semibold tabular-nums text-slate-500">{{ $month['articles'] }}</span>
                                    <div class="w-full max-w-8 rounded-t-md bg-[#2f7d4d] transition-colors hover:bg-[#173b27]" style="height: {{ $barHeight }}%"></div>
                                    <span class="text-[10px] text-slate-500">{{ $month['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]" aria-labelledby="category-chart-title">
                        <div>
                            <h2 id="category-chart-title" class="text-base font-bold text-[#1b2433]">Category performance</h2>
                            <p class="mt-1 text-xs text-[#51657c]">Published stories and recorded views</p>
                        </div>
                        <div class="mt-6 space-y-5">
                            @forelse ($categoryStats as $category)
                                <div>
                                    <div class="mb-2 flex items-center justify-between gap-3 text-xs">
                                        <span class="truncate font-semibold text-slate-700">{{ $category->name }}</span>
                                        <span class="shrink-0 tabular-nums text-slate-500">{{ number_format((int) $category->total_views) }} views</span>
                                    </div>
                                    <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                        <div class="h-full rounded-full bg-[#2f7d4d]" style="width: {{ min(100, (int) round($category->total_views / $maxCategoryViews * 100)) }}%"></div>
                                    </div>
                                    <div class="mt-1 text-[10px] text-slate-400">{{ number_format($category->published_count) }} published articles</div>
                                </div>
                            @empty
                                <div class="rounded-xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-500">No categories to chart yet.</div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </main>
            </div>{{-- end flex-col wrapper --}}
        </div>
    </section>
@endsection
