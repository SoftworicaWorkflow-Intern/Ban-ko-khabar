@extends('layouts.app')

@section('title', $pageTitle . ' | Admin')

@section('content')
    <style>
        body { background: #edf3f7; }
        header, footer { display: none !important; }
        .dashboard-shell { height: 100vh; width: 100%; overflow: hidden; }
        .sidebar-item.active {
            background: rgba(255,255,255,0.14);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.12);
        }
        #adminSidebar.is-collapsed {
            width: 82px;
        }
        #adminSidebar.is-collapsed .sidebar-label,
        #adminSidebar.is-collapsed .sidebar-brand-text,
        #adminSidebar.is-collapsed .sidebar-footer-widget {
            display: none;
        }
        #adminSidebar.is-collapsed .sidebar-item {
            justify-content: center;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .stat-card {
            border: 1px solid rgba(15, 40, 77, 0.06);
        }
    </style>

    <section class="dashboard-shell w-full">
        <div class="relative flex h-full overflow-hidden bg-[#edf4f8] shadow-[0_28px_80px_rgba(11,30,52,0.14)] ring-1 ring-[#dfeaf2]">
            @include('admin.partials.sidebar')

            <div class="flex min-h-0 min-w-0 flex-1 flex-col">
                @include('admin.partials.topbanner')

                <main class="min-h-0 flex-1 overflow-y-auto bg-[#f3f7fb] p-4 sm:p-6 lg:p-8 transition-all duration-300">
                    @include('admin.partials.navbar')

                @if (session('success'))
                    <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm font-medium text-emerald-800">
                        <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-emerald-600 text-[10px] font-bold text-white">✓</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm font-medium text-red-700">
                        <div class="mb-1.5 text-[11px] font-semibold uppercase tracking-[0.18em]">Could not save</div>
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <span class="inline-flex rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#173b27]">Admin section</span>
                    <h1 class="mt-3 text-4xl font-black tracking-tight text-[#1b2433]">{{ $pageTitle }}</h1>
                    <p class="mt-2 text-sm text-[#51657c]">{{ $subtitle }}</p>
                </div>

                @if (!empty($stats))
                    <div class="grid gap-4 md:grid-cols-3">
                        @foreach ($stats as $stat)
                            <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">{{ is_object($stat) ? ($stat->label ?? '') : ($stat['label'] ?? '') }}</div>
                                <div class="mt-4 text-4xl font-black text-[#173b27]">{{ is_object($stat) ? ($stat->value ?? '') : ($stat['value'] ?? '') }}</div>
                                <div class="mt-3 text-xs font-medium text-[#55705d]">{{ is_object($stat) ? ($stat->meta ?? '') : ($stat['meta'] ?? '') }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($pageType === 'articles')
                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)] lg:col-span-2">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Search &amp; filter articles</div>
                                @if ($activeFilters)
                                    <span class="rounded-full bg-[#fff7e6] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-amber-700">Filters applied</span>
                                @endif
                            </div>

                            <form method="GET" action="{{ route('admin.articles') }}">
                                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-[minmax(0,1.3fr)_minmax(0,1fr)_minmax(0,1.2fr)_auto] lg:items-end">
                                    <div>
                                        <label class="text-[11px] font-semibold uppercase tracking-[0.06em] text-[#51657c]">Search articles</label>
                                        <input class="form-input" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Title, slug or author">
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-semibold uppercase tracking-[0.06em] text-[#51657c]">Filter by category</label>
                                        <select class="form-input" name="category_id">
                                            <option value="">All categories</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" @selected((string) ($filters['category_id'] ?? '') === (string) $category->id)>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-semibold uppercase tracking-[0.06em] text-[#51657c]">Publish / draft status</label>
                                        <select class="form-input" name="status">
                                            <option value="">All statuses</option>
                                            <option value="published" @selected(($filters['status'] ?? '') === 'published')>Published</option>
                                            <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>Draft</option>
                                            <option value="pending" @selected(($filters['status'] ?? '') === 'pending')>Pending</option>
                                        </select>
                                    </div>
                                    <div class="flex items-end gap-2">
                                        <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Apply filters</button>
                                        @if ($activeFilters)
                                            <a href="{{ route('admin.articles') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Latest articles</div>
                                <div class="flex items-center gap-2">
                                    <span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#173b27]">{{ $items->total() }} total</span>
                                    <span class="rounded-full bg-[#eef5ff] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#0f2b54]">Live</span>
                                </div>
                            </div>

                            <div class="space-y-3">
                                @forelse ($items as $item)
                                    @php
                                        $articleId = is_object($item) ? ($item->id ?? 0) : ($item['id'] ?? 0);
                                        $articleTitle = is_object($item) ? ($item->title ?? $item->name ?? 'Untitled') : ($item['title'] ?? $item['name'] ?? 'Untitled');
                                        $articleSlug = is_object($item) ? ($item->slug ?? '') : ($item['slug'] ?? '');
                                        $articleMeta = is_object($item) ? ($item->category->name ?? $item->category ?? 'Uncategorized') : ($item['category'] ?? $item['category_name'] ?? 'Uncategorized');
                                        $articleStatus = is_object($item) ? ($item->status ?? 'published') : ($item['status'] ?? 'published');
                                        $articleFeatured = (bool) (is_object($item) ? ($item->featured ?? false) : ($item['featured'] ?? false));
                                        $articleCategoryId = is_object($item) ? ($item->category_id ?? '') : ($item['category_id'] ?? '');
                                        $articleDate = is_object($item) ? ($item->created_at?->format('M d, Y') ?? '') : ($item['published_at'] ?? $item['date'] ?? '');
                                        $statusColors = [
                                            'published' => 'bg-[#eaf7ea] text-[#173b27]',
                                            'draft' => 'bg-slate-100 text-slate-500',
                                            'pending' => 'bg-amber-50 text-amber-700',
                                        ];
                                        $statusColor = $statusColors[$articleStatus] ?? $statusColors['published'];
                                    @endphp
                                    <div class="rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <div class="min-w-0">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="text-base font-semibold text-[#173b27]">{{ $articleTitle }}</span>
                                                    @if ($articleFeatured)
                                                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.14em] text-amber-700">Featured</span>
                                                    @endif
                                                </div>
                                                <div class="mt-1 text-sm text-[#51657c]">{{ $articleMeta }} · {{ $articleDate }}</div>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColor }}">{{ ucfirst($articleStatus) }}</span>
                                                <form method="POST" action="{{ route('admin.articles.status', $articleId) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-[#eef5ff] px-3 py-1 text-xs font-semibold text-[#1E4FA3] hover:bg-[#dce9ff]">{{ $articleStatus === 'published' ? 'Move to draft' : 'Publish' }}</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.articles.featured', $articleId) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-full {{ $articleFeatured ? 'bg-amber-100 text-amber-700' : 'bg-[#fff7e6] text-amber-600' }} px-3 py-1 text-xs font-semibold hover:bg-amber-100">{{ $articleFeatured ? 'Unfeature' : 'Feature' }}</button>
                                                </form>
                                                <button type="button"
                                                        class="rounded-full bg-[#eef5ff] px-3 py-1 text-xs font-semibold text-[#0f2b54] hover:bg-[#dce9ff]"
                                                        onclick="document.getElementById('article-edit-{{ $articleId }}').classList.toggle('hidden')">Edit</button>
                                                <form method="POST" action="{{ route('admin.articles.delete', $articleId) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600 hover:bg-red-100">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <form id="article-edit-{{ $articleId }}" method="POST" action="{{ route('admin.articles.update', $articleId) }}" class="mt-4 hidden space-y-4 border-t border-[#edf2f6] pt-4">
                                            @csrf
                                            <div class="grid gap-4 sm:grid-cols-2">
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
                                                    <input class="form-input" type="text" name="author" value="{{ is_object($item) ? ($item->author ?? '') : ($item['author'] ?? '') }}">
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
                                                    <input class="form-input" type="url" name="image_url" value="{{ is_object($item) ? ($item->image_url ?? '') : ($item['image_url'] ?? '') }}">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-slate-700">Excerpt</label>
                                                <textarea class="form-input" name="excerpt" rows="2">{{ is_object($item) ? ($item->excerpt ?? '') : ($item['excerpt'] ?? '') }}</textarea>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-slate-700">Content</label>
                                                <textarea class="form-input" name="content" rows="4">{{ is_object($item) ? ($item->content ?? '') : ($item['content'] ?? '') }}</textarea>
                                            </div>
                                            <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                                <input type="hidden" name="featured" value="0">
                                                <input type="checkbox" name="featured" value="1" @checked($articleFeatured)>
                                                Featured article (show on homepage)
                                            </label>
                                            <div class="flex gap-2">
                                                <button type="submit" class="flex-1 rounded-xl bg-[#173b27] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Save changes</button>
                                                <button type="button" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50" onclick="document.getElementById('article-edit-{{ $articleId }}').classList.add('hidden')">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">
                                        @if ($activeFilters)
                                            No articles match your filters.
                                        @else
                                            No articles yet.
                                        @endif
                                    </div>
                                @endforelse
                            </div>
                            @if (method_exists($items, 'links'))
                                <div class="mt-5">{{ $items->links() }}</div>
                            @endif
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Add new article</div>
                            <form method="POST" action="{{ route('admin.articles.store') }}" class="space-y-4">
                                @csrf
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
                                    <label class="text-sm font-medium text-slate-700">Excerpt</label>
                                    <textarea class="form-input" name="excerpt" rows="3"></textarea>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Content</label>
                                    <textarea class="form-input" name="content" rows="4"></textarea>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Image URL</label>
                                    <input class="form-input" type="url" name="image_url">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Publish / Draft status</label>
                                    <select class="form-input" name="status">
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                                <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                    <input type="hidden" name="featured" value="0">
                                    <input type="checkbox" name="featured" value="1">
                                    Featured article (show on homepage)
                                </label>
                                <button type="submit" class="w-full rounded-xl bg-[#173b27] px-4 py-3 text-sm font-semibold text-white hover:bg-[#214d35]">Save article</button>
                            </form>
                        </div>
                    </div>
                @elseif ($pageType === 'categories')
                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Category list</div>
                            <div class="space-y-3">
                                @forelse ($items as $item)
                                    @php
                                        $categoryId = is_object($item) ? ($item->id ?? 0) : ($item['id'] ?? 0);
                                        $categoryName = is_object($item) ? ($item->name ?? 'Untitled') : ($item['name'] ?? 'Untitled');
                                        $categorySlug = is_object($item) ? ($item->slug ?? '') : ($item['slug'] ?? '');
                                        $categoryDescription = is_object($item) ? ($item->description ?? '') : ($item['description'] ?? '');
                                    @endphp
                                    <div class="rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                        <div class="flex items-center justify-between gap-3">
                                            <div>
                                                <div class="text-base font-semibold text-[#173b27]">{{ $categoryName }}</div>
                                                <div class="mt-1 text-sm text-[#51657c]">{{ $categorySlug }} · {{ $categoryDescription ?: 'No description' }}</div>
                                            </div>
                                            <div class="flex shrink-0 items-center gap-2">
                                                <button type="button"
                                                        class="rounded-full bg-[#eef5ff] px-3 py-1 text-xs font-semibold text-[#1E4FA3] hover:bg-[#dce9ff]"
                                                        onclick="document.getElementById('category-edit-{{ $categoryId }}').classList.toggle('hidden')">Edit</button>
                                                <form method="POST" action="{{ route('admin.categories.delete', $categoryId) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600 hover:bg-red-100">Delete</button>
                                                </form>
                                            </div>
                                        </div>

                                        <form id="category-edit-{{ $categoryId }}" method="POST" action="{{ route('admin.categories.update', $categoryId) }}" class="mt-4 hidden space-y-3 border-t border-[#edf2f6] pt-4">
                                            @csrf
                                            <div>
                                                <label class="text-sm font-medium text-slate-700">Name</label>
                                                <input class="form-input" type="text" name="name" value="{{ $categoryName }}" required>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-slate-700">Slug</label>
                                                <input class="form-input" type="text" name="slug" value="{{ $categorySlug }}" required>
                                            </div>
                                            <div>
                                                <label class="text-sm font-medium text-slate-700">Description</label>
                                                <textarea class="form-input" name="description" rows="3">{{ $categoryDescription }}</textarea>
                                            </div>
                                            <div class="flex gap-2">
                                                <button type="submit" class="flex-1 rounded-xl bg-[#173b27] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Save changes</button>
                                                <button type="button" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50" onclick="document.getElementById('category-edit-{{ $categoryId }}').classList.add('hidden')">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No categories yet.</div>
                                @endforelse
                            </div>
                            @if (method_exists($items, 'links'))
                                <div class="mt-5">{{ $items->links() }}</div>
                            @endif
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Add category</div>
                            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Name</label>
                                    <input class="form-input" type="text" name="name" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Slug</label>
                                    <input class="form-input" type="text" name="slug" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Description</label>
                                    <textarea class="form-input" name="description" rows="4"></textarea>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-[#173b27] px-4 py-3 text-sm font-semibold text-white hover:bg-[#214d35]">Save category</button>
                            </form>
                        </div>
                    </div>
                @elseif ($pageType === 'gallery')
                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Filter media</div>
                            @if ($activeFilters)
                                <span class="rounded-full bg-[#fff7e6] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-amber-700">Filters applied</span>
                            @endif
                        </div>

                        <form method="GET" action="{{ route('admin.gallery') }}">
                            <div class="flex flex-wrap items-end justify-between gap-4">
                                <div class="w-full sm:w-72">
                                    <label class="text-[11px] font-semibold uppercase tracking-[0.06em] text-[#51657c]" for="media-type">Filter by type</label>
                                    <select class="form-input" id="media-type" name="type">
                                        <option value="">All types</option>
                                        @foreach ($mediaTypes as $mediaTypeOption)
                                            <option value="{{ $mediaTypeOption }}" @selected($typeFilter === $mediaTypeOption)>{{ ucfirst($mediaTypeOption) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex items-end gap-2">
                                    <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Apply filter</button>
                                    @if ($activeFilters)
                                        <a href="{{ route('admin.gallery') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6 grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Media library</div>
                                <span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#173b27]">{{ $items->total() }}{{ $activeFilters ? ' of ' . $mediaTotal : '' }} shown</span>
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                @forelse ($items as $item)
                                    @php
                                        $photoId = is_object($item) ? ($item->id ?? 0) : ($item['id'] ?? 0);
                                        $photoTitle = is_object($item) ? ($item->title ?? 'Untitled') : ($item['title'] ?? 'Untitled');
                                        $photoUrl = is_object($item) ? ($item->image_url ?? '') : ($item['image_url'] ?? $item['image'] ?? '');
                                        $photoMeta = is_object($item) ? ($item->category->name ?? 'Uncategorized') : ($item['category'] ?? 'Uncategorized');
                                        $photoType = (is_object($item) ? ($item->media_type ?? 'image') : ($item['media_type'] ?? 'image')) ?: 'image';
                                    @endphp
                                    <div class="overflow-hidden rounded-[18px] border border-[#edf2f6] bg-[#f7fafc]">
                                        <button type="button"
                                                class="group relative block h-36 w-full overflow-hidden bg-slate-100 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600"
                                                title="Preview media"
                                                data-preview-url="{{ $photoUrl }}"
                                                data-preview-type="{{ $photoType }}"
                                                data-preview-title="{{ $photoTitle }}"
                                                onclick="openMediaPreview(this)">
                                            @if ($photoUrl && $photoType === 'image')
                                                <span class="absolute inset-0 flex flex-col items-center justify-center gap-1 text-slate-400" aria-hidden="true">
                                                    <span class="text-2xl">🖼</span>
                                                    <span class="text-[10px] font-bold uppercase tracking-[0.18em]">No preview</span>
                                                </span>
                                                <img src="{{ $photoUrl }}" alt="{{ $photoTitle }}"
                                                     class="absolute inset-0 h-full w-full object-cover transition duration-200 group-hover:scale-[1.03]"
                                                     onerror="this.style.display='none'">
                                            @elseif ($photoUrl)
                                                <div class="absolute inset-0 flex flex-col items-center justify-center gap-1 bg-slate-900 text-white">
                                                    <span class="text-lg">{{ $photoType === 'video' ? '▶' : ($photoType === 'audio' ? '♪' : '📄') }}</span>
                                                    <span class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-300">{{ $photoType }}</span>
                                                </div>
                                            @else
                                                <div class="absolute inset-0 flex items-center justify-center text-sm text-slate-400">No media</div>
                                            @endif
                                            <span class="pointer-events-none absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition duration-200 group-hover:bg-black/35 group-hover:opacity-100">
                                                <span class="rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-[#173b27]">Preview</span>
                                            </span>
                                            <span class="pointer-events-none absolute left-2 top-2 rounded-full bg-[#173b27] px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.14em] text-white">{{ $photoType }}</span>
                                        </button>
                                        <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-3">
                                            <div class="min-w-0 grow basis-24">
                                                <div class="truncate text-sm font-semibold text-[#173b27]">{{ $photoTitle }}</div>
                                                <div class="mt-0.5 truncate text-xs text-[#51657c]">{{ $photoMeta }}</div>
                                            </div>
                                            <div class="flex flex-wrap items-center justify-end gap-2">
                                                <button type="button"
                                                        class="rounded-full bg-[#eef5ff] px-3 py-1 text-xs font-semibold text-[#1E4FA3] hover:bg-[#dce9ff]"
                                                        data-preview-url="{{ $photoUrl }}"
                                                        data-preview-type="{{ $photoType }}"
                                                        data-preview-title="{{ $photoTitle }}"
                                                        onclick="openMediaPreview(this)">Preview</button>
                                                <form method="POST" action="{{ route('admin.gallery.delete', $photoId) }}">
                                                    @csrf
                                                    <button type="submit" class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600 hover:bg-red-100">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500 sm:col-span-2">
                                        {{ $activeFilters ? 'No media matches this filter.' : 'No media yet — upload your first file.' }}
                                    </div>
                                @endforelse
                            </div>
                            @if (method_exists($items, 'links'))
                                <div class="mt-5">{{ $items->links() }}</div>
                            @endif
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Upload media</div>
                            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Media file</label>
                                    <input class="form-input" type="file" name="media" accept="image/*,video/*,audio/*,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.csv,.zip">
                                    <p class="mt-2 text-xs leading-relaxed text-[#51657c]">Image, video, audio or document — up to 20 MB.</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">…or media URL</label>
                                    <input class="form-input" type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/photo.jpg">
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Title</label>
                                    <input class="form-input" type="text" name="title" value="{{ old('title') }}" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Slug</label>
                                    <input class="form-input" type="text" name="slug" value="{{ old('slug') }}" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Category</label>
                                    <select class="form-input" name="category_id">
                                        <option value="">Uncategorized</option>
                                        @foreach (App\Models\Category::all() as $category)
                                            <option value="{{ $category->id }}" @selected((string) old('category_id', '') === (string) $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Status</label>
                                    <select class="form-input" name="status">
                                        @foreach (['published', 'draft', 'pending'] as $statusOption)
                                            <option value="{{ $statusOption }}" @selected(old('status', 'published') === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-[#173b27] px-4 py-3 text-sm font-semibold text-white hover:bg-[#214d35]">Upload media</button>
                            </form>
                        </div>
                    </div>

                    <div id="mediaPreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4 sm:p-8" onclick="closeMediaPreview()">
                        <div class="flex max-h-full w-full max-w-4xl flex-col overflow-hidden rounded-[20px] bg-white shadow-2xl" onclick="event.stopPropagation()">
                            <div class="flex items-center justify-between gap-3 border-b border-[#edf2f6] px-5 py-4">
                                <div id="mediaPreviewTitle" class="min-w-0 truncate text-sm font-semibold text-[#173b27]">Media preview</div>
                                <button type="button" onclick="closeMediaPreview()" class="shrink-0 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-200">Close</button>
                            </div>
                            <div class="overflow-auto p-5">
                                <div id="mediaPreviewStage" class="flex min-h-[120px] items-center justify-center"></div>
                                <p id="mediaPreviewUrl" class="mt-3 break-all text-xs text-[#51657c]"></p>
                            </div>
                        </div>
                    </div>

                    <script>
                        (function () {
                            function isSafeUrl(url) {
                                return /^(https?:)?\/\//i.test(url) || url.charAt(0) === '/';
                            }

                            window.openMediaPreview = function (trigger) {
                                var url = trigger.getAttribute('data-preview-url') || '';
                                var type = trigger.getAttribute('data-preview-type') || 'image';
                                var title = trigger.getAttribute('data-preview-title') || '';

                                if (!url || !isSafeUrl(url)) {
                                    return;
                                }

                                var stage = document.getElementById('mediaPreviewStage');
                                stage.textContent = '';

                                var media;
                                if (type === 'video') {
                                    media = document.createElement('video');
                                    media.setAttribute('controls', '');
                                    media.setAttribute('playsinline', '');
                                    media.className = 'max-h-[60vh] w-full rounded-xl bg-black';
                                } else if (type === 'audio') {
                                    media = document.createElement('div');
                                    media.className = 'w-full rounded-xl bg-slate-50 p-6';
                                    var audio = document.createElement('audio');
                                    audio.setAttribute('controls', '');
                                    audio.className = 'w-full';
                                    audio.src = url;
                                    media.appendChild(audio);
                                    stage.appendChild(media);
                                    document.getElementById('mediaPreviewUrl').textContent = url;
                                    document.getElementById('mediaPreviewTitle').textContent = title || 'Media preview';
                                    document.getElementById('mediaPreviewModal').style.display = 'flex';
                                    return;
                                } else if (type === 'document') {
                                    media = document.createElement('iframe');
                                    media.setAttribute('title', title || 'Document preview');
                                    media.className = 'h-[60vh] w-full rounded-xl border-0 bg-slate-100';
                                } else {
                                    media = document.createElement('img');
                                    media.alt = title;
                                    media.className = 'max-h-[60vh] w-auto rounded-xl';
                                }

                                media.src = url;
                                stage.appendChild(media);

                                document.getElementById('mediaPreviewUrl').textContent = url;
                                document.getElementById('mediaPreviewTitle').textContent = title || 'Media preview';
                                document.getElementById('mediaPreviewModal').style.display = 'flex';
                            };

                            window.closeMediaPreview = function () {
                                var modal = document.getElementById('mediaPreviewModal');
                                if (modal) {
                                    modal.style.display = 'none';
                                }
                                var stage = document.getElementById('mediaPreviewStage');
                                if (stage) {
                                    stage.textContent = '';
                                }
                            };

                            document.addEventListener('keydown', function (event) {
                                if (event.key === 'Escape') {
                                    window.closeMediaPreview();
                                }
                            });
                        })();
                    </script>
                @elseif ($pageType === 'users')
                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="mb-4 flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Registered users</div>
                            <span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#173b27]">{{ $items->total() }} total</span>
                        </div>
                        <div class="space-y-3">
                            @forelse ($items as $item)
                                @php
                                    $regName = is_object($item) ? ($item->name ?? 'Unnamed') : ($item['name'] ?? 'Unnamed');
                                    $regEmail = is_object($item) ? ($item->email ?? '') : ($item['email'] ?? '');
                                    $regRole = is_object($item) ? ($item->role ?? 'user') : ($item['role'] ?? 'user');
                                    $regDate = is_object($item) && isset($item->created_at) ? $item->created_at->format('M d, Y') : ($item['created_at'] ?? '—');
                                    $regLogin = is_object($item) && isset($item->last_login_at) ? $item->last_login_at->format('M d, Y, h:i A') : 'No record yet';
                                @endphp
                                <div class="flex flex-wrap items-center justify-between gap-3 rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#173b27] text-xs font-bold text-white">{{ strtoupper(substr($regName, 0, 1)) }}</div>
                                        <div class="min-w-0">
                                            <div class="text-base font-semibold text-[#173b27]">{{ $regName }}</div>
                                            <div class="mt-0.5 truncate text-sm text-[#51657c]">{{ $regEmail }}</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-[#51657c]">
                                        <span class="rounded-full bg-[#eef5ff] px-3 py-1 font-semibold capitalize text-[#0f2b54]">{{ $regRole }}</span>
                                        <span>Joined {{ $regDate }}</span>
                                        <span class="text-slate-400">Last login: {{ $regLogin }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No registered users yet.</div>
                            @endforelse
                        </div>
                        @if (method_exists($items, 'links'))
                            <div class="mt-5">{{ $items->links() }}</div>
                        @endif
                    </div>
                @elseif ($pageType === 'reports')
                    <div class="mt-6 rounded-[20px] bg-gradient-to-r from-[#173b27] via-[#1f5d3a] to-[#2f7d4d] p-5 text-white shadow-[0_18px_40px_rgba(23,59,39,0.28)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#edf7ee]">New business growth</div>
                            <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold">This month</span>
                        </div>
                        <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            @foreach ($businessGrowth as $growth)
                                <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/15">
                                    <div class="text-xs font-medium text-[#edf7ee]">{{ $growth['label'] }}</div>
                                    <div class="mt-2 text-3xl font-black leading-none">{{ $growth['value'] }}</div>
                                    <div class="mt-2 text-xs text-[#edf7ee]">{{ $growth['meta'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Report library</div>
                        <div class="space-y-4">
                            @forelse ($items as $item)
                                @php
                                    $reportTitle = is_object($item) ? ($item->title ?? 'Untitled') : ($item['title'] ?? 'Untitled');
                                    $reportMeta = is_object($item) ? ($item->meta ?? '') : ($item['meta'] ?? '');
                                    $reportStatus = is_object($item) ? ($item->status ?? 'Ready') : ($item['status'] ?? 'Ready');
                                @endphp
                                <div class="flex items-center justify-between rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                    <div>
                                        <div class="text-base font-semibold text-[#173b27]">{{ $reportTitle }}</div>
                                        <div class="mt-1 text-sm text-[#51657c]">{{ $reportMeta }}</div>
                                    </div>
                                    <span class="rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold text-[#173b27]">{{ $reportStatus }}</span>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No reports yet.</div>
                            @endforelse
                        </div>
                        @if (method_exists($items, 'links'))
                            <div class="mt-5">{{ $items->links() }}</div>
                        @endif
                    </div>
                @elseif ($pageType === 'settings')
                    <div class="mt-6 grid gap-6 lg:grid-cols-3">
                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Security</div>
                            <form method="POST" action="{{ route('admin.settings.password') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Current password</label>
                                    <input class="form-input" type="password" name="current_password" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">New password</label>
                                    <input class="form-input" type="password" name="password" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Confirm new password</label>
                                    <input class="form-input" type="password" name="password_confirmation" required>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-[#173b27] px-4 py-3 text-sm font-semibold text-white hover:bg-[#214d35]">Update password</button>
                            </form>
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Create admin</div>
                            <form method="POST" action="{{ route('admin.settings.admins') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Name</label>
                                    <input class="form-input" type="text" name="name" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Email</label>
                                    <input class="form-input" type="email" name="email" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Password</label>
                                    <input class="form-input" type="password" name="password" minlength="8" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Confirm password</label>
                                    <input class="form-input" type="password" name="password_confirmation" minlength="8" required>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">Role</label>
                                    <select class="form-input" name="role">
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                        <option value="reporter">Reporter</option>
                                    </select>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-[#173b27] px-4 py-3 text-sm font-semibold text-white hover:bg-[#214d35]">Create account</button>
                            </form>
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Account summary</div>
                            <div class="space-y-4 text-sm text-slate-700">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-slate-500">User</div>
                                    <div class="mt-1 text-base font-semibold text-slate-900">{{ $userName ?? 'Admin User' }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-slate-500">Last login</div>
                                    <div class="mt-1 text-base font-semibold text-slate-900">{{ $lastLogin ?? 'No record yet' }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-slate-500">Last password change</div>
                                    <div class="mt-1 text-base font-semibold text-slate-900">{{ $lastPasswordChanged ?? '2026-09-10 09:12' }}</div>
                                </div>
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-slate-500">Role</div>
                                    <div class="mt-1 text-base font-semibold text-slate-900">Administrator</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Site preferences</div>
                        <div class="space-y-4">
                            @forelse ($items as $item)
                                @php
                                    $settingTitle = is_object($item) ? ($item->title ?? 'Setting') : ($item['title'] ?? 'Setting');
                                    $settingMeta = is_object($item) ? ($item->meta ?? '') : ($item['meta'] ?? '');
                                    $settingStatus = is_object($item) ? ($item->status ?? 'Active') : ($item['status'] ?? 'Active');
                                @endphp
                                <div class="flex items-center justify-between rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                    <div>
                                        <div class="text-base font-semibold text-[#173b27]">{{ $settingTitle }}</div>
                                        <div class="mt-1 text-sm text-[#51657c]">{{ $settingMeta }}</div>
                                    </div>
                                    <span class="rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold text-[#173b27]">{{ $settingStatus }}</span>
                                </div>
                            @empty
                                <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No preferences yet.</div>
                            @endforelse
                        </div>
                        @if (method_exists($items, 'links'))
                            <div class="mt-5">{{ $items->links() }}</div>
                        @endif
                    </div>
                @else
                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                        <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Recent entries</div>
                        <div class="space-y-4">
                            @if (!empty($items) && $items instanceof Traversable)
                                @foreach ($items as $item)
                                    @php
                                        $title = is_object($item) ? ($item->title ?? $item->name ?? 'Untitled') : ($item['title'] ?? $item['name'] ?? 'Untitled');
                                        $meta = is_object($item) ? ($item->meta ?? $item->description ?? '') : ($item['meta'] ?? $item['description'] ?? '');
                                        $status = is_object($item) ? ($item->status ?? 'Active') : ($item['status'] ?? 'Active');
                                    @endphp
                                    <div class="flex items-center justify-between rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                        <div>
                                            <div class="text-base font-semibold text-[#173b27]">{{ $title }}</div>
                                            <div class="mt-1 text-sm text-[#51657c]">{{ $meta }}</div>
                                        </div>
                                        <span class="rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold text-[#173b27]">{{ $status }}</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif
            </main>
            </div>{{-- end flex-col wrapper --}}
        </div>
    </section>
@endsection
