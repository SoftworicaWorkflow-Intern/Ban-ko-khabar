@extends('layouts.app')

@section('title', $article['title'])

@section('content')
    <section class="bg-white text-black">
        <div class="mx-auto max-w-7xl px-4 pb-20 pt-10 sm:px-6 lg:px-8">
            <div id="articleBodyWithAds" class="grid min-w-0 items-stretch gap-10 lg:grid-cols-2">
                <div class="min-w-0">
                    <nav aria-label="Breadcrumb" class="mb-6 flex flex-wrap items-center gap-2 text-sm text-neutral-500">
                        <a href="{{ route('home') }}" class="transition hover:text-red-700">गृहपृष्ठ</a>
                        <span aria-hidden="true">/</span>
                        <a href="{{ route('home') }}#news" class="transition hover:text-red-700">समाचार</a>
                        <span aria-hidden="true">/</span>
                        <span class="text-neutral-700">{{ $article['category'] }}</span>
                    </nav>

                    <article class="min-w-0">
                        <header>
                            <span class="inline-flex bg-neutral-100 px-3 py-1 text-xs font-semibold text-neutral-700">{{ $article['category'] }}</span>
                            <h1 class="mt-4 max-w-4xl text-3xl font-extrabold leading-tight text-neutral-950 sm:text-4xl lg:text-5xl">{{ $article['title'] }}</h1>

                            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 border-y border-neutral-200 py-4 text-sm text-neutral-600">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर" class="h-10 w-10 rounded-full border border-neutral-200 object-cover">
                                    <span class="font-semibold text-neutral-900">{{ $article['author'] }}</span>
                                </div>
                                <span>{{ $article['date'] }}</span>
                                <span>{{ number_format((int) ($article['views'] ?? 0)) }} views</span>
                                <span>{{ $article['reading_time'] }} पढ्ने समय</span>
                            </div>
                        </header>

                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="mt-7 aspect-[16/9] w-full object-cover">

                        <div class="mt-8 max-w-none text-base leading-8 text-neutral-800 sm:text-lg">
                            <p class="mb-6 font-medium leading-8">{{ $article['excerpt'] }}</p>
                            @if (!empty($article['body']) && $article['body'] !== '...')
                                @php
                                    $articleParagraphs = preg_split('/\R+/u', trim($article['body']), -1, PREG_SPLIT_NO_EMPTY) ?: [];
                                @endphp
                                <ul class="space-y-4 pl-6 marker:text-red-600">
                                    @foreach ($articleParagraphs as $paragraph)
                                        <li class="pl-2 whitespace-pre-line">{{ $paragraph }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <ul class="space-y-4 pl-6 marker:text-red-600">
                                    <li class="pl-2">नेपालमा वन संरक्षण र वातावरणीय नीतिमा स्थानीय समुदाय तथा सरकारी संस्थाबीच थप सहकार्य आवश्यक छ।</li>
                                    <li class="pl-2">उच्च हिमाली क्षेत्रका जलस्रोत, वन्यजन्तुका बासस्थान र स्थानीय जीविकोपार्जनलाई संरक्षण योजनासँग जोड्नुपर्ने देखिन्छ।</li>
                                    <li class="pl-2">समुदायको सहभागिता र तथ्यमा आधारित रिपोर्टिङले दीर्घकालीन संरक्षण प्रयासलाई बलियो बनाउँछ।</li>
                                </ul>
                            @endif
                        </div>

                        <div class="mt-8 flex justify-end gap-2 border-t border-neutral-200 pt-5" aria-label="Share article">
                            <button type="button" aria-label="Share on Facebook" class="flex h-10 w-10 items-center justify-center border border-neutral-200 text-sm font-semibold text-neutral-800 transition hover:border-red-600 hover:text-red-700">f</button>
                            <button type="button" aria-label="Share on X" class="flex h-10 w-10 items-center justify-center border border-neutral-200 text-sm font-semibold text-neutral-800 transition hover:border-red-600 hover:text-red-700">x</button>
                            <button type="button" aria-label="Share on LinkedIn" class="flex h-10 w-10 items-center justify-center border border-neutral-200 text-xs font-semibold text-neutral-800 transition hover:border-red-600 hover:text-red-700">in</button>
                        </div>
                    </article>

                    <section id="comments" class="mt-12 border-t border-neutral-200 pt-8">
                        <h2 class="text-2xl font-bold text-neutral-950">Comments ({{ $comments->count() }})</h2>

                        @if (session('success'))
                            <p class="mt-4 border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</p>
                        @endif

                        @if ($errors->any())
                            <div class="mt-4 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                <ul class="list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-6 space-y-4">
                            @forelse ($comments as $comment)
                                <article class="border border-neutral-200 p-4">
                                    <div class="font-semibold text-neutral-900">{{ $comment->name }}</div>
                                    <p class="mt-2 whitespace-pre-line text-sm leading-7 text-neutral-700">{{ $comment->body }}</p>
                                </article>
                            @empty
                                <p class="border border-neutral-200 bg-neutral-50 p-4 text-sm text-neutral-600">अहिलेसम्म कुनै टिप्पणी छैन। पहिलो टिप्पणी लेख्नुहोस्।</p>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('news.comments.store', $article['slug']) }}" class="mt-8 space-y-4">
                            @csrf
                            <div>
                                <label for="comment-name" class="mb-2 block text-sm font-medium text-neutral-900">तपाईंको नाम</label>
                                <input id="comment-name" type="text" name="name" value="{{ old('name') }}" required maxlength="100" class="w-full border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 focus:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-100">
                            </div>
                            <div>
                                <label for="comment-body" class="mb-2 block text-sm font-medium text-neutral-900">तपाईंको टिप्पणी</label>
                                <textarea id="comment-body" name="body" rows="4" required maxlength="2000" class="w-full border border-neutral-300 bg-white px-4 py-3 text-sm text-neutral-900 focus:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-100" placeholder="तपाईंको विचार लेख्नुहोस्...">{{ old('body') }}</textarea>
                            </div>
                            <button type="submit" class="bg-red-700 px-6 py-3 text-sm font-bold text-white transition hover:bg-red-800">Comment</button>
                        </form>
                    </section>
                </div>

                <aside aria-label="Most read and advertisements" class="flex h-full flex-col gap-8">
                    <section class="border-l-4 border-red-700 pl-5">
                        <h2 class="text-xl font-bold text-neutral-950">Most Read</h2>
                        <ol class="mt-5 divide-y divide-neutral-200">
                            @forelse ($mostRead as $item)
                                <li class="py-4 first:pt-0 last:pb-0">
                                    <a href="{{ route('news.show', $item['slug']) }}" class="group flex gap-3">
                                        <span class="shrink-0 text-lg font-bold tabular-nums text-red-700">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="min-w-0">
                                            <span class="block text-sm font-semibold leading-6 text-neutral-900 transition group-hover:text-red-700">{{ $item['title'] }}</span>
                                            <span class="mt-1 block text-xs text-neutral-500">{{ number_format((int) ($item['views'] ?? 0)) }} views</span>
                                        </span>
                                    </a>
                                </li>
                            @empty
                                <li class="py-4 text-sm text-neutral-500">अहिलेसम्म समाचार उपलब्ध छैन।</li>
                            @endforelse
                        </ol>
                    </section>

                    @if ($articleCenterAdvertisements->isNotEmpty() || $articleSidebarAdvertisements->isNotEmpty())
                        <div data-article-sidebar-ad class="space-y-4">
                            @if ($articleCenterAdvertisements->isNotEmpty())
                                <div data-article-center-sidebar-ad>
                                    @include('partials.advertisement-placement', ['advertisements' => $articleCenterAdvertisements])
                                </div>
                            @endif
                            @if ($articleSidebarAdvertisements->isNotEmpty())
                                @include('partials.advertisement-placement', ['advertisements' => $articleSidebarAdvertisements])
                            @endif
                        </div>
                    @else
                        <img src="{{ asset('image/forest-campaign-728x90.png') }}" alt="वन जोगाऔँ, भविष्य बचाऔँ" class="block h-auto w-full object-cover">
                    @endif
                </aside>
            </div>

            <section class="mt-16 border-t border-neutral-200 pt-10">
                <h2 class="mb-6 text-2xl font-bold text-neutral-950">सम्बन्धित समाचार</h2>
                <div class="grid gap-6 md:grid-cols-3">
                    @foreach($related as $item)
                        <article class="overflow-hidden border border-neutral-200 bg-white">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="h-48 w-full object-cover">
                            <div class="p-5">
                                <span class="text-xs font-semibold text-red-700">{{ $item['category'] }}</span>
                                <a href="{{ route('news.show', $item['slug']) }}" class="mt-3 block text-xl font-bold leading-snug text-neutral-900 transition hover:text-red-700">{{ $item['title'] }}</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
@endsection
