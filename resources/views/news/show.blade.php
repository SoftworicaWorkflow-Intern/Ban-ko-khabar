@extends('layouts.app')

@section('title', $article['title'])

@section('content')
    <section class="mx-auto max-w-5xl px-4 pb-20 pt-12 sm:px-6 lg:px-8">
        <nav class="mb-8 flex items-center gap-3 text-sm text-[#5e6f61] dark:text-[#bfcebf]">
            <a href="{{ route('home') }}" class="hover:text-[#2E7D32]">गृहपृष्ठ</a>
            <span>›</span>
            <a href="{{ route('home') }}#news" class="hover:text-[#2E7D32]">समाचार</a>
            <span>›</span>
            <span class="text-[#2E7D32]">{{ $article['category'] }}</span>
        </nav>

        <article class="overflow-hidden rounded-[30px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.06)] dark:bg-[#17242b]">
            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="h-[420px] w-full object-cover">
            <div class="p-6 sm:p-8 lg:p-10">
                <div class="mb-5 flex flex-wrap items-center gap-3 text-xs text-[#6a7c6c] dark:text-[#bfd3c3]">
                    <span class="rounded-full bg-[#edf6ee] px-3 py-1 font-semibold text-[#2E7D32] dark:bg-[#20332d] dark:text-[#dfeee2]">{{ $article['category'] }}</span>
                    <span>{{ $article['date'] }}</span>
                    <span>•</span>
                    <span>{{ $article['author'] }}</span>
                    <span>•</span>
                    <span>{{ $article['reading_time'] }}</span>
                </div>

                <h1 class="font-display text-3xl font-black leading-tight text-[#1B5E20] sm:text-4xl dark:text-[#edf5ee]">{{ $article['title'] }}</h1>

                <div class="mt-8 flex items-center justify-between border-y border-[#edf1ed] py-4 dark:border-white/10">
                    <div class="flex items-center gap-3">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80" alt="{{ $article['author'] }}" class="h-12 w-12 rounded-full object-cover">
                        <div>
                            <div class="font-semibold text-[#1d2a1d] dark:text-[#edf5ee]">{{ $article['author'] }}</div>
                            <div class="text-xs text-[#6a7c6c] dark:text-[#bfd3c3]">News Editor</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-sm dark:border-white/10 dark:bg-[#20332d]">f</button>
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-sm dark:border-white/10 dark:bg-[#20332d]">x</button>
                        <button class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dfeae0] bg-white text-sm dark:border-white/10 dark:bg-[#20332d]">in</button>
                    </div>
                </div>

                <div class="prose prose-lg mt-8 max-w-none leading-9 text-[#2b3a2d] dark:prose-invert dark:text-[#dfeee2]">
                    <p>{{ $article['excerpt'] }}</p>
                    <p>नेपालमा वन संरक्षण, जलवायु परिवर्तन, और पर्यावरणीय मैत्री नीति आदानप्रदानका लागि स्थानीय समुदाय र सरकारी संस्थाहरुलाई थप सहयोग आवश्यक छ। यस्ता मुद्दाहरूमा तथ्य र प्रमाणिकता महत्त्वपूर्ण हुन्छ, र इस लेखले यस्ता विषयलाई सहज र स्पष्ट रूपमा प्रस्तुत गर्न प्रयास गर्छ।</p>
                    <p>उच्च हिमाली क्षेत्रमा स्थिर जलस्रोत, वन्यजन्तु आवास, और सहर-गाउँको जीवनस्तरलाई ध्यानमा राख्दै भविष्यमा अधिक समन्वयात्मक रणनीतिका आवश्यकता छ। समुदायले वनका लागि सहमति बनाउने र स्थानीय सहभागिता बढाउने प्रयत्नले स्थिरता र सुरक्षा हुँदै जान्छ।</p>
                    <p>यस पहलको मुख्य उद्देश्य केवल समाचार रिपोर्ट गर्नु मात्र होईन, बल्कि सामाजिक परिप्रेक्ष्यमा नागरिकहरूमा चेतना जगाउनु हो। सहर, गाउँ, र राष्ट्रीय संरचनामा जन्मिने स्वभावजन्य परिवर्तनलाई अपस्ट्रीम रणनीतिसँग जोड्न आवश्यक छ।</p>
                </div>

                <div class="mt-10 rounded-[24px] bg-[#edf6ee] p-5 text-[#1B5E20] dark:bg-[#20332d] dark:text-[#edf5ee]">
                    <div class="text-xs font-bold uppercase tracking-[0.25em]">Key takeaway</div>
                    <p class="mt-3 text-sm leading-7">वन संरक्षणका लागि स्थानीय समुदाय, सरकारी नीति, र पर्यावरणीय शिक्षा एकैसाथ समन्वय हुनु आवश्यक छ।</p>
                </div>
            </div>
        </article>

        <section class="mt-16">
            <div class="mb-6 flex items-center justify-between">
                <h2 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">सम्बन्धित समाचार</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($related as $item)
                    <article class="overflow-hidden rounded-[24px] bg-white shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b]">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-48 w-full object-cover">
                        <div class="p-5">
                            <span class="text-[10px] uppercase tracking-[0.18em] text-[#2E7D32]">{{ $item['category'] }}</span>
                            <a href="{{ route('news.show', $item['slug']) }}" class="mt-3 block font-display text-xl font-bold leading-snug text-[#1d2a1d] dark:text-[#edf5ee]">{{ $item['title'] }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="mt-16 rounded-[28px] bg-white p-6 shadow-[0_18px_45px_rgba(19,41,26,0.05)] dark:bg-[#17242b] sm:p-8">
            <h3 class="font-display text-2xl font-bold text-[#1B5E20] dark:text-[#edf5ee]">Comments</h3>
            <div class="mt-6 space-y-5">
                <div class="rounded-2xl bg-[#f7faf7] p-4 dark:bg-[#20332d]">
                    <div class="font-semibold text-[#1d2a1d] dark:text-[#edf5ee]">मंगला</div>
                    <p class="mt-2 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">वन संरक्षणको महत्वलाई यसरी स्पष्टरुपमा प्रस्तुत गर्नु राम्रो भयो। समुदायले पनि यसलाई सहयोग गर्नुपर्छ।</p>
                </div>
                <div class="rounded-2xl bg-[#f7faf7] p-4 dark:bg-[#20332d]">
                    <div class="font-semibold text-[#1d2a1d] dark:text-[#edf5ee]">गणेश</div>
                    <p class="mt-2 text-sm leading-7 text-[#4f5c4f] dark:text-[#dce8dd]">पर्यावरणीय रिपोर्टिङमा सही तथ्य र तालिका समावेश हुनु राम्रो छ।</p>
                </div>
            </div>

            <form class="mt-8 space-y-4">
                <textarea rows="4" class="w-full rounded-2xl border border-[#dfeae0] bg-[#f8faf8] px-4 py-3 text-sm text-[#212121] focus:outline-none dark:border-white/10 dark:bg-[#0f1720] dark:text-[#edf5ee]" placeholder="तपाईंको विचार लेख्नुहोस्..."></textarea>
                <button type="submit" class="rounded-full bg-[#2E7D32] px-6 py-3 text-sm font-bold text-white hover:bg-[#1B5E20]">Comment</button>
            </form>
        </section>
    </section>
@endsection
