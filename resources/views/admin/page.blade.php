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
        #adminSidebar.is-collapsed .sidebar-footer-widget,
        #adminSidebar.is-collapsed .sidebar-settings-submenu {
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

                @if ($pageType === 'advertisements')
                    <div id="advertisementHeaderBlock" class="{{ request()->boolean('create') || request()->filled('edit') ? 'hidden' : '' }} mb-6 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <nav class="mb-2 flex items-center gap-2 text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-500">
                                <span>Advertisements</span>
                                <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m9 18 6-6-6-6"/>
                                </svg>
                                <span class="text-slate-700">List</span>
                            </nav>
                            <h1 class="text-3xl font-black tracking-tight text-[#1b2433]">Advertisement</h1>
                        </div>

                        <button type="button" onclick="toggleAdvertisementCreateForm()" class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-600/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                <path d="M12 5v14M5 12h14"/>
                            </svg>
                            New Advertisement
                        </button>
                    </div>
                @else
                    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <span class="inline-flex rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-[#173b27]">Admin section</span>
                            <h1 class="mt-3 text-4xl font-black tracking-tight text-[#1b2433]">{{ $pageTitle }}</h1>
                            <p class="mt-2 text-sm text-[#51657c]">{{ $subtitle }}</p>
                        </div>

                        @if ($pageType === 'articles')
                            <button type="button"
                                    onclick="toggleArticleComposer()"
                                    aria-controls="articleComposer"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-600/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                New Article
                            </button>
                        @elseif ($pageType === 'categories')
                            <button type="button"
                                    onclick="document.getElementById('category-create-row').classList.toggle('hidden')"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-600/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                New Category
                            </button>
                        @elseif ($pageType === 'users')
                            <button type="button"
                                    class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-red-600/20 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round">
                                    <path d="M12 5v14M5 12h14"/>
                                </svg>
                                New users
                            </button>
                        @elseif ($pageType === 'gallery')
                            <button type="button"
                                    id="galleryCreateButton"
                                    onclick="toggleGalleryComposer()"
                                    aria-controls="galleryComposer"
                                    aria-expanded="{{ $errors->any() ? 'true' : 'false' }}"
                                    class="inline-flex items-center gap-2 rounded-xl bg-[#173b27] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#214d35] focus:outline-none focus:ring-2 focus:ring-emerald-300">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
                                Create
                            </button>
                        @endif
                    </div>
                @endif

                @if (!empty($stats))
                    <div class="grid gap-4 {{ count($stats) > 2 ? 'sm:grid-cols-2 md:grid-cols-3' : 'grid-cols-2' }}">
                        @foreach ($stats as $stat)
                            <div class="stat-card rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#51657c]">{{ is_object($stat) ? ($stat->label ?? '') : ($stat['label'] ?? '') }}</div>
                                <div class="mt-4 text-4xl font-black text-[#173b27]">{{ is_object($stat) ? ($stat->value ?? '') : ($stat['value'] ?? '') }}</div>
                                <div class="mt-3 text-xs font-medium text-[#55705d]">{{ is_object($stat) ? ($stat->meta ?? '') : ($stat['meta'] ?? '') }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($pageType === 'article-edit')
                    <div class="mt-6 rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)] sm:p-7">
                        <div class="mb-6 flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 pb-4">
                            <div>
                                <h2 class="text-lg font-bold text-[#1b2433]">Edit article</h2>
                                <p class="mt-1 text-sm text-[#51657c]">Changes are saved to this article record.</p>
                            </div>
                            <a href="{{ route('news.show', $article->slug) }}" target="_blank" rel="noopener" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-[#173b27] transition hover:bg-emerald-100">View article</a>
                        </div>
                        <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" class="space-y-5">
                            @csrf
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                <div>
                                    <label for="article-title" class="text-sm font-medium text-slate-700">Title</label>
                                    <input id="article-title" class="form-input" type="text" name="title" value="{{ old('title', $article->title) }}" required>
                                </div>
                                <div>
                                    <label for="article-slug" class="text-sm font-medium text-slate-700">Slug</label>
                                    <input id="article-slug" class="form-input" type="text" name="slug" value="{{ old('slug', $article->slug) }}" required>
                                </div>
                                <div>
                                    <label for="article-category" class="text-sm font-medium text-slate-700">Category</label>
                                    <select id="article-category" class="form-input" name="category_id">
                                        <option value="">Uncategorized</option>
                                        @foreach ($categories as $categoryOption)
                                            <option value="{{ $categoryOption->id }}" @selected((string) old('category_id', $article->category_id) === (string) $categoryOption->id)>{{ $categoryOption->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="article-author" class="text-sm font-medium text-slate-700">Author</label>
                                    <input id="article-author" class="form-input" type="text" name="author" value="{{ old('author', $article->author) }}">
                                </div>
                                <div>
                                    <label for="article-status" class="text-sm font-medium text-slate-700">Status</label>
                                    <select id="article-status" class="form-input" name="status">
                                        @foreach (['published', 'draft', 'pending'] as $statusOption)
                                            <option value="{{ $statusOption }}" @selected(old('status', $article->status) === $statusOption)>{{ ucfirst($statusOption) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="article-image" class="text-sm font-medium text-slate-700">Image URL</label>
                                    <input id="article-image" class="form-input" type="url" name="image_url" value="{{ old('image_url', $article->image_url) }}">
                                </div>
                            </div>
                            <div class="grid gap-4 lg:grid-cols-2">
                                <div>
                                    <label for="article-excerpt" class="text-sm font-medium text-slate-700">Excerpt</label>
                                    <textarea id="article-excerpt" class="form-input" name="excerpt" rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                                </div>
                                <div>
                                    <label for="article-content" class="text-sm font-medium text-slate-700">Content</label>
                                    <textarea id="article-content" class="form-input" name="content" rows="6">{{ old('content', $article->content) }}</textarea>
                                </div>
                            </div>
                            <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                                <input type="hidden" name="featured" value="0">
                                <input type="checkbox" name="featured" value="1" @checked(old('featured', $article->featured)) class="h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600">
                                Feature on homepage
                            </label>
                            <div class="flex flex-wrap justify-end gap-3 border-t border-slate-100 pt-5">
                                <a href="{{ route('admin.articles') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
                                <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#214d35]">Save article</button>
                            </div>
                        </form>
                    </div>
                @elseif ($pageType === 'category-edit')
                    <div class="mt-6 max-w-3xl rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)] sm:p-7">
                        <h2 class="text-lg font-bold text-[#1b2433]">Edit category</h2>
                        <p class="mt-1 text-sm text-[#51657c]">Update the category shown on the news portal.</p>
                        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="mt-6 space-y-4">
                            @csrf
                            <div>
                                <label for="category-name" class="text-sm font-medium text-slate-700">Name</label>
                                <input id="category-name" class="form-input" type="text" name="name" value="{{ old('name', $category->name) }}" required>
                            </div>
                            <div>
                                <label for="category-slug" class="text-sm font-medium text-slate-700">Slug</label>
                                <input id="category-slug" class="form-input" type="text" name="slug" value="{{ old('slug', $category->slug) }}" required>
                            </div>
                            <div>
                                <label for="category-description" class="text-sm font-medium text-slate-700">Description</label>
                                <textarea id="category-description" class="form-input" name="description" rows="5">{{ old('description', $category->description) }}</textarea>
                            </div>
                            <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                                <a href="{{ route('admin.categories') }}" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</a>
                                <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#214d35]">Save category</button>
                            </div>
                        </form>
                    </div>
                @elseif ($pageType === 'articles')
                    @include('admin.partials.articles-panel')
                @elseif ($pageType === 'advertisements')
                    @include('admin.partials.advertisements-panel')
                @elseif ($pageType === 'categories')

                    <div class="mt-6 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
                        {{-- Toolbar --}}
                        <div class="flex flex-wrap items-center justify-end gap-3 border-b border-slate-100 px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/>
                                    </svg>
                                    <input type="search" placeholder="Search" class="h-10 w-44 rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100 sm:w-56">
                                </div>
                            </div>
                        </div>

                        {{-- Data Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[960px] border-collapse text-left">
                                <thead>
                                    <tr class="border-b border-slate-200 bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                                        <th scope="col" class="w-12 px-5 py-3.5">
                                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                        </th>
                                        <th scope="col" class="w-16 px-3 py-3.5">Color</th>
                                        <th scope="col" class="px-3 py-3.5">
                                            <div class="flex items-center gap-1.5 cursor-pointer hover:text-[#173b27]">Category Name <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg></div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5">Slug</th>
                                        <th scope="col" class="px-3 py-3.5">Articles Count</th>
                                        <th scope="col" class="px-3 py-3.5 text-center">Active</th>
                                        <th scope="col" class="px-3 py-3.5">
                                            <div class="flex items-center gap-1.5 cursor-pointer hover:text-[#173b27]">Sort Order <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l4-4 4 4m0 6l-4 4-4-4" /></svg></div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    <tr id="category-create-row" class="hidden">
                                        <td colspan="8" class="p-0 border-b border-slate-100">
                                            <div class="bg-red-50/50 px-5 py-4">
                                                <form method="POST" action="{{ route('admin.categories.store') }}" class="flex flex-wrap items-end gap-4">
                                                    @csrf
                                                    <div class="flex-1 min-w-[200px]">
                                                        <label class="text-xs font-semibold text-slate-700">Name</label>
                                                        <input class="form-input mt-1 block w-full rounded-xl border-slate-200" type="text" name="name" required placeholder="New Category Name">
                                                    </div>
                                                    <div class="flex-1 min-w-[200px]">
                                                        <label class="text-xs font-semibold text-slate-700">Slug</label>
                                                        <input class="form-input mt-1 block w-full rounded-xl border-slate-200" type="text" name="slug" required placeholder="new-category-slug">
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <button type="submit" class="rounded-xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700">Create</button>
                                                        <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50" onclick="document.getElementById('category-create-row').classList.add('hidden')">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @forelse ($items as $cat)
                                    @php
                                        $colors = [
                                            ['class' => 'bg-red-500', 'name' => 'Red'],
                                            ['class' => 'bg-green-500', 'name' => 'Green'],
                                            ['class' => 'bg-white border border-slate-200', 'name' => 'White'],
                                            ['class' => 'bg-blue-500', 'name' => 'Blue'],
                                            ['class' => 'bg-orange-500', 'name' => 'Orange']
                                        ];
                                        $catColor = $colors[$loop->index % count($colors)];
                                        $categoryId = is_object($cat) ? $cat->id : $cat['id'];
                                        $categoryName = is_object($cat) ? $cat->name : $cat['name'];
                                        $categorySlug = is_object($cat) ? $cat->slug : $cat['slug'];
                                        $newsCount = is_object($cat) ? ($cat->news_count ?? 0) : ($cat['news_count'] ?? 0);
                                    @endphp
                                    <tr class="align-middle transition hover:bg-[#f8fafc]">
                                        <td class="px-5 py-3">
                                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <div class="h-4 w-4 rounded-full {{ $catColor['class'] }} shadow-sm"></div>
                                                <span class="text-xs font-medium text-slate-600">{{ $catColor['name'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 font-semibold text-[#1b2433]">{{ $categoryName }}</td>
                                        <td class="px-3 py-3 text-slate-500">{{ $categorySlug }}</td>
                                        <td class="px-3 py-3">
                                            <span class="inline-flex whitespace-nowrap rounded-full bg-red-50 px-2.5 py-1.5 text-xs font-semibold text-red-700">{{ $newsCount }}</span>
                                        </td>
                                        <td class="px-3 py-3">
                                            <div class="flex justify-center">
                                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-green-100 text-green-600">
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-3 py-3 text-slate-600">{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                                        <td class="px-3 py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('admin.categories.edit', $categoryId) }}" class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-semibold text-[#1E4FA3] transition hover:bg-[#eef5ff]">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg> Edit
                                                </a>
                                                <button type="button" onclick="openDeleteModal(this.dataset.deleteUrl, this.dataset.deleteName)" data-delete-url="{{ route('admin.categories.delete', $categoryId) }}" data-delete-name="{{ $categoryName }}" class="inline-flex items-center gap-1 rounded-lg px-2 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50">
                                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg> Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-5 py-8 text-center text-sm text-slate-500">No categories yet.</td>
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
                                <form method="GET" action="{{ route('admin.categories') }}" class="flex items-center gap-2">

                                    <label class="whitespace-nowrap text-sm text-slate-500">Per page</label>
                                    <select name="per_page" onchange="this.form.submit()" class="h-9 rounded-lg border border-slate-200 bg-white px-2.5 text-sm font-semibold text-slate-600 outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                                        @foreach ([10, 25, 50, 100] as $pageSize)
                                            <option value="{{ $pageSize }}" @selected(request('per_page', 10) == $pageSize)>{{ $pageSize }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <div class="flex items-center justify-end">
                                <nav class="flex items-center gap-1" aria-label="Categories pagination">
                                    @if ($items->currentPage() > 1)
                                        <a href="{{ $items->previousPageUrl() }}"
                                           rel="prev"
                                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                        </a>
                                    @else
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                        </span>
                                    @endif

                                    @php
                                        $window = \Illuminate\Pagination\UrlWindow::make($items);
                                        $elements = array_filter([
                                            $window['first'],
                                            is_array($window['slider']) ? '...' : null,
                                            $window['slider'],
                                            is_array($window['last']) ? '...' : null,
                                            $window['last'],
                                        ]);
                                    @endphp
                                    @foreach ($elements as $element)
                                        @if (is_string($element))
                                            <span class="px-1 text-sm text-slate-400">…</span>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $items->currentPage())
                                                    <span class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#173b27] px-2 text-sm font-semibold text-white">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $url }}" class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-slate-200 px-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-600 hover:text-emerald-700">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($items->hasMorePages())
                                        <a href="{{ $items->nextPageUrl() }}"
                                           rel="next"
                                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        </a>
                                    @else
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @elseif ($pageType === 'gallery')
                    @include('admin.partials.gallery-table')
                    @if (false)
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

                    <div class="mt-6 space-y-6">
                        <div id="galleryComposer" class="{{ $errors->any() ? '' : 'hidden' }} max-w-3xl rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
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
                            @include('admin.partials.pagination', ['paginator' => $items, 'ariaLabel' => 'Gallery pagination'])
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
                    @endif
                @elseif ($pageType === 'users')
                    <div class="mt-6 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
                        {{-- Toolbar --}}
                        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Registered users</div>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.6-3.6"/>
                                    </svg>
                                    <input type="search" placeholder="Search" class="h-10 w-44 rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-red-600 focus:bg-white focus:ring-2 focus:ring-red-100 sm:w-56">
                                </div>
                                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-red-600 hover:text-red-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M3 5h18l-7 8v5.5l-4 2V13z"/></svg>
                                </button>
                                <button type="button" class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:border-red-600 hover:text-red-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M9 4v16M15 4v16"/></svg>
                                </button>
                            </div>
                        </div>

                        {{-- Data Table --}}
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[1000px] border-collapse text-left">
                                <thead>
                                    <tr class="border-b border-slate-200 bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                                        <th scope="col" class="w-12 px-5 py-3.5">
                                            <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                        </th>
                                        <th scope="col" class="w-16 px-3 py-3.5">Photo</th>
                                        <th scope="col" class="px-3 py-3.5">
                                            <div class="flex items-center gap-1.5 cursor-pointer hover:text-[#173b27]">Name <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                                        </th>
                                        <th scope="col" class="px-3 py-3.5">Email address</th>
                                        <th scope="col" class="px-3 py-3.5">Role</th>
                                        <th scope="col" class="px-3 py-3.5">Joined</th>
                                        <th scope="col" class="px-3 py-3.5">Last login</th>
                                        <th scope="col" class="px-3 py-3.5 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-sm">
                                    @forelse ($items as $user)
                                        @php
                                            $userName = is_object($user) ? $user->name : ($user['name'] ?? '');
                                            $userEmail = is_object($user) ? $user->email : ($user['email'] ?? '');
                                            $userRole = is_object($user) ? ($user->role ?? 'Reporter') : ($user['role'] ?? 'Reporter');
                                            $userPhoto = 'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=random';
                                        @endphp
                                        <tr class="align-middle transition hover:bg-[#f8fafc]">
                                            <td class="px-5 py-3">
                                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-red-600 focus:ring-red-500">
                                            </td>
                                            <td class="px-3 py-3">
                                                <img src="{{ $userPhoto }}" alt="{{ $userName }}" class="h-9 w-9 rounded-full object-cover shadow-sm">
                                            </td>
                                            <td class="px-3 py-3 font-semibold text-[#1b2433]">{{ $userName }}</td>
                                            <td class="px-3 py-3 text-slate-500">{{ $userEmail }}</td>
                                            <td class="px-3 py-3">
                                                <span class="font-medium text-slate-700">{{ ucfirst($userRole) }}</span>
                                            </td>
                                            <td class="px-3 py-3 text-slate-600">{{ is_object($user) ? ($user->created_at?->format('M d, Y') ?? '—') : '—' }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ is_object($user) ? ($user->last_login_at?->format('M d, Y, h:i A') ?? 'Never') : 'Never' }}</td>
                                            <td class="px-3 py-3 text-right">
                                                <div class="flex items-center justify-end gap-3">
                                                    <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                                        View
                                                    </button>
                                                    <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 hover:text-blue-800">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                                        Edit
                                                    </button>
                                                    <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 hover:text-red-800">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2M10 11v6M14 11v6"/></svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-5 py-8 text-center text-sm text-slate-500">No users yet.</td>
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
                                <form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-2">
                                    <label class="whitespace-nowrap text-sm text-slate-500">Per page</label>
                                    <select name="per_page" onchange="this.form.submit()" class="h-9 rounded-lg border border-slate-200 bg-white px-2.5 text-sm font-semibold text-slate-600 outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                                        @foreach ([10, 25, 50, 100] as $pageSize)
                                            <option value="{{ $pageSize }}" @selected(request('per_page', 10) == $pageSize)>{{ $pageSize }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <div class="flex items-center justify-end">
                                <nav class="flex items-center gap-1" aria-label="Users pagination">
                                    @if ($items->currentPage() > 1)
                                        <a href="{{ $items->previousPageUrl() }}"
                                           rel="prev"
                                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                        </a>
                                    @else
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                        </span>
                                    @endif

                                    @php
                                        $window = \Illuminate\Pagination\UrlWindow::make($items);
                                        $elements = array_filter([
                                            $window['first'],
                                            is_array($window['slider']) ? '...' : null,
                                            $window['slider'],
                                            is_array($window['last']) ? '...' : null,
                                            $window['last'],
                                        ]);
                                    @endphp
                                    @foreach ($elements as $element)
                                        @if (is_string($element))
                                            <span class="px-1 text-sm text-slate-400">…</span>
                                        @endif
                                        @if (is_array($element))
                                            @foreach ($element as $page => $url)
                                                @if ($page == $items->currentPage())
                                                    <span class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#173b27] px-2 text-sm font-semibold text-white">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $url }}" class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-slate-200 px-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-600 hover:text-emerald-700">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    @if ($items->hasMorePages())
                                        <a href="{{ $items->nextPageUrl() }}"
                                           rel="next"
                                           class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        </a>
                                    @else
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        </span>
                                    @endif
                                </nav>
                            </div>
                        </div>
                    </div>
                @elseif ($pageType === 'reports')
                    <div class="mt-6 grid gap-6 xl:grid-cols-[1.45fr_0.75fr]">
                        <section class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]" aria-labelledby="top-stories-title">
                            <div class="border-b border-slate-100 px-5 py-4">
                                <h2 id="top-stories-title" class="text-sm font-semibold text-[#173b27]">Top viewed stories</h2>
                                <p class="mt-1 text-xs text-[#51657c]">Published stories ranked by their recorded view counts</p>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[680px] text-left text-sm">
                                    <thead class="bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                                        <tr>
                                            <th class="px-5 py-3">Story</th>
                                            <th class="px-3 py-3">Category</th>
                                            <th class="px-3 py-3">Author</th>
                                            <th class="px-3 py-3">Published</th>
                                            <th class="px-5 py-3 text-right">Views</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse ($topStories as $story)
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-5 py-3">
                                                    <a href="{{ route('news.show', $story->slug) }}" target="_blank" rel="noopener" class="font-semibold text-slate-800 hover:text-[#2f7d4d]">{{ $story->title }}</a>
                                                </td>
                                                <td class="px-3 py-3 text-slate-600">{{ $story->category?->name ?? 'Uncategorized' }}</td>
                                                <td class="px-3 py-3 text-slate-600">{{ $story->author ?: '—' }}</td>
                                                <td class="whitespace-nowrap px-3 py-3 text-slate-600">{{ $story->created_at?->format('M d, Y') ?? '—' }}</td>
                                                <td class="px-5 py-3 text-right font-semibold tabular-nums text-[#173b27]">{{ number_format((int) $story->views) }}</td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="5" class="px-5 py-8 text-center text-sm text-slate-500">No published stories to report yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <section class="rounded-[20px] border border-slate-200 bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.05)]" aria-labelledby="category-performance-title">
                            <div>
                                <h2 id="category-performance-title" class="text-sm font-semibold text-[#173b27]">Category performance</h2>
                                <p class="mt-1 text-xs text-[#51657c]">Published articles and their stored views</p>
                            </div>
                            <div class="mt-5 space-y-5">
                                @forelse ($topCategories as $category)
                                    @php $categoryViews = (int) $category->published_story_views; @endphp
                                    <div>
                                        <div class="mb-2 flex items-center justify-between gap-3 text-xs">
                                            <span class="truncate font-semibold text-slate-700">{{ $category->name }}</span>
                                            <span class="shrink-0 tabular-nums text-slate-500">{{ number_format($categoryViews) }} views</span>
                                        </div>
                                        <div class="h-2.5 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-[#2f7d4d]" style="width: {{ min(100, (int) round($categoryViews / $maxCategoryViews * 100)) }}%"></div>
                                        </div>
                                        <div class="mt-1 text-[10px] text-slate-400">{{ number_format($category->published_articles) }} published stories</div>
                                    </div>
                                @empty
                                    <div class="rounded-xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-500">No category data to report yet.</div>
                                @endforelse
                            </div>
                        </section>
                    </div>

                    <div class="mt-6 rounded-[20px] bg-gradient-to-r from-[#173b27] via-[#1f5d3a] to-[#2f7d4d] p-5 text-white shadow-[0_18px_40px_rgba(23,59,39,0.28)]">
                        <div class="flex items-center justify-between">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#edf7ee]">Newsroom overview</div>
                                <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold">Database totals</span>
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
                        @include('admin.partials.pagination', ['paginator' => $items, 'ariaLabel' => 'Reports pagination'])
                    </div>
                @elseif ($pageType === 'password')
                    <div class="mt-6 grid gap-6 lg:grid-cols-[minmax(0,2fr)_minmax(260px,1fr)]">
                        <section class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)] sm:p-7">
                            <div class="mb-6 border-b border-slate-100 pb-4">
                                <h2 class="text-lg font-bold text-[#1b2433]">Update password</h2>
                                <p class="mt-1 text-sm text-[#51657c]">Use at least eight characters and keep this password private.</p>
                            </div>
                            <form method="POST" action="{{ route('admin.settings.password.update') }}" class="max-w-xl space-y-4">
                                @csrf
                                <div><label for="current-password" class="text-sm font-medium text-slate-700">Current password</label><input id="current-password" class="form-input" type="password" name="current_password" required></div>
                                <div><label for="new-password" class="text-sm font-medium text-slate-700">New password</label><input id="new-password" class="form-input" type="password" name="password" minlength="8" required></div>
                                <div><label for="confirm-password" class="text-sm font-medium text-slate-700">Confirm new password</label><input id="confirm-password" class="form-input" type="password" name="password_confirmation" minlength="8" required></div>
                                <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Update password</button>
                            </form>
                        </section>
                        <aside class="rounded-[20px] bg-[#173b27] p-5 text-white shadow-[0_10px_22px_rgba(19,41,26,0.12)] sm:p-7">
                            <div class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#b9e2b5]">Account security</div>
                            <div class="mt-4 text-2xl font-black">Password protection</div>
                            <p class="mt-3 text-sm leading-6 text-[#d9edda]">Your password was last changed on {{ $lastPasswordChanged }}.</p>
                        </aside>
                    </div>
                @elseif ($pageType === 'admins')
                    <div class="mt-6 grid gap-6 xl:grid-cols-[minmax(280px,0.8fr)_minmax(0,1.6fr)]">
                        <section class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)] sm:p-7">
                            <div class="mb-6 border-b border-slate-100 pb-4">
                                <h2 class="text-lg font-bold text-[#1b2433]">New team account</h2>
                                <p class="mt-1 text-sm text-[#51657c]">Create an admin, editor, or reporter account.</p>
                            </div>
                            <form method="POST" action="{{ route('admin.settings.admins.store') }}" autocomplete="off" class="space-y-4">
                                @csrf
                                <div><label for="admin-name" class="text-sm font-medium text-slate-700">Name</label><input id="admin-name" class="form-input" type="text" name="name" value="{{ old('name') }}" required></div>
                                <div><label for="admin-email" class="text-sm font-medium text-slate-700">Email</label><input id="admin-email" class="form-input" type="email" name="email" value="{{ old('email') }}" autocomplete="new-username" required></div>
                                <div><label for="admin-password" class="text-sm font-medium text-slate-700">Password</label><input id="admin-password" class="form-input" type="password" name="password" autocomplete="new-password" minlength="8" required></div>
                                <div><label for="admin-password-confirmation" class="text-sm font-medium text-slate-700">Confirm password</label><input id="admin-password-confirmation" class="form-input" type="password" name="password_confirmation" autocomplete="new-password" minlength="8" required></div>
                                <div><label for="admin-role" class="text-sm font-medium text-slate-700">Role</label><select id="admin-role" class="form-input" name="role"><option value="admin">Admin</option><option value="editor">Editor</option><option value="reporter">Reporter</option></select></div>
                                <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Create account</button>
                            </form>
                        </section>
                        <section class="overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]">
                            <div class="border-b border-slate-100 px-5 py-4"><h2 class="text-sm font-semibold text-[#173b27]">Team accounts</h2><p class="mt-1 text-xs text-[#51657c]">Accounts with administrative or editorial access</p></div>
                            <div class="overflow-x-auto"><table class="w-full min-w-[620px] text-left text-sm"><thead class="bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]"><tr><th class="px-5 py-3">Account</th><th class="px-3 py-3">Role</th><th class="px-3 py-3">Created</th><th class="px-3 py-3">Last login</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse ($items as $account)<tr><td class="px-5 py-3"><div class="font-semibold text-slate-800">{{ $account->name }}</div><div class="text-xs text-slate-500">{{ $account->email }}</div></td><td class="px-3 py-3"><span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-xs font-semibold capitalize text-[#173b27]">{{ $account->role }}</span></td><td class="px-3 py-3 text-slate-600">{{ $account->created_at?->format('M d, Y') ?? '—' }}</td><td class="px-3 py-3 text-slate-600">{{ $account->last_login_at?->format('M d, Y, h:i A') ?? 'Never' }}</td></tr>@empty<tr><td colspan="4" class="px-5 py-8 text-center text-sm text-slate-500">No team accounts found.</td></tr>@endforelse</tbody></table></div>
                            @include('admin.partials.pagination', ['paginator' => $items, 'ariaLabel' => 'Team accounts pagination'])
                        </section>
                    </div>
                @elseif ($pageType === 'settings')
                    <div class="mt-6 space-y-4">
                        {{-- Password Change Dropdown --}}
                        <div class="rounded-[20px] bg-white shadow-[0_10px_22px_rgba(19,41,26,0.04)] overflow-hidden">
                            <button type="button" onclick="toggleSettingsPanel('passwordPanel')" class="flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#eaf7ea] text-[#173b27]">
                                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1b2433]">Change Password</div>
                                        <div class="text-xs text-[#51657c]">Update your account password</div>
                                    </div>
                                </div>
                                <svg id="passwordPanelChevron" class="h-5 w-5 text-slate-400 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div id="passwordPanel" class="hidden border-t border-slate-100">
                                <div class="px-5 py-5">
                                    <form method="POST" action="{{ route('admin.settings.password') }}" class="max-w-lg space-y-4">
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
                                        <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Update password</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Create Admin Dropdown --}}
                        <div class="rounded-[20px] bg-white shadow-[0_10px_22px_rgba(19,41,26,0.04)] overflow-hidden">
                            <button type="button" onclick="toggleSettingsPanel('createAdminPanel')" class="flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#eef5ff] text-[#1E4FA3]">
                                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1b2433]">Create Admin Account</div>
                                        <div class="text-xs text-[#51657c]">Add new admin, editor, or reporter</div>
                                    </div>
                                </div>
                                <svg id="createAdminPanelChevron" class="h-5 w-5 text-slate-400 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div id="createAdminPanel" class="hidden border-t border-slate-100">
                                <div class="px-5 py-5">
                                    <form method="POST" action="{{ route('admin.settings.admins') }}" class="max-w-lg space-y-4">
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
                                        <button type="submit" class="rounded-xl bg-[#173b27] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Create account</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Account Summary Dropdown --}}
                        <div class="rounded-[20px] bg-white shadow-[0_10px_22px_rgba(19,41,26,0.04)] overflow-hidden">
                            <button type="button" onclick="toggleSettingsPanel('accountPanel')" class="flex w-full items-center justify-between px-5 py-4 text-left transition hover:bg-slate-50">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#fef3c7] text-[#92400e]">
                                        <svg class="h-4.5 w-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1b2433]">Account Summary</div>
                                        <div class="text-xs text-[#51657c]">Your profile and session information</div>
                                    </div>
                                </div>
                                <svg id="accountPanelChevron" class="h-5 w-5 text-slate-400 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                            <div id="accountPanel" class="hidden border-t border-slate-100">
                                <div class="px-5 py-5">
                                    <div class="grid gap-4 sm:grid-cols-2 max-w-2xl">
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <div class="text-slate-500 text-xs font-medium">User</div>
                                            <div class="mt-1 text-base font-semibold text-slate-900">{{ $userName ?? 'Admin User' }}</div>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <div class="text-slate-500 text-xs font-medium">Last login</div>
                                            <div class="mt-1 text-base font-semibold text-slate-900">{{ $lastLogin ?? 'No record yet' }}</div>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <div class="text-slate-500 text-xs font-medium">Last password change</div>
                                            <div class="mt-1 text-base font-semibold text-slate-900">{{ $lastPasswordChanged ?? '2026-09-10 09:12' }}</div>
                                        </div>
                                        <div class="rounded-2xl bg-slate-50 p-4">
                                            <div class="text-slate-500 text-xs font-medium">Role</div>
                                            <div class="mt-1 text-base font-semibold text-slate-900">Administrator</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function toggleSettingsPanel(panelId) {
                            const panel = document.getElementById(panelId);
                            const chevron = document.getElementById(panelId + 'Chevron');
                            if (!panel) return;
                            const isHidden = panel.classList.contains('hidden');
                            panel.classList.toggle('hidden', !isHidden);
                            if (isHidden) {
                                panel.style.maxHeight = '0';
                                panel.style.overflow = 'hidden';
                                panel.style.transition = 'max-height 0.35s ease';
                                requestAnimationFrame(() => { panel.style.maxHeight = panel.scrollHeight + 'px'; });
                                setTimeout(() => { panel.style.maxHeight = 'none'; panel.style.overflow = ''; }, 360);
                            } else {
                                panel.style.maxHeight = panel.scrollHeight + 'px';
                                panel.style.overflow = 'hidden';
                                panel.style.transition = 'max-height 0.3s ease';
                                requestAnimationFrame(() => { panel.style.maxHeight = '0'; });
                                setTimeout(() => { panel.classList.add('hidden'); panel.style.maxHeight = ''; panel.style.overflow = ''; panel.style.transition = ''; }, 310);
                                return;
                            }
                            if (chevron) chevron.style.transform = isHidden ? 'rotate(180deg)' : '';
                        }

                        if (window.location.hash === '#passwordPanel' || window.location.hash === '#createAdminPanel') {
                            const targetPanel = window.location.hash.slice(1);
                            toggleSettingsPanel(targetPanel);
                            requestAnimationFrame(() => document.getElementById(targetPanel)?.scrollIntoView({ behavior: 'smooth', block: 'center' }));
                        }
                    </script>

                    <section class="mt-6 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-[0_10px_22px_rgba(19,41,26,0.05)]" aria-labelledby="admin-accounts-title">
                        <div class="border-b border-slate-100 px-5 py-4">
                            <h2 id="admin-accounts-title" class="text-sm font-semibold text-[#173b27]">Team accounts</h2>
                            <p class="mt-1 text-xs text-[#51657c]">Accounts with administrative or editorial access</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[700px] text-left text-sm">
                                <thead class="bg-[#f8fafc] text-[11px] font-semibold uppercase tracking-[0.12em] text-[#51657c]">
                                    <tr>
                                        <th class="px-5 py-3">Account</th>
                                        <th class="px-3 py-3">Role</th>
                                        <th class="px-3 py-3">Created</th>
                                        <th class="px-3 py-3">Last login</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse ($items as $account)
                                        <tr>
                                            <td class="px-5 py-3">
                                                <div class="font-semibold text-slate-800">{{ $account->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $account->email }}</div>
                                            </td>
                                            <td class="px-3 py-3"><span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-xs font-semibold capitalize text-[#173b27]">{{ $account->role }}</span></td>
                                            <td class="px-3 py-3 text-slate-600">{{ $account->created_at?->format('M d, Y') ?? '—' }}</td>
                                            <td class="px-3 py-3 text-slate-600">{{ $account->last_login_at?->format('M d, Y, h:i A') ?? 'Never' }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-slate-500">No team accounts found.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @include('admin.partials.pagination', ['paginator' => $items, 'ariaLabel' => 'Settings accounts pagination'])
                    </section>
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

    <div id="articleViewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4 backdrop-blur-sm" onclick="closeArticleViewModal()" role="dialog" aria-modal="true" aria-labelledby="articleViewTitle">
        <article class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <p id="articleViewMeta" class="text-xs font-semibold uppercase tracking-[0.14em] text-[#2f7d4d]"></p>
                    <h2 id="articleViewTitle" class="mt-2 text-xl font-bold text-slate-900"></h2>
                </div>
                <button type="button" onclick="closeArticleViewModal()" aria-label="Close article details" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 text-slate-500 hover:bg-slate-50">&times;</button>
            </div>
            <p id="articleViewExcerpt" class="mt-5 text-sm font-medium leading-6 text-slate-700"></p>
            <p id="articleViewContent" class="mt-3 whitespace-pre-line text-sm leading-7 text-slate-600"></p>
            <div id="articleViewStats" class="mt-5 flex flex-wrap gap-x-4 gap-y-2 border-t border-slate-100 pt-4 text-xs text-slate-500"></div>
            <a id="articleViewLink" href="#" target="_blank" rel="noopener" class="mt-5 inline-flex rounded-xl bg-[#173b27] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#214d35]">Open public article</a>
        </article>
    </div>

    {{-- ============ DELETE CONFIRMATION MODAL ============ --}}
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4" onclick="closeDeleteModal()">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#1b2433]">Delete Confirmation</h3>
                    <p class="text-sm text-slate-500">This action cannot be undone.</p>
                </div>
            </div>
            <p class="text-sm text-slate-600 mb-6">Are you sure you want to delete <strong id="deleteItemName" class="text-[#1b2433]"></strong>?</p>
            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">Cancel</button>
                <form id="deleteConfirmForm" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleGalleryComposer() {
            const panel = document.getElementById('galleryComposer');
            const button = document.getElementById('galleryCreateButton');
            if (!panel || !button) return;

            const isOpening = panel.classList.contains('hidden');
            panel.classList.toggle('hidden', !isOpening);
            button.setAttribute('aria-expanded', String(isOpening));

            if (isOpening) {
                panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                panel.querySelector('input[name="title"]')?.focus();
            }
        }

        function openArticleViewModal(trigger) {
            const read = (key) => trigger.dataset['article' + key] || '';
            document.getElementById('articleViewTitle').textContent = read('Title');
            document.getElementById('articleViewMeta').textContent = read('Category') + ' · ' + read('Status');
            document.getElementById('articleViewExcerpt').textContent = read('Excerpt') || 'No excerpt provided.';
            document.getElementById('articleViewContent').textContent = read('Content') || 'No article content provided.';
            document.getElementById('articleViewStats').textContent = [
                'By ' + (read('Author') || 'Unknown author'),
                read('Date'),
                read('Views') + ' views',
                read('ReadTime'),
            ].filter(Boolean).join(' · ');
            document.getElementById('articleViewLink').href = trigger.dataset.articleUrl || '#';
            document.getElementById('articleViewModal').style.display = 'flex';
        }

        function closeArticleViewModal() {
            document.getElementById('articleViewModal').style.display = 'none';
        }

        function openDeleteModal(actionUrl, itemName) {
            document.getElementById('deleteConfirmForm').action = actionUrl;
            document.getElementById('deleteItemName').textContent = itemName;
            document.getElementById('deleteConfirmModal').style.display = 'flex';
        }
        function closeDeleteModal() {
            document.getElementById('deleteConfirmModal').style.display = 'none';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
                closeArticleViewModal();
            }
        });
    </script>
@endsection
