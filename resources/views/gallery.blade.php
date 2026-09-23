@extends('layouts.app')

@section('title', 'Gallery | वनको खबर')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Gallery</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">फोटो ग्यालरी</h1>
        </div>

        <div class="mb-8 flex flex-wrap gap-3">
            @foreach($categories as $category)
                <button class="rounded-full border border-[#dfeae0] bg-white px-4 py-2 text-sm font-medium text-[#1B5E20] hover:bg-[#edf6ee] dark:border-white/10 dark:bg-[#17242b] dark:text-[#edf5ee]">{{ $category }}</button>
            @endforeach
        </div>

        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach($galleryItems as $item)
                <figure class="group overflow-hidden rounded-[26px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-72 w-full object-cover transition duration-500 group-hover:scale-110">
                    </div>
                    <figcaption class="flex items-center justify-between p-4 text-sm text-[#3f4f42] dark:text-[#d9e8dc]">
                        <span>{{ $item['title'] }}</span>
                        <span class="rounded-full bg-[#edf6ee] px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $item['category'] }}</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </section>
@endsection
