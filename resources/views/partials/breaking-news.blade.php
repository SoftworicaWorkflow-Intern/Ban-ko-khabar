<div class="border-y border-[#dfeae0] bg-[#1b5e20] text-white dark:border-white/10 dark:bg-[#112822]">
    <div class="mx-auto flex max-w-7xl items-center gap-4 overflow-hidden px-4 py-3 sm:px-6 lg:px-8">
        <span class="shrink-0 rounded-full bg-[#e53935] px-3 py-1 text-xs font-bold uppercase tracking-wide">Breaking</span>
        <div class="relative flex-1 overflow-hidden">
            <div class="animate-[marquee_20s_linear_infinite] whitespace-nowrap text-sm font-medium" data-breaking-count="{{ count($breakingNews ?? []) }}">
                @if (! empty($breakingNews))
                    @foreach ($breakingNews as $item)
                        <span class="mr-10">{{ $item }}</span>
                    @endforeach
                @else
                    <span class="mr-10">नयाँ समाचार, वन संरक्षण, वन्यजन्तु र वातावरणीय अपडेटहरू</span>
                @endif
            </div>
        </div>
    </div>
</div>
