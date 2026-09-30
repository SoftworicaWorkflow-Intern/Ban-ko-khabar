{{--
    A table header cell with a two-way sort toggle, plus an optional
    filter dropdown (used by the Category, Author and Status columns).

    Expects: $label, $column, $sortKey, $sortDirection, $sortLinks
    Optional: $dropdownItems — array of ['label' => string, 'url' => string, 'active' => bool]
--}}
@php
    $isSorted = $sortKey === $column;
    $sortAsc = $isSorted && $sortDirection === 'asc';
    $sortDesc = $isSorted && $sortDirection === 'desc';
    $idleArrow = 'text-slate-300 group-hover/sort:text-slate-500';
@endphp

<th scope="col" class="px-3 py-3.5 font-semibold">
    <div class="flex items-center justify-between gap-1.5">
        <a href="{{ $sortLinks[$column] }}"
           class="inline-flex items-center whitespace-nowrap transition hover:text-[#173b27]"
           title="Sort by {{ $label }}">
            {{ $label }}
        </a>

        @isset($dropdownItems)
            <details class="relative shrink-0">
                <summary title="Filter by {{ $label }}"
                         class="flex h-5 w-5 cursor-pointer list-none items-center justify-center rounded-md text-slate-400 transition hover:bg-slate-200 hover:text-slate-600 [&::-webkit-details-marker]:hidden">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </summary>
                <div class="absolute right-0 top-full z-30 mt-1.5 max-h-[280px] w-52 overflow-y-auto rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl">
                    @foreach ($dropdownItems as $dropdownItem)
                        <a href="{{ $dropdownItem['url'] }}"
                           class="block truncate rounded-lg px-2.5 py-1.5 text-xs font-medium transition {{ ($dropdownItem['active'] ?? false) ? 'bg-[#eaf7ea] text-[#173b27]' : 'text-slate-600 hover:bg-slate-50' }}">
                            {{ $dropdownItem['label'] }}
                        </a>
                    @endforeach
                </div>
            </details>
        @endisset
    </div>
</th>
