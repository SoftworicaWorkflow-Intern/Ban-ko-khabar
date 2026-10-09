@php
    $advertisements = $items ?? collect();
    $currentPage = $advertisements->currentPage();
    $totalPages = max(1, $advertisements->lastPage());
    $perPage = (int) ($perPage ?? 10);
    $editingAdvertisement = $editingAdvertisement ?? null;
    $isEditingAdvertisement = $editingAdvertisement !== null;
    $isAdvertisementFormOpen = request()->boolean('create') || $isEditingAdvertisement;
    $activeValue = old('active', $isEditingAdvertisement ? (int) $editingAdvertisement->active : 1);
@endphp

<div id="advertisementCreateForm" class="{{ $isAdvertisementFormOpen ? '' : 'hidden' }}">
    <form id="advertisementForm" method="POST" action="{{ $isEditingAdvertisement ? route('admin.advertisements.update', $editingAdvertisement) : route('admin.advertisements.store') }}" enctype="multipart/form-data">
        @csrf
    <div class="mb-6 space-y-5">
        <div>
            <nav class="mb-2 flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">
                <span>Advertisements</span>
                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m9 18 6-6-6-6"/>
                </svg>
                <span class="text-slate-700">{{ $isEditingAdvertisement ? 'Edit' : 'Create' }}</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">{{ $isEditingAdvertisement ? 'Edit Advertisement' : 'Create Advertisement' }}</h1>
            <p class="mt-2 text-sm text-slate-500">Pick a slot, drop in the artwork at the fixed size, then set when it should fly.</p>
        </div>

        <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
            <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50 text-red-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/>
                        <path d="M8 6h8"/>
                        <path d="M7 6h10l-1 11a3 3 0 0 1-3 3h-2a3 3 0 0 1-3-3L7 6Z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Pick the stage</h2>
                    <p class="text-sm text-slate-500">Choose where this banner sits on <a href="https://freefall.net/" target="_blank" class="text-red-600 underline">freefall.net</a>. The map on the right signs up the slot.</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    <label class="mb-3 block text-sm font-medium text-slate-700">Slot <span class="text-red-500">*</span></label>
                    <div class="space-y-3">
                        <label data-stage-option="header" class="flex cursor-pointer items-center gap-3 rounded-xl border border-red-200 bg-red-50 p-3 text-sm font-medium text-red-600 shadow-sm">
                            <input type="radio" name="position" value="header" @checked(old('position', $editingAdvertisement?->position ?? 'header') === 'header') required class="h-4 w-4 border-red-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-red-200 bg-white text-red-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="7" width="18" height="10" rx="1.5"/>
                                        <path d="M7 17V7M17 17V7"/>
                                    </svg>
                                </span>
                                <span>Header center - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="article-top" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="article-top" @checked(old('position', $editingAdvertisement?->position) === 'article-top') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14"/>
                                        <path d="M5 12h10"/>
                                        <rect x="4" y="4" width="16" height="16" rx="1.5"/>
                                    </svg>
                                </span>
                                <span>Top of article - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="article-center" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="article-center" @checked(old('position', $editingAdvertisement?->position) === 'article-center') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14"/>
                                        <path d="M5 12h14"/>
                                        <rect x="4" y="4" width="16" height="16" rx="1.5"/>
                                    </svg>
                                </span>
                                <span>Center of article - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="article-bottom" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="article-bottom" @checked(old('position', $editingAdvertisement?->position) === 'article-bottom') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14"/>
                                        <path d="M5 12h14"/>
                                        <path d="M5 16h10"/>
                                        <rect x="4" y="4" width="16" height="16" rx="1.5"/>
                                    </svg>
                                </span>
                                <span>Bottom of article - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="latest-bottom" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="latest-bottom" @checked(old('position', $editingAdvertisement?->position) === 'latest-bottom') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14M5 12h14M5 16h14"/>
                                        <path d="M8 19h8"/>
                                    </svg>
                                </span>
                                <span>Bottom of Latest - before Categories - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="categories-bottom" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="categories-bottom" @checked(old('position', $editingAdvertisement?->position) === 'categories-bottom') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14M5 12h14M5 16h14"/>
                                        <path d="M8 19h8"/>
                                    </svg>
                                </span>
                                <span>Between categories and trending - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="trending-bottom" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="trending-bottom" @checked(old('position', $editingAdvertisement?->position) === 'trending-bottom') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M5 8h14M5 12h14M5 16h14"/>
                                        <path d="M8 19h8"/>
                                    </svg>
                                </span>
                                <span>Bottom of trending - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="sidebar" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="sidebar" @checked(old('position', $editingAdvertisement?->position) === 'sidebar') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="4" y="6" width="16" height="12" rx="1.5"/>
                                        <path d="M9 18V6M15 18V6"/>
                                    </svg>
                                </span>
                                <span>Right sidebar - 300 x 250</span>
                            </span>
                        </label>
                        <label data-stage-option="footer" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="footer" @checked(old('position', $editingAdvertisement?->position) === 'footer') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <rect x="3" y="7" width="18" height="10" rx="1.5"/>
                                        <path d="M7 17V7M17 17V7"/>
                                    </svg>
                                </span>
                                <span>Footer - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="insights-top" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="insights-top" @checked(old('position', $editingAdvertisement?->position) === 'insights-top') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 19h16M6 16V8m4 8V5m4 11v-6m4 6V3"/>
                                    </svg>
                                </span>
                                <span>Top of insights - 728 x 90</span>
                            </span>
                        </label>
                        <label data-stage-option="insights-bottom" class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 bg-white p-3 text-sm font-medium text-slate-700 hover:border-slate-300">
                            <input type="radio" name="position" value="insights-bottom" @checked(old('position', $editingAdvertisement?->position) === 'insights-bottom') class="h-4 w-4 border-slate-300 text-red-600 focus:ring-red-500">
                            <span class="flex items-center gap-3">
                                <span class="flex h-5 w-5 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                        <path d="M4 19h16M6 16V8m4 8V5m4 11v-6m4 6V3"/>
                                    </svg>
                                </span>
                                <span>Between insights and gallery - 728 x 90</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div class="rounded-[18px] border border-slate-200 bg-slate-50 p-4">
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Live page map</div>
                            <p class="mt-1 text-xs text-slate-500">This creative fills a 728 x 90 px box.</p>
                        </div>
                    </div>

                    <div class="rounded-[18px] border-2 border-[#173b27] bg-white p-3 shadow-inner">
                        <div class="space-y-3">
                            <div data-stage-preview="header" class="rounded-md border-2 border-red-500 bg-red-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-red-600">Header 728x90</div>
                            <div data-stage-preview="article-top" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article top 728x90</div>
                            <div data-stage-preview="article-center" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article center 728x90</div>
                            <div data-stage-preview="article-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article bottom 728x90</div>
                            <div data-stage-preview="latest-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Latest bottom 728x90</div>
                            <div data-stage-preview="categories-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Categories to trending 728x90</div>
                            <div data-stage-preview="trending-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Trending bottom 728x90</div>
                        </div>

                        <div class="mt-3 flex gap-3">
                            <div class="flex-1"></div>
                            <div data-stage-preview="sidebar" class="w-[110px] rounded-md border border-dashed border-slate-300 bg-slate-50 px-2 py-8 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Sidebar 300x250</div>
                        </div>

                        <div data-stage-preview="footer" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Footer 728x90</div>
                        <div data-stage-preview="insights-top" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Insights 728x90</div>
                        <div data-stage-preview="insights-bottom" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Insights to gallery 728x90</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
            <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M17 3a2.8 2.8 0 1 1 4 4L7.5 20.5 3 22l1.5-4.5Z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Craft the creative</h2>
                    <p class="text-sm text-slate-500">Tailor the asset, destination, and live state.</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Campaign name <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $editingAdvertisement?->title) }}" required placeholder="e.g. Dashain festival header" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100">
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Banner artwork <span class="text-red-500">*</span></label>
                    <div id="advertisementDropzone" class="relative rounded-[18px] border-2 border-dashed border-slate-300 bg-slate-50 p-5 text-center transition hover:border-red-300 hover:bg-red-50/40">
                        <input id="advertisement-artwork" type="file" name="banner" accept="image/png,image/jpeg" @required(! $isEditingAdvertisement) class="sr-only" aria-describedby="advertisement-artwork-help">
                        <label for="advertisement-artwork" class="flex cursor-pointer flex-col items-center justify-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white text-slate-400 shadow-sm ring-1 ring-slate-200">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M12 16V4"/>
                                    <path d="m7 9 5-5 5 5"/>
                                    <path d="M20 16.5A2.5 2.5 0 0 1 17.5 19H6.5A2.5 2.5 0 0 1 4 16.5V15"/>
                                </svg>
                            </div>
                            <div class="text-sm font-medium text-slate-600">
                                Drag &amp; Drop your files or <span class="text-red-600">Browse</span>
                            </div>
                            <span id="advertisement-artwork-name" class="hidden text-xs font-medium text-slate-600"></span>
                        </label>
                        @if ($isEditingAdvertisement)
                            <img src="{{ asset('storage/'.$editingAdvertisement->banner_path) }}" alt="Current banner: {{ $editingAdvertisement->title }}" class="mx-auto mt-4 max-h-24 max-w-full object-contain">
                            <p class="mt-2 text-xs text-slate-500">Choose a new file only if you want to replace this banner.</p>
                        @endif
                    </div>
                    <div class="mt-3 flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">728 x 90 px</span>
                        <p id="advertisement-artwork-help" class="text-xs text-slate-500">Sits in the header between the logo and social icons. Replaces the date. Multiple banners rotate every 3 seconds. Use a PNG or JPG under 1MB.</p>
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Click-through URL</label>
                    <div class="relative">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M10 13a5 5 0 0 0 7.07 0l2.83-2.83a5 5 0 1 0-7.07-7.07L10.1 4.6"/>
                                <path d="M14 11a5 5 0 0 0-7.07 0L4.1 13.83a5 5 0 1 0 7.07 7.07L13.9 19.4"/>
                            </svg>
                        </span>
                        <input type="url" name="click_url" value="{{ old('click_url', $editingAdvertisement?->click_url) }}" placeholder="https://" class="block h-11 w-full min-w-0 rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100">
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                    <div>
                        <div class="text-sm font-medium text-slate-700">On air</div>
                        <div class="text-xs text-slate-500">Turn off to keep this campaign drafted.</div>
                    </div>
                    <input id="advertisementActiveInput" type="hidden" name="active" value="{{ (string) $activeValue === '1' ? '1' : '0' }}">
                    <button type="button" aria-label="Toggle ad on-air status" aria-pressed="{{ (string) $activeValue === '1' ? 'true' : 'false' }}" data-on-air-toggle class="relative inline-flex h-7 w-12 shrink-0 items-center rounded-full p-1 transition {{ (string) $activeValue === '1' ? 'bg-emerald-600' : 'bg-slate-300' }}" style="width: 3rem; height: 1.75rem">
                        <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition {{ (string) $activeValue === '1' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                    </button>
                </div>
            </div>
        </section>

        <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
            <div class="mb-5 flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-800">Review in this position</h2>
                    <p class="text-sm text-slate-500">Preview how the asset sits in the chosen space.</p>
                </div>
            </div>

            <div>
                <div class="mb-3 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">Review in this position</div>
                <div class="rounded-[18px] border-2 border-[#173b27] bg-white p-4 shadow-inner">
                    <div class="space-y-3">
                        <div data-review-preview="header" class="rounded-md border-2 border-red-500 bg-red-50 px-3 py-4 text-center text-[11px] font-semibold uppercase tracking-[0.12em] text-red-600">Header 728x90</div>
                        <div data-review-preview="article-top" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article top 728x90</div>
                        <div data-review-preview="article-center" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article center 728x90</div>
                        <div data-review-preview="article-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Article bottom 728x90</div>
                        <div data-review-preview="latest-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Latest bottom 728x90</div>
                        <div data-review-preview="categories-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Categories to trending 728x90</div>
                        <div data-review-preview="trending-bottom" class="rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Trending bottom 728x90</div>
                    </div>
                    <div class="mt-3 flex gap-3">
                        <div class="flex-1"></div>
                        <div data-review-preview="sidebar" class="w-[120px] rounded-md border border-dashed border-slate-300 bg-slate-50 px-2 py-10 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Sidebar 300x250</div>
                    </div>
                    <div data-review-preview="footer" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Footer 728x90</div>
                    <div data-review-preview="insights-top" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Insights 728x90</div>
                    <div data-review-preview="insights-bottom" class="mt-3 rounded-md border border-dashed border-slate-300 bg-slate-50 px-3 py-3 text-center text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500">Insights to gallery 728x90</div>
                </div>
            </div>
        </section>

        <section class="rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
            <button type="button" class="flex w-full items-center justify-between gap-3 px-5 py-4 text-left" aria-expanded="false" aria-controls="advertisementFlightFields" data-toggle-flight-window>
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-slate-800">Flight window</div>
                        <div class="text-sm text-slate-500">The banner shows only while it is on air and inside this window. Leave a date empty for no limit.</div>
                    </div>
                </div>
                <svg class="h-5 w-5 text-slate-400 transition-transform duration-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>
            <div id="advertisementFlightFields" class="hidden grid gap-4 border-t border-slate-100 px-5 py-4 sm:grid-cols-2">
                <div>
                    <label for="advertisement-starts-at" class="mb-2 block text-sm font-medium text-slate-700">Starts At</label>
                    <input id="advertisement-starts-at" name="starts_at" value="{{ old('starts_at', $editingAdvertisement?->starts_at?->format('Y-m-d\\TH:i')) }}" type="datetime-local" class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-700 outline-none transition focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100">
                    <p class="mt-1.5 text-xs text-slate-500">Empty = start immediately.</p>
                </div>
                <div>
                    <label for="advertisement-ends-at" class="mb-2 block text-sm font-medium text-slate-700">Ends At</label>
                    <input id="advertisement-ends-at" name="ends_at" value="{{ old('ends_at', $editingAdvertisement?->ends_at?->format('Y-m-d\\TH:i')) }}" type="datetime-local" class="block h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm text-slate-700 outline-none transition focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100">
                    <p class="mt-1.5 text-xs text-slate-500">Empty = keep running.</p>
                </div>
            </div>
        </section>

        <div class="flex flex-wrap items-center justify-start gap-3 pt-2">
            <button type="submit" name="save_behavior" value="create" class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-600/20 transition hover:bg-red-700">{{ $isEditingAdvertisement ? 'Save changes' : 'Create' }}</button>
            @unless ($isEditingAdvertisement)
                <button type="submit" name="save_behavior" value="another" class="rounded-xl border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">Save &amp; create another</button>
            @endunless
            <button type="button" onclick="window.location.href = '{{ route('admin.advertisements') }}'" class="rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">Cancel</button>
        </div>
    </div>
    </form>
</div>

<div id="advertisementListPanel" class="mt-6 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)] {{ $isAdvertisementFormOpen ? 'hidden' : '' }}">
    <div class="flex flex-wrap items-center justify-end gap-3 border-b border-slate-100 px-5 py-4">
        <form method="GET" action="{{ route('admin.advertisements') }}" class="relative">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="7"/>
                <path d="m20 20-3.6-3.6"/>
            </svg>
            <input type="search"
                   name="search"
                   value="{{ request('search', '') }}"
                   placeholder="Search"
                   aria-label="Search advertisements"
                   class="h-10 w-44 rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100 sm:w-56">
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[980px] border-collapse text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                    <th scope="col" class="w-12 px-5 py-3.5">
                        <input type="checkbox" aria-label="Select all advertisements" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                    </th>
                    <th scope="col" class="px-3 py-3.5">Banner</th>
                    <th scope="col" class="px-3 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <span>Position</span>
                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m8 9 4-4 4 4"/>
                                <path d="m16 15-4 4-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-3 py-3.5">Active</th>
                    <th scope="col" class="px-3 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <span>Starts at</span>
                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m8 9 4-4 4 4"/>
                                <path d="m16 15-4 4-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-3 py-3.5">
                        <div class="flex items-center gap-1.5">
                            <span>Ends at</span>
                            <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="m8 9 4-4 4 4"/>
                                <path d="m16 15-4 4-4-4"/>
                            </svg>
                        </div>
                    </th>
                    <th scope="col" class="px-3 py-3.5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($advertisements as $advertisement)
                    <tr class="align-middle transition hover:bg-[#f8fafc]">
                        <td class="px-5 py-3">
                            <input type="checkbox" aria-label="Select {{ $advertisement['title'] ?? 'Advertisement' }}" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                        </td>
                        <td class="px-3 py-3">
                            <div class="flex h-14 w-28 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                <img src="{{ $advertisement['banner'] }}" alt="{{ $advertisement['title'] ?? 'Advertisement banner' }}" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="px-3 py-3">
                            <div class="font-semibold text-slate-800">{{ $advertisement['position'] }}</div>
                        </td>
                        <td class="px-3 py-3">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $advertisement['active'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $advertisement['active'] ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-slate-600">{{ $advertisement['starts_at'] }}</td>
                        <td class="px-3 py-3 text-slate-600">{{ $advertisement['ends_at'] }}</td>
                        <td class="px-3 py-3 text-right">
                            <div class="relative inline-block">
                                <button type="button" class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-500 transition hover:border-slate-300 hover:text-slate-700" data-target="advertisement-menu-{{ $advertisement['id'] }}" aria-controls="advertisement-menu-{{ $advertisement['id'] }}" aria-expanded="false" aria-label="Open actions for {{ $advertisement['title'] ?? 'Advertisement' }}">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <circle cx="12" cy="5" r="1.6"/>
                                        <circle cx="12" cy="12" r="1.6"/>
                                        <circle cx="12" cy="19" r="1.6"/>
                                    </svg>
                                </button>
                                <div id="advertisement-menu-{{ $advertisement['id'] }}" class="action-menu fixed z-[9999] hidden w-44 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-lg">
                                    <button type="button" data-view-advertisement="{{ $advertisement['id'] }}" data-advertisement-title="{{ $advertisement['title'] }}" data-advertisement-position="{{ $advertisement['position'] }}" data-advertisement-banner="{{ $advertisement['banner'] }}" data-advertisement-active="{{ $advertisement['active'] ? 'Active' : 'Inactive' }}" data-advertisement-start="{{ $advertisement['starts_at'] }}" data-advertisement-end="{{ $advertisement['ends_at'] }}" data-advertisement-click-url="{{ $advertisement['click_url'] ?? '' }}" class="flex w-full items-center gap-2 border-b border-slate-100 px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-50">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                        View
                                    </button>
                                    <a href="{{ route('admin.advertisements', ['edit' => $advertisement['id']]) }}" class="flex w-full items-center gap-2 border-b border-slate-100 px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-50">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.advertisements.status', $advertisement['id']) }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 border-b border-slate-100 px-3 py-2 text-left text-sm text-slate-700 transition hover:bg-slate-50">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M18 6 6 18"/>
                                            <path d="m6 6 12 12"/>
                                        </svg>
                                        {{ $advertisement['active'] ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.advertisements.delete', $advertisement['id']) }}" onsubmit="return confirm('Delete this advertisement?')">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-3 py-2 text-left text-sm text-red-600 transition hover:bg-red-50">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6"/>
                                            <path d="M14 11v6"/>
                                        </svg>
                                        Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-10 text-center text-sm text-slate-500">No advertisements found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col items-center justify-center gap-4 border-t border-slate-100 bg-white px-5 py-4">
        <nav class="flex items-center gap-2 text-sm text-slate-600" aria-label="Pagination navigation">
            <button type="button" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-medium text-slate-500 transition hover:bg-slate-50" {{ $currentPage <= 1 ? 'disabled' : '' }}>
                Previous
            </button>

            @for ($page = 1; $page <= $totalPages; $page++)
                <button type="button" class="h-8 min-w-8 rounded-lg px-2 {{ $page === $currentPage ? 'bg-red-600 text-white' : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                    {{ $page }}
                </button>
            @endfor

            <button type="button" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 font-medium text-slate-500 transition hover:bg-slate-50" {{ $currentPage >= $totalPages ? 'disabled' : '' }}>
                Next
            </button>
        </nav>

        <div class="flex items-center justify-center gap-2 text-sm text-slate-600">
            <span class="font-medium">Per page</span>
            <form method="GET" action="{{ route('admin.advertisements') }}" class="inline-flex items-center">
                <select name="per_page" onchange="this.form.submit()" class="rounded-lg border border-slate-200 bg-slate-50 px-2 py-1.5 text-sm font-medium text-slate-700 outline-none transition focus:border-red-600 focus:bg-white">
                    @foreach ([10, 25, 50, 100] as $pageSize)
                        <option value="{{ $pageSize }}" @selected((int) request('per_page', 10) === $pageSize)>{{ $pageSize }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
</div>

<div id="advertisementViewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 p-4" role="dialog" aria-modal="true" aria-labelledby="advertisementViewTitle">
    <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
            <h2 id="advertisementViewTitle" class="text-lg font-semibold text-slate-900">Advertisement details</h2>
            <button type="button" data-close-advertisement-view aria-label="Close advertisement details" class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-800">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m18 6-12 12M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4 p-5">
            <img id="advertisementViewBanner" src="" alt="" class="max-h-72 w-full rounded-lg bg-slate-50 object-contain">
            <dl class="grid gap-3 text-sm sm:grid-cols-2">
                <div><dt class="text-slate-500">Campaign</dt><dd id="advertisementViewCampaign" class="mt-1 font-medium text-slate-900"></dd></div>
                <div><dt class="text-slate-500">Position</dt><dd id="advertisementViewPosition" class="mt-1 font-medium text-slate-900"></dd></div>
                <div><dt class="text-slate-500">Status</dt><dd id="advertisementViewStatus" class="mt-1 font-medium text-slate-900"></dd></div>
                <div><dt class="text-slate-500">Flight</dt><dd id="advertisementViewFlight" class="mt-1 font-medium text-slate-900"></dd></div>
                <div class="sm:col-span-2"><dt class="text-slate-500">Click-through URL</dt><dd id="advertisementViewUrl" class="mt-1 break-all font-medium text-slate-900"></dd></div>
            </dl>
        </div>
    </div>
</div>

<script>
    function toggleAdvertisementCreateForm() {
        const form = document.getElementById('advertisementCreateForm');
        const list = document.getElementById('advertisementListPanel');
        const header = document.getElementById('advertisementHeaderBlock');
        if (!form || !list) return;

        const isHidden = form.classList.contains('hidden');
        form.classList.toggle('hidden', !isHidden);
        list.classList.toggle('hidden', isHidden);
        const url = new URL(window.location.href);
        if (isHidden) {
            url.searchParams.set('create', '1');
        } else {
            url.searchParams.delete('create');
        }
        window.history.replaceState({}, '', url);
        if (header) {
            header.classList.toggle('hidden', isHidden);
        }
    }

    document.querySelectorAll('.action-trigger').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.stopPropagation();
            const targetId = button.getAttribute('data-target');
            const menu = document.getElementById(targetId);
            if (!menu) return;

            document.querySelectorAll('.action-menu').forEach((menuItem) => {
                if (menuItem !== menu) {
                    menuItem.classList.add('hidden');
                    document.querySelector(`.action-trigger[data-target="${menuItem.id}"]`)?.setAttribute('aria-expanded', 'false');
                }
            });

            const isOpen = !menu.classList.contains('hidden');
            button.setAttribute('aria-expanded', String(!isOpen));
            menu.classList.add('hidden');

            if (!isOpen) {
                document.body.append(menu);
                menu.classList.remove('hidden');

                const triggerRect = button.getBoundingClientRect();
                const menuRect = menu.getBoundingClientRect();
                const top = triggerRect.bottom + menuRect.height + 8 > window.innerHeight
                    ? triggerRect.top - menuRect.height - 8
                    : triggerRect.bottom + 8;
                const left = Math.max(8, Math.min(triggerRect.right - menuRect.width, window.innerWidth - menuRect.width - 8));

                menu.style.top = `${Math.max(8, top)}px`;
                menu.style.left = `${left}px`;
            }
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.action-menu').forEach((menu) => menu.classList.add('hidden'));
        document.querySelectorAll('.action-trigger[aria-expanded="true"]').forEach((button) => button.setAttribute('aria-expanded', 'false'));
    });

    const advertisementViewModal = document.getElementById('advertisementViewModal');
    document.querySelectorAll('[data-view-advertisement]').forEach((button) => {
        button.addEventListener('click', () => {
            document.getElementById('advertisementViewBanner').src = button.dataset.advertisementBanner;
            document.getElementById('advertisementViewBanner').alt = button.dataset.advertisementTitle;
            document.getElementById('advertisementViewCampaign').textContent = button.dataset.advertisementTitle;
            document.getElementById('advertisementViewPosition').textContent = button.dataset.advertisementPosition;
            document.getElementById('advertisementViewStatus').textContent = button.dataset.advertisementActive;
            document.getElementById('advertisementViewFlight').textContent = `${button.dataset.advertisementStart} - ${button.dataset.advertisementEnd}`;
            document.getElementById('advertisementViewUrl').textContent = button.dataset.advertisementClickUrl || 'Not set';
            advertisementViewModal.classList.remove('hidden');
            advertisementViewModal.classList.add('flex');
        });
    });

    document.querySelectorAll('[data-close-advertisement-view]').forEach((button) => {
        button.addEventListener('click', () => {
            advertisementViewModal.classList.add('hidden');
            advertisementViewModal.classList.remove('flex');
        });
    });

    advertisementViewModal?.addEventListener('click', (event) => {
        if (event.target === advertisementViewModal) {
            advertisementViewModal.classList.add('hidden');
            advertisementViewModal.classList.remove('flex');
        }
    });

    document.querySelectorAll('[data-toggle-flight-window]').forEach((button) => {
        button.addEventListener('click', () => {
            const fields = document.getElementById(button.getAttribute('aria-controls'));
            const chevron = button.querySelector('svg:last-of-type');
            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!isExpanded));
            if (fields) {
                fields.classList.toggle('hidden', isExpanded);
            }
            if (chevron) {
                chevron.classList.toggle('rotate-180', !isExpanded);
            }
        });
    });

    const stageClassNames = {
        selected: ['border-red-200', 'bg-red-50', 'text-red-600', 'shadow-sm'],
        unselected: ['border-slate-200', 'bg-white', 'text-slate-700'],
    };

    function updateAdvertisementStage(selectedStage) {
        document.querySelectorAll('[data-stage-option]').forEach((option) => {
            const isSelected = option.dataset.stageOption === selectedStage;
            option.classList.remove(...stageClassNames.selected, ...stageClassNames.unselected);
            option.classList.add(...(isSelected ? stageClassNames.selected : stageClassNames.unselected));
        });

        document.querySelectorAll('[data-stage-preview], [data-review-preview]').forEach((preview) => {
            const isSelected = preview.dataset.stagePreview === selectedStage || preview.dataset.reviewPreview === selectedStage;
            preview.classList.toggle('border-red-500', isSelected);
            preview.classList.toggle('border-2', isSelected);
            preview.classList.toggle('bg-red-50', isSelected);
            preview.classList.toggle('text-red-600', isSelected);
            preview.classList.toggle('border-dashed', !isSelected);
            preview.classList.toggle('border-slate-300', !isSelected);
            preview.classList.toggle('bg-slate-50', !isSelected);
            preview.classList.toggle('text-slate-500', !isSelected);
        });
    }

    document.querySelectorAll('input[name="position"]').forEach((radio) => {
        radio.addEventListener('change', () => updateAdvertisementStage(radio.value));
    });
    updateAdvertisementStage(document.querySelector('input[name="position"]:checked')?.value ?? 'header');

    const artworkInput = document.getElementById('advertisement-artwork');
    const artworkName = document.getElementById('advertisement-artwork-name');
    const artworkDropzone = document.getElementById('advertisementDropzone');

    function showSelectedArtwork(file) {
        if (!file || !artworkName) return;

        if (!['image/png', 'image/jpeg'].includes(file.type) || file.size > 1024 * 1024) {
            artworkInput.value = '';
            artworkName.textContent = 'Choose a PNG or JPG file under 1MB.';
            artworkName.classList.remove('hidden', 'text-slate-600');
            artworkName.classList.add('text-red-600');
            return;
        }

        artworkName.textContent = file.name;
        artworkName.classList.remove('hidden', 'text-red-600');
        artworkName.classList.add('text-slate-600');
    }

    if (artworkInput) {
        artworkInput.addEventListener('change', () => showSelectedArtwork(artworkInput.files[0]));
    }

    if (artworkDropzone && artworkInput) {
        ['dragenter', 'dragover'].forEach((eventName) => {
            artworkDropzone.addEventListener(eventName, (event) => {
                event.preventDefault();
                artworkDropzone.classList.add('border-red-400', 'bg-red-50');
            });
        });

        ['dragleave', 'drop'].forEach((eventName) => {
            artworkDropzone.addEventListener(eventName, (event) => {
                event.preventDefault();
                artworkDropzone.classList.remove('border-red-400', 'bg-red-50');
            });
        });

        artworkDropzone.addEventListener('drop', (event) => {
            const [file] = event.dataTransfer.files;
            if (!file) return;

            const transfer = new DataTransfer();
            transfer.items.add(file);
            artworkInput.files = transfer.files;
            showSelectedArtwork(file);
        });
    }

    document.querySelectorAll('[data-on-air-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const isOnAir = toggle.getAttribute('aria-pressed') === 'true';
            toggle.setAttribute('aria-pressed', String(!isOnAir));
            toggle.classList.toggle('bg-emerald-600', !isOnAir);
            toggle.classList.toggle('bg-slate-300', isOnAir);
            const activeInput = document.getElementById('advertisementActiveInput');
            if (activeInput) {
                activeInput.value = isOnAir ? '0' : '1';
            }
            toggle.querySelector('span')?.classList.toggle('translate-x-5', !isOnAir);
            toggle.querySelector('span')?.classList.toggle('translate-x-0', isOnAir);
        });
    });
</script>
