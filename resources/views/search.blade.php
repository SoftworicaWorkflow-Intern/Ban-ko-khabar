@extends('layouts.app')

@section('title', 'Search | वनको खबर')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-[30px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
            <div class="mb-8">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Search</p>
                <h1 class="mt-3 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">समाचार खोज्नुहोस्</h1>
            </div>

            <form method="GET" action="{{ route('search') }}" class="grid gap-4 lg:grid-cols-[1.4fr_0.7fr_0.7fr_0.4fr]">
                <input name="q" value="{{ $query }}" placeholder="समाचार खोज्नुहोस्..." class="h-14 rounded-full border border-[#dfeae0] bg-[#f8faf8] px-5 text-sm text-[#212121] outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]">
                <select name="category" class="h-14 rounded-full border border-[#dfeae0] bg-[#f8faf8] px-5 text-sm text-[#212121] outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]">
                    <option value="all">सबै</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ $category == $category ? '' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <input type="date" class="h-14 rounded-full border border-[#dfeae0] bg-[#f8faf8] px-5 text-sm text-[#212121] outline-none focus:border-[#2E7D32] dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]">
                <button type="submit" class="h-14 rounded-full bg-[#2E7D32] px-6 text-sm font-bold text-white hover:bg-[#1B5E20]">खोज्नुहोस्</button>
            </form>

            <div class="mt-10 space-y-5">
                @forelse($results as $item)
                    <article class="flex flex-col gap-4 rounded-[24px] border border-[#edf1ed] bg-[#f9fbf9] p-4 sm:flex-row dark:border-white/10 dark:bg-[#20332d]">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-32 w-full rounded-2xl object-cover sm:w-40">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 text-[11px] text-[#5e6f61] dark:text-[#bfd3c3]">
                                <span class="rounded-full bg-white px-2 py-1 text-[#2E7D32] dark:bg-[#0f1720] dark:text-[#dfeee2]">{{ $item['category'] }}</span>
                                <span>{{ $item['date'] }}</span>
                                <span>{{ $item['author'] }}</span>
                            </div>
                            <a href="{{ route('news.show', $item['slug']) }}" class="mt-3 block font-display text-xl font-bold text-[#1d2a1d] hover:text-[#2E7D32] dark:text-[#edf5ee]">{{ $item['title'] }}</a>
                            <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">{{ $item['excerpt'] }}</p>
                        </div>
                    </article>
                @empty
                    <div class="rounded-[24px] bg-[#edf6ee] p-8 text-center text-[#1B5E20] dark:bg-[#20332d] dark:text-[#edf5ee]">कुनै परिणाम फेला परेन।</div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
