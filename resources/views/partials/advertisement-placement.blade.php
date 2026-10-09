<div class="{{ $containerClass ?? 'space-y-3' }}">
    @foreach ($advertisements->take($limit ?? 1) as $advertisement)
        @php
            $isSidebar = $advertisement->position === 'sidebar';
            $isArticleTop = $advertisement->position === 'article-top';
            $bannerAspectRatio = $isSidebar ? 'aspect-[300/250]' : ($isArticleTop ? 'aspect-[760/90]' : 'aspect-[728/90]');
            $maxWidth = $isSidebar ? 'max-w-[300px]' : ($isArticleTop ? 'max-w-[760px]' : '');
            $objectFit = 'object-contain';
        @endphp
        <div class="overflow-hidden rounded-xl">
            @if ($advertisement->click_url)
                <a href="{{ $advertisement->click_url }}" target="_blank" rel="sponsored noopener noreferrer" aria-label="Advertisement: {{ $advertisement->title }}" class="block focus:outline-none focus-visible:ring-4 focus-visible:ring-[#8FD58F]">
            @else
                <div>
            @endif
                    <img src="{{ asset('storage/'.$advertisement->banner_path) }}" alt="{{ $advertisement->title }}" class="block w-full {{ $maxWidth }} {{ $bannerAspectRatio }} {{ $objectFit }}" loading="lazy">
            @if ($advertisement->click_url)
                </a>
            @else
                </div>
            @endif
        </div>
    @endforeach
</div>
