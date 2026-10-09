@extends('layouts.app')

@section('title', 'वनको खबर | नेपाली वन र वातावरण समाचार')

@section('content')
    <section data-hero-slider class="relative isolate overflow-hidden">
        <div data-hero-slide class="absolute inset-0 opacity-100 transition-opacity duration-700 motion-reduce:transition-none">
            <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1800&q=80" alt="" class="h-full w-full object-cover object-center">
        </div>
        <div data-hero-slide aria-hidden="true" class="absolute inset-0 opacity-0 transition-opacity duration-700 motion-reduce:transition-none">
            <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1800&q=80" alt="" class="h-full w-full object-cover object-center">
        </div>
        <div data-hero-slide aria-hidden="true" class="absolute inset-0 opacity-0 transition-opacity duration-700 motion-reduce:transition-none">
            <img src="https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1800&q=80" alt="" class="h-full w-full object-cover object-center">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#0d1f11]/80 via-[#102f18]/65 to-[#1b5e20]/35"></div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-20 sm:px-6 lg:px-8 lg:pb-28 lg:pt-28">
            <div class="max-w-3xl">
                <span class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.24em] text-[#edf7ee] backdrop-blur-sm">संसारैबाट जलवायु र जंगल</span>
                <h1 class="mt-6 font-display text-4xl font-black leading-tight text-white sm:text-5xl lg:text-7xl">वनको खबर</h1>
                <p class="mt-5 max-w-xl text-base leading-8 text-[#edf6ee] sm:text-lg">
                    जंगल, जलवायु, वन्यजन्तु, र वातावरणीय व्यवहारमा आधारित तथ्यपरक नेपाली समाचार हाम्रो राष्ट्रिय आवाज हो।
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#news" class="rounded-full bg-[#F4B942] px-6 py-3 text-sm font-bold text-[#1b2b1a] shadow-lg shadow-[#f4b942]/20 transition hover:-translate-y-0.5 hover:bg-[#efad1e]">अहिले पढ्नुहोस्</a>
                    <a href="{{ route('about') }}" class="rounded-full border border-white/30 bg-white/5 px-6 py-3 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/10">हाम्रो बारेमा</a>
                </div>
            </div>
        </div>
        <div role="group" aria-label="Hero image slides" class="absolute inset-x-0 bottom-6 z-10 flex justify-center gap-3">
            <button type="button" data-hero-slide-button aria-label="Show hero image 1" aria-pressed="true" class="h-2 w-10 rounded-full bg-[#dc2626] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#1b5e20]"></button>
            <button type="button" data-hero-slide-button aria-label="Show hero image 2" aria-pressed="false" class="h-2 w-10 rounded-full bg-white/70 transition-colors hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#1b5e20]"></button>
            <button type="button" data-hero-slide-button aria-label="Show hero image 3" aria-pressed="false" class="h-2 w-10 rounded-full bg-white/70 transition-colors hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#1b5e20]"></button>
        </div>
    </section>
    @pushOnce('scripts')
        <script>
            (() => {
                const heroSlider = document.querySelector('[data-hero-slider]');

                if (heroSlider) {
                    const heroSlides = heroSlider.querySelectorAll('[data-hero-slide]');
                    const heroSlideButtons = heroSlider.querySelectorAll('[data-hero-slide-button]');
                    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                    let activeHeroSlide = 0;
                    let heroSlideTimer;

                    const showHeroSlide = (index) => {
                        activeHeroSlide = index;

                        heroSlides.forEach((slide, slideIndex) => {
                            const isActive = slideIndex === activeHeroSlide;
                            slide.classList.toggle('opacity-100', isActive);
                            slide.classList.toggle('opacity-0', !isActive);
                            slide.setAttribute('aria-hidden', String(!isActive));
                        });

                        heroSlideButtons.forEach((button, buttonIndex) => {
                            const isActive = buttonIndex === activeHeroSlide;
                            button.setAttribute('aria-pressed', String(isActive));
                            button.classList.toggle('bg-[#dc2626]', isActive);
                            button.classList.toggle('bg-white/70', !isActive);
                        });
                    };

                    const stopHeroSlideTimer = () => {
                        window.clearInterval(heroSlideTimer);
                    };

                    const startHeroSlideTimer = () => {
                        stopHeroSlideTimer();

                        if (!prefersReducedMotion && heroSlides.length > 1 && !heroSlider.matches(':hover, :focus-within')) {
                            heroSlideTimer = window.setInterval(() => {
                                showHeroSlide((activeHeroSlide + 1) % heroSlides.length);
                            }, 5000);
                        }
                    };

                    heroSlideButtons.forEach((button, index) => {
                        button.addEventListener('click', () => {
                            showHeroSlide(index);
                            startHeroSlideTimer();
                        });
                    });

                    heroSlider.addEventListener('mouseenter', stopHeroSlideTimer);
                    heroSlider.addEventListener('mouseleave', startHeroSlideTimer);
                    heroSlider.addEventListener('focusin', stopHeroSlideTimer);
                    heroSlider.addEventListener('focusout', (event) => {
                        if (!heroSlider.contains(event.relatedTarget)) {
                            startHeroSlideTimer();
                        }
                    });

                    showHeroSlide(0);
                    startHeroSlideTimer();
                }
            })();
        </script>
    @endPushOnce
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    @include('partials.breaking-news', ['breakingNews' => $breakingNews])

    @if ($homeAdvertisements->has('article-top'))
        <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('article-top')])
        </div>
    @endif

    <section id="news" class="scroll-mt-36 mx-auto max-w-7xl px-4 pb-20 pt-16 sm:px-6 lg:px-8">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Featured</p>
                <h2 class="mt-2 font-display text-3xl font-bold text-[#2E7D32] dark:text-[#edf5ee]">मुख्य समाचार</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-[#2E7D32] transition hover:text-[#1B5E20]">सबै समाचार</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]">
            @if ($featured)
            <a href="{{ route('news.show', $featured['slug']) }}" aria-label="Open featured story: {{ $featured['title'] }}" class="group block min-w-0 overflow-hidden rounded-lg bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] transition duration-300 hover:-translate-y-1 focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F] dark:bg-[#17242b]">
                <div class="relative overflow-hidden">
                    <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105 sm:h-64 lg:h-[220px]">
                    <span class="absolute left-5 top-5 rounded-full bg-[#2E7D32] px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white">{{ $featured['badge'] }}</span>
                    <div class="absolute right-4 top-4 flex items-center gap-2 rounded-full bg-[#17242b]/85 px-3 py-1.5 text-[10px] font-semibold text-white shadow-sm backdrop-blur-sm">
                        <span class="inline-flex items-center gap-1" title="Reading time">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                            {{ $featured['reading_time'] }}
                        </span>
                        <span>•</span>
                        <span class="inline-flex items-center gap-1" title="Story views">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                            {{ number_format((int) $featured['views']) }}
                        </span>
                    </div>
                </div>
                <div class="p-5 sm:p-6">
                    <div class="mb-4 flex flex-wrap items-center gap-4 text-xs text-[#5e6f61] dark:text-[#bfd3c3]">
                        <span>{{ $featured['date'] }}</span>
                        <span>•</span>
                        <span>{{ $featured['author'] }}</span>
                    </div>
                    <h3 class="font-display text-lg font-bold leading-snug text-[#1d2a1d] transition group-hover:text-[#2E7D32] dark:text-[#edf5ee] sm:text-xl">
                        {{ $featured['title'] }}
                    </h3>
                    <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <span class="w-fit rounded-full bg-[#edf6ee] px-3 py-1 text-xs font-semibold text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $featured['category'] }}</span>
                        <span class="inline-flex items-center gap-2 font-semibold text-[#2E7D32]">Read more →</span>
                    </div>
                </div>
            </a>
            @else
                <div class="flex min-h-72 items-center justify-center rounded-lg border border-dashed border-[#c9d9c9] bg-white p-8 text-center text-sm text-[#5e6f61] dark:border-white/10 dark:bg-[#17242b] dark:text-[#bfd3c3]">No published stories yet.</div>
            @endif

            <div class="flex flex-col gap-4">
                @foreach($sideFeatures as $item)
                    <a href="{{ route('news.show', $item['slug']) }}" aria-label="Open featured story: {{ $item['title'] }}" class="group flex items-center gap-3 overflow-hidden rounded-xl bg-white p-3 shadow-[0_6px_20px_rgba(19,41,26,0.07)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_10px_28px_rgba(19,41,26,0.12)] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F] dark:bg-[#17242b]">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-20 w-20 shrink-0 rounded-xl object-cover">
                        <div class="min-w-0 flex-1">
                            <div class="mb-1 flex items-center justify-between text-[10px] text-[#5e6f61] dark:text-[#bfd3c3]">
                                <span class="rounded-full bg-[#edf6ee] px-2 py-0.5 font-semibold text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $item['category'] }}</span>
                                <span>{{ $item['date'] }}</span>
                            </div>
                            <h3 class="mt-1 font-display text-sm font-bold leading-snug text-[#1d2a1d] transition group-hover:text-[#2E7D32] dark:text-[#edf5ee] line-clamp-2">
                                {{ $item['title'] }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </section>
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    @if ($homeAdvertisements->has('article-center'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('article-center')])
        </div>
    @endif

    <section class="bg-[#F3F8F1] pb-4 pt-20 dark:bg-[#121d22]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Latest</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">ताजा समाचार</h2>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($latest as $item)
                    <article class="group overflow-hidden rounded-lg bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_26px_55px_rgba(19,41,26,0.12)] dark:bg-[#17242b]">
                        <div class="relative overflow-hidden">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#2E7D32]">{{ $item['category'] }}</span>
                            <div class="absolute right-4 top-4 flex items-center gap-2 rounded-full bg-[#17242b]/85 px-3 py-1.5 text-[10px] font-semibold text-white shadow-sm backdrop-blur-sm">
                                <span class="inline-flex items-center gap-1" title="Reading time">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    {{ $item['reading_time'] }}
                                </span>
                        <span>•</span>
                                <span class="inline-flex items-center gap-1" title="Story views">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    {{ number_format((int) $item['views']) }}
                                </span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="mb-3 flex items-center justify-between text-[11px] text-[#6a7c6c] dark:text-[#bfd3c3]">
                                <span>{{ $item['date'] }}</span>
                                <span>{{ $item['author'] }}</span>
                            </div>
                            <a href="{{ route('news.show', $item['slug']) }}" class="font-display text-xl font-bold leading-relaxed text-[#1d2a1d] transition hover:text-[#2E7D32] dark:text-[#edf5ee]">
                                {{ $item['title'] }}
                            </a>
                            <div class="mt-5 flex items-center justify-between gap-3 border-t border-[#edf1ed] pt-4 dark:border-white/10">
                                <a href="{{ route('news.show', $item['slug']) }}" class="text-xs font-semibold text-[#2E7D32]">Read more →</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>
    @if ($homeAdvertisements->has('latest-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('latest-bottom')])
        </div>
    @else
        <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
            <a href="{{ route('contact') }}" data-ad-placement="latest-bottom-fallback" class="group flex flex-col gap-5 overflow-hidden rounded-2xl bg-gradient-to-r from-[#143b22] via-[#246b35] to-[#2E7D32] p-6 text-white shadow-lg shadow-[#1B5E20]/15 transition hover:-translate-y-0.5 hover:shadow-xl sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <div class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/15 text-2xl" aria-hidden="true">🌿</span>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#d9f7d6]">वनको खबरसँग सहकार्य</p>
                        <h3 class="mt-1 font-display text-lg font-bold sm:text-xl">वन र वातावरणका अभियान पाठकसम्म पुर्‍याउनुहोस्</h3>
                        <p class="mt-2 text-sm leading-6 text-white/80">विज्ञापन तथा सहकार्यका लागि हामीलाई सम्पर्क गर्नुहोस्।</p>
                    </div>
                </div>
                <span class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-[#F4B942] px-5 py-3 text-sm font-bold text-[#1b2b1a] transition group-hover:bg-[#efad1e]">
                    विज्ञापनका लागि सम्पर्क
                    <span aria-hidden="true">→</span>
                </span>
            </a>
        </div>
    @endif

    <section id="categories" class="scroll-mt-36 mx-auto max-w-7xl px-4 pb-4 pt-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Categories</p>
            <h2 class="mt-3 font-display text-3xl font-bold text-[#2E7D32] dark:text-[#edf5ee]">विषयगत क्षेत्र</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category['slug']) }}" aria-label="{{ $category['name'] }} category" class="group relative block overflow-hidden rounded-lg bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] transition focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F] dark:bg-[#17242b]">
                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#112822]/85 via-[#112822]/20 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-3xl">{{ $category['icon'] }}</span>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-white backdrop-blur-sm">{{ number_format((int) $category['count']) }} stories</span>
                        </div>
                        <h3 class="font-display text-2xl font-semibold text-white">{{ $category['name'] }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @if ($homeAdvertisements->has('categories-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('categories-bottom')])
        </div>
    @endif

    <section id="wildlife" class="mt-4 bg-[#0f1720] py-20 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#8FD58F]">Trending</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-white">ट्रेन्डिङ समाचार</h2>
                </div>
                <div class="flex gap-2">
                    <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/5 text-lg">â†</button>
                    <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/5 text-lg">â†’</button>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
                @foreach($trending as $item)
                    <a href="{{ route('news.show', $item['slug']) }}" aria-label="Open story: {{ $item['title'] }}" class="group block overflow-hidden rounded-[24px] border border-white/10 bg-white/5 backdrop-blur-sm transition hover:border-white/25 hover:bg-white/10 focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F]">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-48 w-full object-cover">
                        <div class="p-4">
                            <span class="text-[10px] uppercase tracking-[0.2em] text-[#8FD58F]">{{ $item['category'] }}</span>
                            <h3 class="mt-3 font-display text-lg font-bold leading-snug text-white">{{ $item['title'] }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @if ($homeAdvertisements->has('trending-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('trending-bottom')])
        </div>
    @endif

    <section class="mx-auto max-w-7xl px-4 pb-4 pt-20 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Insights</p>
            <h2 class="mt-3 font-display text-3xl font-bold text-[#2E7D32] dark:text-[#edf5ee]">वन र वातावरणको १२+ प्रमुख क्षेत्र</h2>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($highlights as $item)
                <a href="{{ route('category.show', $item['slug']) }}" aria-label="Open insight: {{ $item['title'] }}" class="group block overflow-hidden rounded-[24px] border border-[#dfeae0] bg-white p-5 shadow-[0_18px_45px_rgba(19,41,26,0.04)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(19,41,26,0.08)] focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F] dark:border-white/10 dark:bg-[#17242b]">
                    <div class="mb-4 overflow-hidden rounded-2xl">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-36 w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#2E7D32]">{{ $item['label'] }}</div>
                        <span class="text-lg">{{ $item['icon'] }}</span>
                    </div>
                    <h3 class="mt-2 font-display text-xl font-bold text-[#1d2a1d] dark:text-[#edf5ee]">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-[#4f5c4f] dark:text-[#dce8dd]">{{ $item['description'] }}</p>
                </a>
            @endforeach
        </div>
    </section>
    @if ($homeAdvertisements->has('insights-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('insights-bottom')])
        </div>
    @endif

    <section id="environment" class="scroll-mt-36 mx-auto max-w-7xl px-4 pb-20 pt-4 sm:px-6 lg:px-8">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Gallery</p>
                <h2 class="mt-2 font-display text-3xl font-bold text-[#2E7D32] dark:text-[#edf5ee]">फोटो ग्यालरी</h2>
            </div>
            <a href="{{ route('gallery') }}" class="text-sm font-semibold text-[#2E7D32]">सबै ग्यालरी</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($gallery as $item)
                <a href="{{ $item['image'] }}" target="_blank" rel="noopener" aria-label="Open gallery image: {{ $item['title'] }}" class="group block overflow-hidden rounded-[24px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] transition hover:-translate-y-1 focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F] dark:bg-[#17242b]">
                    <figure>
                        <div class="overflow-hidden">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-72 w-full object-cover transition duration-500 group-hover:scale-110">
                        </div>
                        <figcaption class="flex items-center justify-between p-4 text-sm text-[#3f4f42] dark:text-[#d9e8dc]">
                            <span>{{ $item['title'] }}</span>
                            <span class="rounded-full bg-[#edf6ee] px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $item['category'] }}</span>
                        </figcaption>
                    </figure>
                </a>
            @endforeach
        </div>
    </section>
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    <section class="bg-[#edf6ee] py-20 dark:bg-[#111f24]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Video</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">वन र वातावरणको भिडियो</h2>
            </div>

            <div class="grid min-w-0 items-stretch gap-8 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)]">
                <div class="relative aspect-video min-w-0 overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] dark:bg-[#17242b]">
                    <video class="absolute inset-0 h-full w-full bg-black object-cover" controls playsinline preload="metadata" poster="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80" aria-label="Flower and forest conservation video">
                        <source src="https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4" type="video/mp4">
                        Your browser does not support HTML video.
                    </video>
                </div>

                <div class="flex min-w-0 flex-col gap-5 lg:h-full">
                    <div class="min-w-0 rounded-[24px] bg-white p-5 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b] lg:flex-1">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Watch</p>
                        <h3 class="mt-3 font-display text-xl font-bold leading-snug text-[#1d2a1d] dark:text-[#edf5ee]">मरुभूमिमा हृदयस्पर्शी वन संरक्षण</h3>
                        <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">कर्मचारी र समुदायले सामूहिक प्रयासबाट पर्खालबाहिरको रणनीतिलाई कसरी सफल बनाएरहेका छन्।</p>
                    </div>
                    <div class="min-w-0 rounded-[24px] bg-white p-5 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b] lg:flex-1">
                        <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Watch</p>
                        <h3 class="mt-3 font-display text-xl font-bold leading-snug text-[#1d2a1d] dark:text-[#edf5ee]">हिमालको जलस्रोत संरक्षण</h3>
                        <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">हिमाली क्षेत्रमा पलस्तर र जलाशय व्यवस्थापनले स्थानीय समुदायको अस्तित्वलाई कसरी सुरक्षित बनाउँछ।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-[30px] bg-[linear-gradient(135deg,#163f21,#2E7D32,#1B5E20)] px-6 py-10 text-white shadow-[0_24px_60px_rgba(38,82,44,0.25)] sm:px-10 lg:px-14">
            <div class="grid items-center gap-10 lg:grid-cols-[1.2fr_0.8fr]">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#d9f7d6]">Newsletter</p>
                    <h2 class="mt-3 font-display text-3xl font-bold">वनका खबर र संरक्षण अपडेट पाउनुहोस्</h2>
                    <p class="mt-4 max-w-lg text-sm leading-7 text-[#d9f7d6]">साप्ताहिक रिपोर्ट, वातावरणीय अपडेट, र अभियान सूचना प्रतिदिनको समाचारमा पाउनुहोस्।</p>
                </div>
                <form class="flex flex-col gap-3 rounded-[26px] bg-white/10 p-3 backdrop-blur-sm sm:flex-row">
                    <input type="email" placeholder="तपाईंको ईमेल" class="h-14 flex-1 rounded-full border border-white/20 bg-white/10 px-5 text-white placeholder:text-white/70 focus:outline-none">
                    <button type="submit" class="h-14 rounded-full bg-[#F4B942] px-6 text-sm font-bold text-[#1b2b1a] transition hover:bg-[#efad1e]">Subscribe</button>
                </form>
            </div>
        </div>
    </section>
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    <section class="mx-auto max-w-7xl px-4 pb-20 pt-20 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-[28px] bg-white p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">About</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">वन र वातावरणलाई सामाजिक जिम्मेवारीको साथ</h2>
                <p class="mt-5 text-sm leading-8 text-[#4f5c4f] dark:text-[#dce8dd]">
                    वनको खबरले नेपाल भित्र वन संरक्षण, जलवायु परिवर्तन, शान्तिपूर्ण पर्यावरण, र स्थानीय समुदायको प्रयासलाई प्रमुखता दिने प्रयास गर्दछ। हामीले तथ्यपरक, भरोसेमूलक, तथा अध्ययनआधारित समाचार पहुँच गर्ने लक्ष्य राख्यौं।
                </p>
                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl bg-[#edf6ee] p-4 dark:bg-[#20332d]">
                        <div class="text-2xl font-black text-[#2E7D32]">६+</div>
                        <div class="mt-2 text-sm text-[#4f5c4f] dark:text-[#dce8dd]">वर्षीय अनुभव</div>
                    </div>
                    <div class="rounded-2xl bg-[#edf6ee] p-4 dark:bg-[#20332d]">
                        <div class="text-2xl font-black text-[#2E7D32]">२५०+</div>
                        <div class="mt-2 text-sm text-[#4f5c4f] dark:text-[#dce8dd]">समाचार रिपोर्ट</div>
                    </div>
                    <div class="rounded-2xl bg-[#edf6ee] p-4 dark:bg-[#20332d]">
                        <div class="text-2xl font-black text-[#2E7D32]">९५%</div>
                        <div class="mt-2 text-sm text-[#4f5c4f] dark:text-[#dce8dd]">सकारात्मक सहयोग</div>
                    </div>
                </div>
            </div>

            <div id="mission" class="scroll-mt-36 rounded-[28px] bg-[linear-gradient(135deg,#f4f9f3,#eaf4eb)] p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Mission</p>
                <h3 class="mt-3 font-display text-2xl font-bold text-[#2E7D32] dark:text-[#edf5ee]">मिशन</h3>
                <ul class="mt-5 space-y-4 text-sm leading-7 text-[#2E7D32] dark:text-[#dce8dd]">
                    <li>• नेपालमा वन संरक्षण र पर्यावरणीय सचेतना बढाउनु</li>
                    <li>• तथ्य र अनुसन्धानमा आधारित समाचार प्रस्तुत गर्नु</li>
                    <li>• समुदाय र निजीसंगठनो सहयोगलाई प्रोत्साहन गर्नु</li>
                </ul>
            </div>
        </div>
    </section>
    @if ($homeAdvertisements->has('section-bottom'))
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('section-bottom')])
        </div>
    @endif

    @if ($homeAdvertisements->has('footer'))
        <div class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
            @include('partials.advertisement-placement', ['advertisements' => $homeAdvertisements->get('footer')])
        </div>
    @endif
@endsection
