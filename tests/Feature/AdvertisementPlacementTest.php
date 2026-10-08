<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AdvertisementPlacementTest extends TestCase
{
    public function test_article_top_banner_uses_760_by_90_dimensions(): void
    {
        $advertisement = Advertisement::make([
            'title' => 'Article banner',
            'position' => 'article-top',
            'banner_path' => 'advertisements/test.png',
        ]);

        $html = view('partials.advertisement-placement', [
            'advertisements' => Collection::make([$advertisement]),
        ])->render();

        $this->assertStringContainsString('max-w-[760px]', $html);
        $this->assertStringContainsString('aspect-[760/90]', $html);
    }

    public function test_sidebar_banner_preserves_300_by_250_dimensions(): void
    {
        $advertisement = Advertisement::make([
            'title' => 'Sidebar banner',
            'position' => 'sidebar',
            'banner_path' => 'advertisements/test.png',
        ]);

        $html = view('partials.advertisement-placement', [
            'advertisements' => Collection::make([$advertisement]),
        ])->render();

        $this->assertStringContainsString('max-w-[300px]', $html);
        $this->assertStringContainsString('aspect-[300/250]', $html);
    }

    public function test_only_the_second_banner_is_rendered_when_two_banners_are_present(): void
    {
        $firstBanner = Advertisement::make([
            'title' => 'First banner',
            'position' => 'sidebar',
            'banner_path' => 'advertisements/test.png',
        ]);
        $secondBanner = Advertisement::make([
            'title' => 'Second banner',
            'position' => 'sidebar',
            'banner_path' => 'advertisements/test.png',
        ]);

        $html = view('partials.advertisement-placement', [
            'advertisements' => Collection::make([$firstBanner, $secondBanner]),
        ])->render();

        $this->assertStringNotContainsString('First banner', $html);
        $this->assertStringContainsString('Second banner', $html);
    }
}
