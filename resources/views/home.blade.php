@extends('layouts.app')

@section('title', 'वनको खबर | नेपाली वन र वातावरण समाचार')

@section('content')
    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center"></div>
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
    </section>

    <div class="border-y border-[#dfeae0] bg-[#1b5e20] text-white dark:border-white/10 dark:bg-[#112822]">
        <div class="mx-auto flex max-w-7xl items-center gap-4 overflow-hidden px-4 py-3 sm:px-6 lg:px-8">
            <span class="shrink-0 rounded-full bg-[#e53935] px-3 py-1 text-xs font-bold uppercase tracking-wide">Breaking</span>
            <div class="relative flex-1 overflow-hidden">
                <div class="animate-[marquee_20s_linear_infinite] whitespace-nowrap text-sm font-medium">
                    @foreach($breakingNews as $item)
                        <span class="mr-10">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <section id="news" class="mx-auto max-w-7xl px-4 pb-20 pt-16 sm:px-6 lg:px-8">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Featured</p>
                <h2 class="mt-2 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">मुख्य समाचार</h2>
            </div>
            <a href="#" class="text-sm font-semibold text-[#2E7D32] transition hover:text-[#1B5E20]">सबै समाचार</a>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.7fr_1fr]">
            <article class="group overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] transition duration-300 hover:-translate-y-1 dark:bg-[#17242b]">
                <div class="relative overflow-hidden">
                    <img src="{{ $featured['image'] }}" alt="{{ $featured['title'] }}" class="h-[420px] w-full object-cover transition duration-500 group-hover:scale-105">
                    <span class="absolute left-5 top-5 rounded-full bg-[#2E7D32] px-3 py-1 text-xs font-bold uppercase tracking-[0.2em] text-white">{{ $featured['badge'] }}</span>
                </div>
                <div class="p-6 sm:p-8">
                    <div class="mb-4 flex flex-wrap items-center gap-4 text-xs text-[#5e6f61] dark:text-[#bfd3c3]">
                        <span>{{ $featured['date'] }}</span>
                        <span>•</span>
                        <span>{{ $featured['author'] }}</span>
                        <span>•</span>
                        <span>{{ $featured['reading_time'] }}</span>
                    </div>
                    <a href="{{ route('news.show', $featured['slug']) }}" class="font-display text-2xl font-bold leading-snug text-[#1d2a1d] transition hover:text-[#2E7D32] dark:text-[#edf5ee]">
                        {{ $featured['title'] }}
                    </a>
                    <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">{{ $featured['excerpt'] }}</p>
                    <div class="mt-6 flex items-center justify-between">
                        <span class="rounded-full bg-[#edf6ee] px-3 py-1 text-xs font-semibold text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $featured['category'] }}</span>
                        <a href="{{ route('news.show', $featured['slug']) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#2E7D32]">Read more <span>→</span></a>
                    </div>
                </div>
            </article>

            <div class="space-y-6">
                @foreach($sideFeatures as $item)
                    <article class="group overflow-hidden rounded-[24px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] transition duration-300 hover:-translate-y-1 dark:bg-[#17242b]">
                        <div class="flex gap-4 p-4">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-32 w-32 rounded-2xl object-cover">
                            <div class="flex-1">
                                <div class="mb-2 flex items-center justify-between text-[11px] text-[#5e6f61] dark:text-[#bfd3c3]">
                                    <span>{{ $item['category'] }}</span>
                                    <span>{{ $item['date'] }}</span>
                                </div>
                                <a href="{{ route('news.show', $item['slug']) }}" class="font-display text-lg font-bold leading-snug text-[#1d2a1d] transition hover:text-[#2E7D32] dark:text-[#edf5ee]">
                                    {{ $item['title'] }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#F3F8F1] py-20 dark:bg-[#121d22]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Latest</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">ताजा समाचार</h2>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($latest as $item)
                    <article class="group overflow-hidden rounded-[26px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] transition duration-300 hover:-translate-y-2 hover:shadow-[0_26px_55px_rgba(19,41,26,0.12)] dark:bg-[#17242b]">
                        <div class="relative overflow-hidden">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-105">
                            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.2em] text-[#2E7D32]">{{ $item['category'] }}</span>
                        </div>
                        <div class="p-5">
                            <div class="mb-3 flex items-center justify-between text-[11px] text-[#6a7c6c] dark:text-[#bfd3c3]">
                                <span>{{ $item['date'] }}</span>
                                <span>{{ $item['author'] }}</span>
                            </div>
                            <a href="{{ route('news.show', $item['slug']) }}" class="font-display text-xl font-bold leading-relaxed text-[#1d2a1d] transition hover:text-[#2E7D32] dark:text-[#edf5ee]">
                                {{ $item['title'] }}
                            </a>
                            <p class="mt-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">{{ $item['excerpt'] }}</p>
                            <div class="mt-5 flex items-center justify-between">
                                <span class="text-xs text-[#6a7c6c] dark:text-[#bfd3c3]">{{ $item['reading_time'] }}</span>
                                <a href="{{ route('news.show', $item['slug']) }}" class="inline-flex items-center gap-2 rounded-full bg-[#edf6ee] px-4 py-2 text-xs font-semibold text-[#2E7D32] transition hover:bg-[#dfeee2] dark:bg-[#20332d] dark:text-[#dfeee2]">Read more</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="categories" class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Categories</p>
            <h2 class="mt-3 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">विषयगत क्षेत्र</h2>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($categories as $category)
                <div class="group relative overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] dark:bg-[#17242b]">
                    <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#112822]/85 via-[#112822]/20 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6">
                        <div class="mb-3 flex items-center justify-between">
                            <span class="text-3xl">{{ $category['icon'] }}</span>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-white backdrop-blur-sm">{{ $category['count'] }}</span>
                        </div>
                        <h3 class="font-display text-2xl font-semibold text-white">{{ $category['name'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="wildlife" class="bg-[#0f1720] py-20 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#8FD58F]">Trending</p>
                    <h2 class="mt-2 font-display text-3xl font-bold text-white">ट्रेन्डिङ समाचार</h2>
                </div>
                <div class="flex gap-2">
                    <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/5 text-lg">←</button>
                    <button class="flex h-10 w-10 items-center justify-center rounded-full border border-white/15 bg-white/5 text-lg">→</button>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-5">
                @foreach($trending as $item)
                    <article class="overflow-hidden rounded-[24px] border border-white/10 bg-white/5 backdrop-blur-sm">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-48 w-full object-cover">
                        <div class="p-4">
                            <span class="text-[10px] uppercase tracking-[0.2em] text-[#8FD58F]">{{ $item['category'] }}</span>
                            <a href="{{ route('news.show', $item['slug']) }}" class="mt-3 block font-display text-lg font-bold leading-snug text-white">{{ $item['title'] }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="environment" class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 flex items-end justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Gallery</p>
                <h2 class="mt-2 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">फोटो ग्यालरी</h2>
            </div>
            <a href="{{ route('gallery') }}" class="text-sm font-semibold text-[#2E7D32]">सबै ग्यालरी</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($gallery as $item)
                <figure class="group overflow-hidden rounded-[24px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <div class="overflow-hidden">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-72 w-full object-cover transition duration-500 group-hover:scale-110">
                    </div>
                    <figcaption class="flex items-center justify-between p-4 text-sm text-[#3f4f42] dark:text-[#d9e8dc]">
                        <span>{{ $item['title'] }}</span>
                        <span class="rounded-full bg-[#edf6ee] px-2 py-1 text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $item['category'] }}</span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </section>

    <section class="bg-[#edf6ee] py-20 dark:bg-[#111f24]">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Video</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">वन र वातावरणको भिडियो</h2>
                <div class="mt-8 overflow-hidden rounded-[28px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.08)] dark:bg-[#17242b]">
                    <div class="relative aspect-video">
                        <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=80" alt="video thumbnail" class="h-full w-full object-cover">
                        <button class="absolute left-1/2 top-1/2 flex h-20 w-20 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-[#2E7D32] text-2xl text-white shadow-xl shadow-[#2E7D32]/25">▶</button>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="rounded-[24px] bg-white p-5 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Watch</p>
                    <h3 class="mt-3 font-display text-2xl font-bold text-[#1d2a1d] dark:text-[#edf5ee]">मरुभूमिमा हृदयस्पर्शी वन संरक्षण</h3>
                    <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">कर्मचारी र समुदायले सामूहिक प्रयासबाट पर्खालबाहिरको रणनीतिलाई कसरी सफल बनाएरहेका छन्।</p>
                </div>
                <div class="rounded-[24px] bg-white p-5 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                    <p class="text-xs font-bold uppercase tracking-[0.25em] text-[#2E7D32]">Watch</p>
                    <h3 class="mt-3 font-display text-2xl font-bold text-[#1d2a1d] dark:text-[#edf5ee]">हिमालको जलस्रोत संरक्षण</h3>
                    <p class="mt-3 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">हिमाली क्षेत्रमा पलस्तर र जलाशय व्यवस्थापनले स्थानीय समुदायको अस्तित्वलाई कसरी सुरक्षित बनाउँछ।</p>
                </div>
            </div>
        </div>
    </section>

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

            <div class="rounded-[28px] bg-[linear-gradient(135deg,#f4f9f3,#eaf4eb)] p-8 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                <p class="text-xs font-bold uppercase tracking-[0.28em] text-[#2E7D32]">Mission</p>
                <h3 class="mt-3 font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">मिशन</h3>
                <ul class="mt-5 space-y-4 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">
                    <li>• नेपालमा वन संरक्षण र पर्यावरणीय सचेतना बढाउनु</li>
                    <li>• तथ्य र अनुसन्धानमा आधारित समाचार प्रस्तुत गर्नु</li>
                    <li>• समुदाय र निजीसंगठनो सहयोगलाई प्रोत्साहन गर्नु</li>
                </ul>
            </div>
        </div>
    </section>
@endsection
