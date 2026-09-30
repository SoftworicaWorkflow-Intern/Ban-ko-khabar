{{--
    Articles admin section.

    Layout: page header (rendered by admin/page) → stat cards → New Article
    composer (collapsed) → single white container holding the toolbar, the
    filter / column drawers, the data table and the pagination footer.
--}}
@php
    $statusStyles = [
        'published' => 'bg-green-50 text-green-700',
        'draft' => 'bg-slate-100 text-slate-500',
        'pending' => 'bg-amber-50 text-amber-700',
    ];

    $queryState = array_filter([
        'search' => $filters['search'] ?? '',
        'category_id' => $filters['category_id'] ?? '',
        'status' => $filters['status'] ?? '',
        'author' => $filters['author'] ?? '',
        'sort' => $sortKey,
        'dir' => $sortDirection,
        'per_page' => $perPage,
    ], fn ($value) => $value !== '' && $value !== null);

    $keepQuery = fn (array $overrides = []) => request()->fullUrlWithQuery(array_merge($queryState, $overrides, ['page' => null]));

    $headerFilters = [
        'category' => array_merge(
            [[
                'label' => 'All categories',
                'url' => $keepQuery(['category_id' => '']),
                'active' => ($filters['category_id'] ?? '') === '',
            ]],
            collect($categories)->map(fn ($category) => [
                'label' => $category->name,
                'url' => $keepQuery(['category_id' => $category->id]),
                'active' => (string) ($filters['category_id'] ?? '') === (string) $category->id,
            ])->all(),
        ),
        'author' => array_merge(
            [[
                'label' => 'All authors',
                'url' => $keepQuery(['author' => '']),
                'active' => ($filters['author'] ?? '') === '',
            ]],
            $authors->map(fn ($author) => [
                'label' => $author,
                'url' => $keepQuery(['author' => $author]),
                'active' => ($filters['author'] ?? '') === $author,
            ])->all(),
        ),
        'status' => collect(['published', 'draft', 'pending'])
            ->map(fn ($status) => [
                'label' => ucfirst($status),
                'url' => $keepQuery(['status' => $status]),
                'active' => ($filters['status'] ?? '') === $status,
            ])
            ->prepend([
                'label' => 'All statuses',
                'url' => $keepQuery(['status' => '']),
                'active' => ($filters['status'] ?? '') === '',
            ])
            ->all(),
    ];

    $pageWindow = collect(range(1, max(1, $items->lastPage())))
        ->filter(fn ($page) => $page === 1 || $page === $items->lastPage() || abs($page - $items->currentPage()) <= 2)
        ->values()
        ->all();
@endphp

{{-- ============================ NEW ARTICLE COMPOSER ============================ --}}
<div id="articleComposer" class="mt-6 hidden rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-3">
        <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">New article</div>
        <button type="button" onclick="toggleArticleComposer()" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50">Close</button>
    </div>

    <form method="POST" action="{{ route('admin.articles.store') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div>
                <label class="text-sm font-medium text-slate-700">Title</label>
                <input class="form-input" type="text" name="title" required>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Slug</label>
                <input class="form-input" type="text" name="slug" required>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Category</label>
                <select class="form-input" name="category_id">
                    <option value="">Uncategorized</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Author</label>
                <input class="form-input" type="text" name="author" value="{{ $userName ?? 'Admin User' }}">
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Publish / Draft status</label>
                <select class="form-input" name="status">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Image URL</label>
                <input class="form-input" type="url" name="image_url">
            </div>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <label class="text-sm font-medium text-slate-700">Excerpt</label>
                <textarea class="form-input" name="excerpt" rows="2"></textarea>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Content</label>
                <textarea class="form-input" name="content" rows="4"></textarea>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-4">
            <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                <input type="hidden" name="featured" value="0">
                <input type="checkbox" name="featured" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                Featured article (show on homepage)
            </label>
            <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#214d35]">Save article</button>
        </div>
    </form>
</div>

{{-- ============================ MAIN CONTAINER ============================ --}}
<div class="mt-6 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]">

    {{-- Toolbar --}}
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">All articles</span>
            <span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#173b27]">{{ number_format($items->total()) }} total</span>
            @if ($activeFilters)
                <span class="rounded-full bg-[#fff7e6] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-amber-700">Filters applied</span>
            @endif
        </div>

        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('admin.articles') }}">
                @if (($filters['category_id'] ?? '') !== '')
                    <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}">
                @endif
                @if (($filters['status'] ?? '') !== '')
                    <input type="hidden" name="status" value="{{ $filters['status'] }}">
                @endif
                @if (($filters['author'] ?? '') !== '')
                    <input type="hidden" name="author" value="{{ $filters['author'] }}">
                @endif
                @if ($sortKey !== '')
                    <input type="hidden" name="sort" value="{{ $sortKey }}">
                    <input type="hidden" name="dir" value="{{ $sortDirection }}">
                @endif
                @if ($perPage !== 10)
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                @endif

                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/>
                    </svg>
                    <input type="search"
                           name="search"
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Search"
                           aria-label="Search articles"
                           class="h-10 w-44 rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:bg-white focus:ring-2 focus:ring-emerald-100 sm:w-56">
                </div>
            </form>
            @if ($activeFilters)
                <a href="{{ route('admin.articles') }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Reset</a>
            @endif
        </div>
    </div>

    {{-- Data table. The min-height keeps the header filter dropdowns inside the
         scroll box when a filter leaves only a row or two. --}}

    <div class="min-h-[380px] overflow-x-auto">
        <table class="w-full min-w-[960px] border-collapse text-left">
            <thead>
                <tr class="border-b border-slate-200 bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                    <th scope="col" class="w-12 px-5 py-3.5">
                        <input type="checkbox"
                               onclick="toggleAllArticles(this)"
                               aria-label="Select all articles"
                               class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    </th>
                    <th scope="col" class="w-14 px-3 py-3.5">S.N.</th>
                    <th scope="col" data-column="thumbnail" class="w-20 px-3 py-3.5">Thumbnail</th>

                    @include('admin.partials.sortable-th', ['label' => 'Title', 'column' => 'title'])
                    @include('admin.partials.sortable-th', ['label' => 'Category', 'column' => 'category', 'dropdownItems' => $headerFilters['category']])
                    @include('admin.partials.sortable-th', ['label' => 'Author', 'column' => 'author', 'dropdownItems' => $headerFilters['author']])
                    @include('admin.partials.sortable-th', ['label' => 'Status', 'column' => 'status', 'dropdownItems' => $headerFilters['status']])
                    @include('admin.partials.sortable-th', ['label' => 'Read Time', 'column' => 'read_time'])
                    @include('admin.partials.sortable-th', ['label' => 'Views', 'column' => 'views'])

                    <th scope="col" class="px-3 py-3.5">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm">
                @forelse ($items as $index => $item)
                    @php
                        $articleId = is_object($item) ? ($item->id ?? 0) : ($item['id'] ?? 0);
                        $articleTitle = is_object($item) ? ($item->title ?? $item->name ?? 'Untitled') : ($item['title'] ?? $item['name'] ?? 'Untitled');
                        $articleSlug = is_object($item) ? ($item->slug ?? '') : ($item['slug'] ?? '');
                        $articleImage = is_object($item) ? ($item->image_url ?? '') : ($item['image_url'] ?? '');
                        $articleMeta = is_object($item) ? ($item->category->name ?? $item->category ?? 'Uncategorized') : ($item['category'] ?? $item['category_name'] ?? 'Uncategorized');
                        $articleAuthor = is_object($item) ? ($item->author ?? '') : ($item['author'] ?? '');
                        $articleStatus = is_object($item) ? ($item->status ?? 'published') : ($item['status'] ?? 'published');
                        $articleFeatured = (bool) (is_object($item) ? ($item->featured ?? false) : ($item['featured'] ?? false));
                        $articleCategoryId = is_object($item) ? ($item->category_id ?? '') : ($item['category_id'] ?? '');
                        $articleExcerpt = is_object($item) ? ($item->excerpt ?? '') : ($item['excerpt'] ?? '');
                        $articleContent = is_object($item) ? ($item->content ?? '') : ($item['content'] ?? '');
                        $articleViews = is_object($item) ? ($item->views ?? 0) : ($item['views'] ?? 0);
                        $articleDate = is_object($item) ? ($item->created_at?->format('M d, Y') ?? '') : ($item['date'] ?? '');
                        $articleReadTime = is_object($item) && method_exists($item, 'readTime') ? $item->readTime() : '१ मिनेट';
                        $serialNumber = ($items->firstItem() ?? 1) + $index;
                    @endphp

                    <tr class="align-middle transition hover:bg-[#f8fafc]">
                        <td class="px-5 py-3">
                            <input type="checkbox"
                                   name="article_ids[]"
                                   value="{{ $articleId }}"
                                   aria-label="Select {{ $articleTitle }}"
                                   class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        </td>

                        <td class="px-3 py-3 text-sm tabular-nums text-slate-500">{{ $serialNumber }}</td>

                        <td data-column="thumbnail" class="px-3 py-3">
                            <div class="relative flex h-10 w-10 items-center justify-center overflow-hidden rounded-lg bg-slate-100 ring-1 ring-slate-200">
                                <span class="text-sm font-bold text-slate-400">{{ mb_strtoupper(mb_substr($articleTitle, 0, 1)) }}</span>
                                @if ($articleImage)
                                    <img src="{{ $articleImage }}"
                                         alt=""
                                         loading="lazy"
                                         class="absolute inset-0 h-10 w-10 object-cover"
                                         onerror="this.remove()">
                                @endif
                            </div>
                        </td>

                        <td class="px-3 py-3">
                            <div class="max-w-[260px] truncate text-sm font-semibold text-[#1b2433]">{{ $articleTitle }}</div>
                            <div class="mt-0.5 max-w-[260px] truncate text-xs text-slate-400">/news/{{ $articleSlug }}</div>
                        </td>

                        <td class="px-3 py-3">
                            <span class="inline-flex whitespace-nowrap rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">{{ $articleMeta }}</span>
                        </td>

                        <td data-column="author" class="whitespace-nowrap px-3 py-3 text-sm text-slate-600">{{ $articleAuthor !== '' ? $articleAuthor : '—' }}</td>

                        <td class="px-3 py-3">
                            <span class="inline-flex whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusStyles[$articleStatus] ?? $statusStyles['published'] }}">{{ ucfirst($articleStatus) }}</span>
                        </td>

                        <td data-column="read_time" class="whitespace-nowrap px-3 py-3 text-sm text-slate-600">{{ $articleReadTime }}</td>

                        <td data-column="views" class="whitespace-nowrap px-3 py-3 text-sm tabular-nums text-slate-600">{{ number_format((int) $articleViews) }}</td>

                        <td class="px-3 py-3">
                            <div class="flex flex-wrap items-center gap-1">
                                <button type="button"
                                    onclick="openArticleViewModal(this)"
                                    data-article-title="{{ $articleTitle }}"
                                    data-article-excerpt="{{ $articleExcerpt }}"
                                    data-article-content="{{ $articleContent }}"
                                    data-article-author="{{ $articleAuthor }}"
                                    data-article-category="{{ $articleMeta }}"
                                    data-article-status="{{ ucfirst($articleStatus) }}"
                                    data-article-date="{{ $articleDate }}"
                                    data-article-views="{{ number_format((int) $articleViews) }}"
                                    data-article-read-time="{{ $articleReadTime }}"
                                        data-article-url="{{ route('news.show', $articleSlug) }}"
                                        class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-semibold text-[#1E4FA3] transition hover:bg-[#eef5ff]">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    View
                                </button>

                                <a href="{{ route('admin.articles.edit', $articleId) }}"
                                        class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-semibold text-[#1E4FA3] transition hover:bg-[#eef5ff]">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                    </svg>
                                    Edit
                                </a>

                                <button type="button"
                                    onclick="openDeleteModal(this.dataset.deleteUrl, this.dataset.deleteName)"
                                    data-delete-url="{{ route('admin.articles.delete', $articleId) }}"
                                    data-delete-name="{{ $articleTitle }}"
                                        class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Preview drawer --}}
                    <tr id="article-view-{{ $articleId }}" class="hidden bg-[#f8fafc]">
                        <td colspan="10" class="px-5 py-4">
                            <div class="max-w-3xl">
                                <div class="text-sm font-semibold text-[#1b2433]">{{ $articleTitle }}</div>
                                <p class="mt-1.5 text-sm leading-relaxed text-[#51657c]">{{ $articleExcerpt !== '' ? $articleExcerpt : 'No excerpt yet.' }}</p>
                                @if ($articleContent !== '')
                                    <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-500">{{ $articleContent }}</p>
                                @endif
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                                    <span>By {{ $articleAuthor !== '' ? $articleAuthor : 'Unknown author' }}</span>
                                    <span>{{ $articleMeta }}</span>
                                    <span>{{ $articleDate }}</span>
                                    <span>{{ number_format((int) $articleViews) }} views</span>
                                    <span>{{ $articleReadTime }}</span>
                                    @if ($articleFeatured)
                                        <span class="font-semibold text-amber-600">Featured</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Edit drawer --}}
                    <tr id="article-edit-{{ $articleId }}" class="hidden bg-[#f8fafc]">
                        <td colspan="10" class="px-5 py-4">
                            <form method="POST" action="{{ route('admin.articles.update', $articleId) }}" class="space-y-4">
                                @csrf
                                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Title</label>
                                        <input class="form-input" type="text" name="title" value="{{ $articleTitle }}" required>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Slug</label>
                                        <input class="form-input" type="text" name="slug" value="{{ $articleSlug }}" required>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Category</label>
                                        <select class="form-input" name="category_id">
                                            <option value="">Uncategorized</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected((string) $articleCategoryId === (string) $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Author</label>
                                        <input class="form-input" type="text" name="author" value="{{ $articleAuthor }}">
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Publish / Draft status</label>
                                        <select class="form-input" name="status">
                                            <option value="published" @selected($articleStatus === 'published')>Published</option>
                                            <option value="draft" @selected($articleStatus === 'draft')>Draft</option>
                                            <option value="pending" @selected($articleStatus === 'pending')>Pending</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Image URL</label>
                                        <input class="form-input" type="url" name="image_url" value="{{ $articleImage }}">
                                    </div>
                                </div>

                                <div class="grid gap-4 lg:grid-cols-2">
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Excerpt</label>
                                        <textarea class="form-input" name="excerpt" rows="2">{{ $articleExcerpt }}</textarea>
                                    </div>
                                    <div>
                                        <label class="text-sm font-medium text-slate-700">Content</label>
                                        <textarea class="form-input" name="content" rows="4">{{ $articleContent }}</textarea>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-4">
                                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                        <input type="hidden" name="featured" value="0">
                                        <input type="checkbox" name="featured" value="1" @checked($articleFeatured) class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        Featured article (show on homepage)
                                    </label>
                                    <div class="flex gap-2">
                                        <button type="submit" class="rounded-xl bg-[#173b27] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#214d35]">Save changes</button>
                                        <button type="button" onclick="toggleArticleRow('edit', {{ $articleId }})" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-5 py-12">
                            <div class="mx-auto max-w-md rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-6 text-center text-sm text-slate-500">
                                @if ($activeFilters)
                                    No articles match your filters.
                                @else
                                    No articles yet.
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center border-t border-slate-100 px-5 py-4">
        <div class="text-sm text-slate-500 text-left">
            @if ($items->total() > 0)
                Showing {{ number_format($items->firstItem()) }} to {{ number_format($items->lastItem()) }} of {{ number_format($items->total()) }} results
            @else
                Showing 0 results
            @endif
        </div>

        <div class="flex items-center justify-center">
            <form method="GET" action="{{ route('admin.articles') }}" class="flex items-center gap-2">
                @if (($filters['search'] ?? '') !== '')
                    <input type="hidden" name="search" value="{{ $filters['search'] }}">
                @endif
                @if (($filters['category_id'] ?? '') !== '')
                    <input type="hidden" name="category_id" value="{{ $filters['category_id'] }}">
                @endif
                @if (($filters['status'] ?? '') !== '')
                    <input type="hidden" name="status" value="{{ $filters['status'] }}">
                @endif
                @if (($filters['author'] ?? '') !== '')
                    <input type="hidden" name="author" value="{{ $filters['author'] }}">
                @endif
                @if ($sortKey !== '')
                    <input type="hidden" name="sort" value="{{ $sortKey }}">
                    <input type="hidden" name="dir" value="{{ $sortDirection }}">
                @endif

                <label for="articlePerPage" class="whitespace-nowrap text-sm text-slate-500">Per page</label>
                <select id="articlePerPage"
                        name="per_page"
                        onchange="this.form.submit()"
                        class="h-9 rounded-lg border border-slate-200 bg-white px-2.5 text-sm font-semibold text-slate-600 outline-none transition hover:border-emerald-600 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @foreach ([10, 25, 50, 100] as $pageSize)
                        <option value="{{ $pageSize }}" @selected($perPage === $pageSize)>{{ $pageSize }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="flex items-center justify-end">
            <nav class="flex items-center gap-1" aria-label="Articles pagination">
                @if ($items->currentPage() > 1)
                    <a href="{{ $items->previousPageUrl() }}"
                       rel="prev"
                       aria-label="Previous page"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </a>
                @else
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300" aria-hidden="true">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </span>
                @endif

                @foreach ($pageWindow as $position => $page)
                    @if ($position > 0 && $page - $pageWindow[$position - 1] > 1)
                        <span class="px-1 text-sm text-slate-400" aria-hidden="true">…</span>
                    @endif

                    @if ($page === $items->currentPage())
                        <span aria-current="page" class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#173b27] px-2 text-sm font-semibold text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $items->url($page) }}"
                           class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-slate-200 px-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-600 hover:text-emerald-700">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($items->hasMorePages())
                    <a href="{{ $items->nextPageUrl() }}"
                       rel="next"
                       aria-label="Next page"
                       class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                    </a>
                @else
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300" aria-hidden="true">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                    </span>
                @endif
            </nav>
        </div>
    </div>
</div>

<script>
    function toggleArticleComposer() {
        const panel = document.getElementById('articleComposer');
        if (!panel) return;
        panel.classList.toggle('hidden');
        if (panel.classList.contains('hidden')) return;
        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
        const first = panel.querySelector('input[name="title"]');
        if (first) first.focus();
    }

    function toggleArticleRow(kind, id) {
        const row = document.getElementById('article-' + kind + '-' + id);
        if (!row) return;
        const willOpen = row.classList.contains('hidden');
        document.querySelectorAll('[id^="article-' + kind + '-"]').forEach((other) => {
            if (other !== row) other.classList.add('hidden');
        });
        row.classList.toggle('hidden', !willOpen);
    }

    function toggleAllArticles(source) {
        document.querySelectorAll('tbody input[name="article_ids[]"]').forEach((box) => {
            box.checked = source.checked;
        });
    }

</script>
