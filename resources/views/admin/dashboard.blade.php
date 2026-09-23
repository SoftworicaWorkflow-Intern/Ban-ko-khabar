@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Admin</p>
                <h1 class="mt-2 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Dashboard</h1>
            </div>
            <button class="rounded-full bg-[#2E7D32] px-5 py-3 text-sm font-semibold text-white hover:bg-[#1B5E20]">+ Add News</button>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <div class="text-sm text-[#5e6f61] dark:text-[#bfd3c3]">Total News</div>
                <div class="mt-4 text-3xl font-black text-[#1B5E20] dark:text-[#edf5ee]">{{ $newsCount }}</div>
            </div>
            <div class="rounded-[24px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
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

        <div class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Monthly News Analytics</h2>
                <div class="mt-6 flex h-52 items-end gap-2">
                    @foreach($monthlyNews as $count)
                        <div class="flex-1 rounded-t-2xl bg-gradient-to-t from-[#1B5E20] to-[#81C784]" style="height: {{ $count * 1.5 }}px"></div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
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
        </div>
    </section>
@endsection
