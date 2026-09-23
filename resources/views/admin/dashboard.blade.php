@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body { background: #f5f8f3; }
        header, footer { display: none !important; }
    </style>
    <section class="mx-auto max-w-[1600px] px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="rounded-[32px] bg-[#173B27] p-5 text-white shadow-[0_24px_60px_rgba(17,44,24,0.18)]">
                <div class="flex items-center gap-3 border-b border-white/10 pb-5">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10">
                        <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-8 w-8 rounded-xl object-cover">
                    </div>
                    <div>
                        <div class="font-display text-xl font-bold">वनको खबर</div>
                        <div class="text-[10px] uppercase tracking-[0.25em] text-[#bdd7c1]">Admin panel</div>
                    </div>
                </div>

                <nav class="mt-7 space-y-2">
                    <a href="#overview" class="flex items-center justify-between rounded-2xl bg-white/10 px-4 py-3 text-sm font-medium text-white">
                        <span class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#98D28E]"></span>
                            Dashboard
                        </span>
                        <span class="rounded-full bg-[#98D28E] px-2 py-1 text-[10px] font-bold text-[#173B27]">Live</span>
                    </a>
                    <a href="#news" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">News</a>
                    <a href="#categories" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Categories</a>
                    <a href="#gallery" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Gallery</a>
                    <a href="#users" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Users</a>
                    <a href="#reports" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Reports</a>
                    <a href="#settings" class="flex items-center rounded-2xl px-4 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Settings</a>
                </nav>

                <div class="mt-8 rounded-[24px] border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.2em] text-[#bdd7c1]">Quick note</p>
                    <p class="mt-3 text-sm leading-6 text-[#eef7ee]">Your latest climate coverage is performing better than the weekly average.</p>
                    <button type="button" class="mt-4 w-full rounded-full bg-[#98D28E] px-4 py-2.5 text-sm font-semibold text-[#173B27] hover:bg-[#b2e0a8]">Publish report</button>
                </div>
            </aside>

            <div class="space-y-6">
                <header class="overflow-hidden rounded-[32px] bg-gradient-to-r from-[#1B5E20] via-[#2E7D32] to-[#7CB342] p-6 text-white shadow-[0_24px_60px_rgba(33,108,54,0.18)] sm:p-8">
                    <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#dfeee0]">Welcome back</p>
                            <h1 class="mt-3 font-display text-3xl font-bold sm:text-4xl">Newsroom dashboard</h1>
                            <p class="mt-3 max-w-xl text-sm text-[#edf7ee] sm:text-base">Track stories, audience growth, and environmental coverage across Nepal’s forests and climate landscape.</p>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <button type="button" class="rounded-full bg-white px-5 py-3 text-sm font-semibold text-[#173B27] shadow-lg shadow-[#173B27]/10 transition hover:bg-[#f3f8f1]">+ Add post</button>
                            <form action="{{ route('admin.logout') }}" method="POST" class="inline-flex">
                                @csrf
                                <button type="submit" class="rounded-full border border-white/40 bg-white/10 px-5 py-3 text-sm font-semibold text-white backdrop-blur-sm transition hover:bg-white/15">Logout</button>
                            </form>
                        </div>
                    </div>
                </header>

                <div id="overview" class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
                    <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Total News</div>
                        <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $newsCount }}</div>
                    </div>
                    <div id="users" class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Users</div>
                        <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $userCount }}</div>
                    </div>
                    <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Comments</div>
                        <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $commentCount }}</div>
                    </div>
                    <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Views</div>
                        <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $viewCount }}</div>
                    </div>
                    <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Subscribers</div>
                        <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $subscriberCount }}</div>
                    </div>
                </div>

                <div id="news" class="grid gap-6 lg:grid-cols-2">
                    <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Monthly News Analytics</h2>
                        <div class="mt-6 flex h-52 items-end gap-2">
                            @foreach($monthlyNews as $count)
                                <div class="flex-1 rounded-t-2xl bg-gradient-to-t from-[#1B5E20] to-[#81C784]" style="height: {{ $count * 1.5 }}px"></div>
                            @endforeach
                        </div>
                    </div>

                    <div id="reports" class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Recent reports</h2>
                        <div class="mt-6 space-y-4">
                            <div class="rounded-2xl border border-[#e1ebdf] bg-[#f4faf3] p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-[#1B5E20]">Forest reserve audit</span>
                                    <span class="rounded-full bg-[#dff3db] px-2 py-1 text-[10px] font-bold text-[#1B5E20]">+18%</span>
                                </div>
                                <p class="mt-2 text-sm text-[#4e5b51]">Engagement rose after a multi-region wildlife feature.</p>
                            </div>
                            <div class="rounded-2xl border border-[#e1ebdf] bg-[#f4faf3] p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="font-semibold text-[#1B5E20]">Climate briefing</span>
                                    <span class="rounded-full bg-[#dff3db] px-2 py-1 text-[10px] font-bold text-[#1B5E20]">+12%</span>
                                </div>
                                <p class="mt-2 text-sm text-[#4e5b51]">Reader response improved after the new rainfall updates.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="categories" class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Category Statistics</h2>
                    <div class="mt-8 space-y-4">
                        @foreach($categoryStats as $stat)
                            <div>
                                <div class="mb-2 flex justify-between text-sm text-[#4f5c4f] dark:text-[#dce8dd]">
                                    <span>{{ $stat['label'] }}</span>
                                    <span>{{ $stat['value'] }}%</span>
                                </div>
                                <div class="h-2.5 rounded-full bg-[#edf6ee] dark:bg-[#20332d]">
                                    <div class="h-2.5 rounded-full bg-[#2E7D32]" style="width: {{ $stat['value'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div id="gallery" class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="flex h-40 items-center justify-center rounded-[24px] bg-gradient-to-br from-[#dff3db] to-[#d8f0d0] text-5xl">🌲</div>
                        <h3 class="mt-4 font-display text-xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Forest cover</h3>
                        <p class="mt-2 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">Latest field notes and visual updates from protected areas.</p>
                    </div>
                    <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="flex h-40 items-center justify-center rounded-[24px] bg-gradient-to-br from-[#eaf7ea] to-[#edf7ee] text-5xl">🐘</div>
                        <h3 class="mt-4 font-display text-xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Wildlife</h3>
                        <p class="mt-2 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">Conservation stories and shifting habitat patterns.</p>
                    </div>
                    <div id="settings" class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <div class="flex h-40 items-center justify-center rounded-[24px] bg-gradient-to-br from-[#edf7ee] to-[#e6f3e8] text-5xl">⚙️</div>
                        <h3 class="mt-4 font-display text-xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Settings</h3>
                        <p class="mt-2 text-sm text-[#4e5b51] dark:text-[#d3e3d5]">Theme, publishing defaults, and notification preferences.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
