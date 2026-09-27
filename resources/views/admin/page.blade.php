@extends('layouts.app')

@section('title', $pageTitle . ' | Admin')

@section('content')
    <style>
        body { background: #edf3f7; }
        header, footer { display: none !important; }
        .dashboard-shell { min-height: 100vh; }
        .sidebar-item.active {
            background: rgba(255,255,255,0.12);
            box-shadow: inset 0 0 0 1px rgba(255,255,255,0.08);
        }
        .stat-card {
            border: 1px solid rgba(15, 40, 77, 0.06);
        }
        .form-input { @apply mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100; }
    </style>

    <section class="dashboard-shell mx-auto max-w-[1600px] px-3 py-4 sm:px-5 lg:px-6">
        <div class="flex overflow-hidden rounded-[26px] bg-[#edf4f8] shadow-[0_28px_80px_rgba(11,30,52,0.14)] ring-1 ring-[#dfeaf2]">
            <aside class="w-[250px] bg-[#173b27] p-4 text-white">
                <div class="flex items-center gap-3 border-b border-white/10 pb-4">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10">
                        <img src="{{ asset('image/fev icon.png') }}" alt="वनको खबर icon" class="h-8 w-8 rounded-xl object-cover">
                    </div>
                    <div>
                        <div class="text-xl font-bold leading-none">Ban ko khabar</div>
                        <div class="mt-1 text-[10px] uppercase tracking-[0.26em] text-[#dfeee0]">Newsroom</div>
                    </div>
                </div>

                <nav class="mt-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} flex items-center justify-between rounded-2xl px-3 py-3 text-sm font-medium text-white">
                        <span class="flex items-center gap-3">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#98d28e]"></span>
                            Dashboard
                        </span>
                        <span class="rounded-full bg-[#98d28e] px-2 py-1 text-[10px] font-bold text-[#173b27]">Live</span>
                    </a>
                    <a href="{{ route('admin.articles') }}" class="sidebar-item {{ request()->routeIs('admin.articles') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Articles</a>
                    <a href="{{ route('admin.categories') }}" class="sidebar-item {{ request()->routeIs('admin.categories') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Categories</a>
                    <a href="{{ route('admin.gallery') }}" class="sidebar-item {{ request()->routeIs('admin.gallery') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Gallery</a>
                    <a href="{{ route('admin.users') }}" class="sidebar-item {{ request()->routeIs('admin.users') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Users</a>
                    <a href="{{ route('admin.reports') }}" class="sidebar-item {{ request()->routeIs('admin.reports') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Reports</a>
                    <a href="{{ route('admin.settings') }}" class="sidebar-item {{ request()->routeIs('admin.settings') ? 'active' : '' }} flex items-center rounded-2xl px-3 py-3 text-sm font-medium text-[#dfeee0] transition hover:bg-white/5 hover:text-white">Settings</a>
                </nav>

                <div class="mt-8 rounded-[20px] bg-white/5 p-4 ring-1 ring-white/10">
                    <p class="text-[10px] uppercase tracking-[0.26em] text-[#dfeee0]">Quick note</p>
                    <p class="mt-3 text-sm leading-6 text-[#edf7ee]">Your latest climate coverage is performing better than the weekly average.</p>
                    <button type="button" class="mt-4 w-full rounded-full bg-[#98d28e] px-4 py-2.5 text-sm font-semibold text-[#173b27] shadow-sm transition hover:bg-[#b2e0a8]">Publish report</button>
                </div>
            </aside>

            <main class="flex-1 bg-[#f3f7fb] p-5 sm:p-6">
                <header class="mb-6 flex items-center justify-between gap-4 rounded-[18px] border border-[#dfe8f0] bg-[#f7f9fc] px-4 py-3 shadow-sm">
                    <div class="flex items-center gap-3 min-w-[120px]">
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe5ee] bg-white text-lg text-[#1b2a3d] shadow-sm" aria-label="Menu">
                            ☰
                        </button>
                    </div>

                    <div class="flex flex-1 items-center justify-center gap-3 overflow-hidden">
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-semibold uppercase tracking-[0.14em] text-[#173b27] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            <span>{{ now()->format('H:i:s') }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-medium text-[#3b4a5f] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            <span>{{ now()->translatedFormat('d M, Y') }}</span>
                        </div>
                        <div class="inline-flex items-center gap-2 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 text-xs font-medium text-[#3b4a5f] shadow-sm">
                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-[#22c55e]"></span>
                            <span>Last login: {{ $lastLogin ?? 'Today, 10:42 AM' }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 min-w-[170px] justify-end">
                        <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full border border-[#dbe5ee] bg-white text-lg text-[#1b2a3d] shadow-sm" aria-label="Full screen">
                            ⛶
                        </button>
                        <div class="relative group">
                            <div class="flex items-center gap-3 rounded-full border border-[#dfeaf2] bg-white px-3 py-2 shadow-sm">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-[#98d28e] text-sm font-bold text-[#173b27]">{{ strtoupper(substr($userName ?? 'A', 0, 1)) }}</div>
                                <div class="text-sm font-semibold text-[#1c2438]">{{ $userName ?? 'Admin User' }}</div>
                            </div>
                            <div class="absolute right-0 top-full z-10 mt-2 hidden w-52 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl group-hover:block">
                                <a href="{{ route('admin.settings') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">Settings</a>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="mt-1 w-full rounded-xl px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>

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
                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 flex items-center justify-between">
                                <div class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Latest articles</div>
                                <span class="rounded-full bg-[#eaf7ea] px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-[#173b27]">Live</span>
                            </div>
                            <div class="space-y-3">
                                @forelse ($items as $item)
                                    @php
                                        $articleTitle = is_object($item) ? ($item->title ?? $item->name ?? 'Untitled') : ($item['title'] ?? $item['name'] ?? 'Untitled');
                                        $articleMeta = is_object($item) ? ($item->category->name ?? $item->category ?? 'Uncategorized') : ($item['category'] ?? $item['category_name'] ?? 'Uncategorized');
                                        $articleStatus = is_object($item) ? ($item->status ?? 'published') : ($item['status'] ?? 'published');
                                    @endphp
                                    <div class="flex items-center justify-between gap-3 rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                        <div>
                                            <div class="text-base font-semibold text-[#173b27]">{{ $articleTitle }}</div>
                                            <div class="mt-1 text-sm text-[#51657c]">{{ $articleMeta }} · {{ is_object($item) ? ($item->created_at?->format('M d, Y') ?? '') : ($item['published_at'] ?? $item['date'] ?? '') }}</div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-full bg-[#eaf7ea] px-3 py-1 text-xs font-semibold text-[#173b27]">{{ ucfirst($articleStatus) }}</span>
                                            <form method="POST" action="{{ route('admin.articles.delete', is_object($item) ? $item->id : ($item['id'] ?? 0)) }}">
                                                @csrf
                                                <button type="submit" class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No articles yet.</div>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-[20px] bg-white p-5 shadow-[0_10px_22px_rgba(19,41,26,0.04)]">
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Add article</div>
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
                                        @foreach (App\Models\Category::all() as $category)
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
                                    <label class="text-sm font-medium text-slate-700">Status</label>
                                    <select class="form-input" name="status">
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
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
                                        $categoryName = is_object($item) ? ($item->name ?? 'Untitled') : ($item['name'] ?? 'Untitled');
                                        $categorySlug = is_object($item) ? ($item->slug ?? '') : ($item['slug'] ?? '');
                                        $categoryDescription = is_object($item) ? ($item->description ?? '') : ($item['description'] ?? '');
                                    @endphp
                                    <div class="flex items-center justify-between gap-3 rounded-[18px] border border-[#edf2f6] bg-[#f7fafc] px-4 py-3">
                                        <div>
                                            <div class="text-base font-semibold text-[#173b27]">{{ $categoryName }}</div>
                                            <div class="mt-1 text-sm text-[#51657c]">{{ $categorySlug }} · {{ $categoryDescription ?: 'No description' }}</div>
                                        </div>
                                        <form method="POST" action="{{ route('admin.categories.delete', is_object($item) ? $item->id : ($item['id'] ?? 0)) }}">
                                            @csrf
                                            <button type="submit" class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-600">Delete</button>
                                        </form>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-4 py-5 text-sm text-slate-500">No categories yet.</div>
                                @endforelse
                            </div>
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
                @elseif ($pageType === 'settings')
                    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_1fr]">
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
                            <div class="mb-4 text-[11px] font-semibold uppercase tracking-[0.22em] text-[#51657c]">Account summary</div>
                            <div class="space-y-4 text-sm text-slate-700">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <div class="text-slate-500">User</div>
                                    <div class="mt-1 text-base font-semibold text-slate-900">{{ $userName ?? 'Admin User' }}</div>
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
        </div>
    </section>
@endsection
