@if (method_exists($paginator, 'links') && $paginator->lastPage() > 1)
    @php
        $paginationWindow = \Illuminate\Pagination\UrlWindow::make($paginator);
        $paginationElements = array_filter([
            $paginationWindow['first'],
            is_array($paginationWindow['slider']) ? '...' : null,
            $paginationWindow['slider'],
            is_array($paginationWindow['last']) ? '...' : null,
            $paginationWindow['last'],
        ]);
    @endphp

    <div class="mt-5 flex flex-wrap items-center justify-between gap-4 border-t border-slate-100 pt-4">
        <div class="text-sm text-slate-500">
            @if ($paginator->total() > 0)
                Showing {{ number_format($paginator->firstItem()) }} to {{ number_format($paginator->lastItem()) }} of {{ number_format($paginator->total()) }} results
            @else
                Showing 0 results
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <form method="GET" action="{{ request()->url() }}" class="flex items-center gap-2">
                @foreach (request()->except(['page', 'per_page']) as $queryKey => $queryValue)
                    @if (is_scalar($queryValue))
                        <input type="hidden" name="{{ $queryKey }}" value="{{ $queryValue }}">
                    @endif
                @endforeach
                <label for="adminPerPage" class="whitespace-nowrap text-sm text-slate-500">Per page</label>
                <select id="adminPerPage" name="per_page" onchange="this.form.submit()" class="h-9 rounded-lg border border-slate-200 bg-white px-2.5 text-sm font-semibold text-slate-600 outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100">
                    @foreach ([2, 4, 5, 6, 10, 25, 50, 100] as $pageSize)
                        <option value="{{ $pageSize }}" @selected((int) request('per_page', $paginator->perPage()) === $pageSize)>{{ $pageSize }}</option>
                    @endforeach
                </select>
            </form>

            <nav class="flex items-center gap-1" aria-label="{{ $ariaLabel ?? 'Admin pagination' }}">
                @if ($paginator->currentPage() > 1)
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </a>
                @else
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-300" aria-hidden="true">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </span>
                @endif

                @foreach ($paginationElements as $paginationElement)
                    @if (is_string($paginationElement))
                        <span class="px-1 text-sm text-slate-400" aria-hidden="true">…</span>
                    @elseif (is_array($paginationElement))
                        @foreach ($paginationElement as $pageNumber => $pageUrl)
                            @if ($pageNumber == $paginator->currentPage())
                                <span aria-current="page" class="flex h-8 min-w-8 items-center justify-center rounded-lg bg-[#173b27] px-2 text-sm font-semibold text-white">{{ $pageNumber }}</span>
                            @else
                                <a href="{{ $pageUrl }}" class="flex h-8 min-w-8 items-center justify-center rounded-lg border border-slate-200 px-2 text-sm font-semibold text-slate-600 transition hover:border-emerald-600 hover:text-emerald-700">{{ $pageNumber }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page" class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-emerald-600 hover:text-emerald-700">
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
@endif