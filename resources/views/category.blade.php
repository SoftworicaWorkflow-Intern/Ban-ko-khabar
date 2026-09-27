@extends('layouts.app')

@section('title', $category['title'] . ' | वनको खबर')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-[30px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] dark:bg-[#17242b]">
            <div class="relative">
                <img src="{{ $category['hero'] }}" alt="{{ $category['title'] }}" class="h-72 w-full object-cover sm:h-96">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0d1f11]/80 via-[#102f18]/60 to-[#1b5e20]/20"></div>
                <div class="absolute inset-0 flex items-end p-6 sm:p-10">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#dfeee2]">Category</p>
                        <h1 class="mt-3 font-display text-3xl font-black text-white sm:text-5xl">{{ $category['title'] }}</h1>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10">
                <p class="max-w-3xl text-sm leading-8 text-[#4f5c4f] dark:text-[#dce8dd]">
                    {{ $category['description'] }}
                </p>
            </div>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($articles as $article)
                <article class="group overflow-hidden rounded-[26px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] transition duration-300 hover:-translate-y-2 hover:shadow-[0_26px_55px_rgba(19,41,26,0.12)] dark:bg-[#17242b]">
                    <div class="relative overflow-hidden">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#2E7D32]">{{ $article['category'] }}</span>
                    </div>
                    <div class="p-5">
                        <div class="mb-3 flex items-center justify-between text-[11px] text-[#6a7c6c] dark:text-[#bfd3c3]">
                            <span>{{ $article['date'] }}</span>
                            <span>{{ $article['author'] }}</span>
                        </div>
                        <a href="{{ route('news.show', $article['slug']) }}" class="font-display text-xl font-bold leading-relaxed text-[#1d2a1d] transition hover:text-[#2E7D32] dark:text-[#edf5ee]">
                            {{ $article['title'] }}
                        </a>
                        <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">{{ $article['excerpt'] }}</p>
                        <div class="mt-5 flex items-center justify-between">
                            <span class="text-xs text-[#6a7c6c] dark:text-[#bfd3c3]">{{ $article['reading_time'] }}</span>
                            <a href="{{ route('news.show', $article['slug']) }}" class="inline-flex items-center gap-2 rounded-full bg-[#edf6ee] px-4 py-2 text-xs font-semibold text-[#2E7D32] transition hover:bg-[#dfeee2] dark:bg-[#20332d] dark:text-[#dfeee2]">Read more</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
