<div class="space-y-3">
    @foreach ($advertisements as $advertisement)
        @php
            $bannerMaxWidth = $advertisement->position === 'sidebar' ? 'max-w-[280px]' : 'max-w-[640px]';
        @endphp
        <div class="overflow-hidden">
            @if ($advertisement->click_url)
                <a href="{{ $advertisement->click_url }}" target="_blank" rel="sponsored noopener noreferrer" aria-label="Advertisement: {{ $advertisement->title }}" class="block focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F]">
            @else
                <div>
            @endif
                    <img src="{{ asset('storage/'.$advertisement->banner_path) }}" alt="{{ $advertisement->title }}" class="mx-auto block h-auto w-full {{ $bannerMaxWidth }} object-contain" loading="lazy">
            @if ($advertisement->click_url)
                </a>
            @else
                </div>
            @endif
        </div>
    @endforeach
</div>