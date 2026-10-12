<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SearchAndAdvertisementLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_matches_news_by_category_slug(): void
    {
        $response = $this->get('/search', ['q' => 'wildlife']);

        $response->assertStatus(200);
        $response->assertSee('चितवनमा कोसी नदा क्षेत्रमा बाघको बसाइँ बढ्यो');
        $response->assertDontSee('कुनै परिणाम फेला परेन');
    }

    public function test_search_selects_the_requested_category(): void
    {
        $response = $this->get('/search', [
            'q' => 'वन',
            'category' => 'वन संरक्षण',
        ]);

        $response->assertStatus(200);
        $response->assertSee('रातुमाईमा वन संरक्षणका लागि नयाँ राष्ट्रिय अभियान सुरु');
        $response->assertSee('वन संरक्षण');
    }

    public function test_home_banner_is_at_the_bottom_of_trending(): void
    {
        $view = file_get_contents(base_path('resources/views/home.blade.php'));

        $this->assertNotFalse($view);
        $trendingPosition = strpos($view, 'id="wildlife"');
        $bannerPosition = strpos($view, '@if ($homeAdvertisements->has(\'trending-bottom\'))');
        $insightsPosition = strpos($view, '<p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Insights</p>');

        $this->assertNotFalse($trendingPosition);
        $this->assertNotFalse($bannerPosition);
        $this->assertNotFalse($insightsPosition);
        $this->assertTrue($trendingPosition < $bannerPosition);
        $this->assertTrue($bannerPosition < $insightsPosition);
    }

    public function test_home_banners_are_rendered_between_latest_categories_trending_insights_and_gallery(): void
    {
        foreach ([
            'latest-bottom' => 'Latest and categories banner',
            'categories-bottom' => 'Categories and trending banner',
            'trending-bottom' => 'Trending banner',
            'insights-bottom' => 'Insights and gallery banner',
        ] as $position => $title) {
            Advertisement::create([
                'title' => $title,
                'position' => $position,
                'banner_path' => 'advertisements/'.str_replace(' ', '-', strtolower($title)).'.png',
                'active' => true,
            ]);
        }

        $response = $this->get('/');
        $html = $response->getContent();
        $latestPosition = strpos($html, '>Latest</p>');
        $latestBannerPosition = strpos($html, 'alt="Latest and categories banner"');
        $categoriesPosition = strpos($html, '>Categories</p>');
        $categoriesBannerPosition = strpos($html, 'alt="Categories and trending banner"');
        $trendingPosition = strpos($html, '>Trending</p>');
        $trendingBannerPosition = strpos($html, 'alt="Trending banner"');
        $insightsPosition = strpos($html, '>Insights</p>');
        $insightsBannerPosition = strpos($html, 'alt="Insights and gallery banner"');
        $galleryPosition = strpos($html, '>Gallery</p>');

        $response->assertOk();
        $this->assertNotFalse($latestPosition);
        $this->assertNotFalse($latestBannerPosition);
        $this->assertNotFalse($categoriesPosition);
        $this->assertNotFalse($categoriesBannerPosition);
        $this->assertNotFalse($trendingPosition);
        $this->assertNotFalse($trendingBannerPosition);
        $this->assertNotFalse($insightsPosition);
        $this->assertNotFalse($insightsBannerPosition);
        $this->assertNotFalse($galleryPosition);
        $this->assertTrue($latestPosition < $latestBannerPosition);
        $this->assertTrue($latestBannerPosition < $categoriesPosition);
        $this->assertTrue($categoriesPosition < $categoriesBannerPosition);
        $this->assertTrue($categoriesBannerPosition < $trendingPosition);
        $this->assertTrue($trendingPosition < $trendingBannerPosition);
        $this->assertTrue($trendingBannerPosition < $insightsPosition);
        $this->assertTrue($insightsPosition < $insightsBannerPosition);
        $this->assertTrue($insightsBannerPosition < $galleryPosition);
    }

    public function test_home_shows_three_hero_slides_with_selectable_indicators(): void
    {
        $response = $this->get('/');
        $html = $response->getContent();

        $response->assertSee('aria-label="Show hero image 1"', false)
            ->assertSee('aria-label="Show hero image 2"', false)
            ->assertSee('aria-label="Show hero image 3"', false)
            ->assertSee('src="'.asset('image/hero-forest-ridge.png').'"', false)
            ->assertSee('src="'.asset('image/hero-forest-valley.png').'"', false)
            ->assertSee('prefers-reduced-motion: reduce', false);

        $this->assertSame(3, substr_count($html, '<div data-hero-slide'));
        $this->assertSame(3, substr_count($html, 'data-hero-slide-button aria-label='));
    }

    public function test_home_displays_a_contact_house_ad_after_latest_when_no_latest_ad_is_active(): void
    {
        $response = $this->get('/');
        $html = $response->getContent();
        $latestPosition = strpos($html, '>Latest</p>');
        $houseAdPosition = strpos($html, 'data-ad-placement="latest-bottom-fallback"');
        $categoriesPosition = strpos($html, '>Categories</p>');

        $response->assertOk()
            ->assertSee('वन र वातावरणका अभियान पाठकसम्म पुर्‍याउनुहोस्')
            ->assertSee('विज्ञापनका लागि सम्पर्क')
            ->assertSee('href="'.route('contact').'"', false);
        $this->assertNotFalse($latestPosition);
        $this->assertNotFalse($houseAdPosition);
        $this->assertNotFalse($categoriesPosition);
        $this->assertTrue($latestPosition < $houseAdPosition);
        $this->assertTrue($houseAdPosition < $categoriesPosition);
    }

    public function test_home_footer_ad_is_placed_after_the_final_home_section(): void
    {
        $view = file_get_contents(base_path('resources/views/home.blade.php'));

        $this->assertNotFalse($view);
        $sectionEndPosition = strpos($view, '@endsection');
        $footerAdPosition = strpos($view, "@if (\$homeAdvertisements->has('footer'))");

        $this->assertNotFalse($sectionEndPosition);
        $this->assertNotFalse($footerAdPosition);
        $this->assertTrue($footerAdPosition < $sectionEndPosition);
    }

    public function test_home_featured_section_has_one_left_card_and_three_cards_without_right_side_ad(): void
    {
        $view = file_get_contents(base_path('resources/views/home.blade.php'));

        $this->assertNotFalse($view);
        $this->assertStringContainsString('lg:grid-cols-[minmax(0,1.15fr)_minmax(320px,0.85fr)]', $view);
        $this->assertStringContainsString('foreach($sideFeatures as $item)', $view);
        $this->assertStringNotContainsString("@if (\$homeAdvertisements->has('sidebar'))", $view);
        $this->assertStringContainsString('min-w-0', $view);
        $this->assertStringContainsString('line-clamp-2', $view);
        $this->assertStringNotContainsString("{{ \$item['excerpt'] }}", $view);
        $this->assertStringNotContainsString("{{ \$featured['excerpt'] }}", $view);
    }

    public function test_home_card_stats_are_positioned_at_top_right_of_images(): void
    {
        $view = file_get_contents(base_path('resources/views/home.blade.php'));

        $this->assertNotFalse($view);
        $this->assertSame(2, substr_count($view, 'absolute right-4 top-4 flex items-center gap-2'));
        $this->assertStringContainsString("{{ \$featured['reading_time'] }}", $view);
        $this->assertStringContainsString("number_format((int) \$featured['views'])", $view);
        $this->assertStringContainsString("{{ \$item['reading_time'] }}", $view);
        $this->assertStringContainsString("number_format((int) \$item['views'])", $view);
    }

    public function test_non_home_pages_do_not_show_breaking_news_ticker(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk()
            ->assertDontSee('Breaking')
            ->assertDontSee('data-breaking-count')
            ->assertDontSee('chara');
    }

    public function test_home_header_middle_column_shows_bikram_sambat_date(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 8));

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('२०८३ असोज २२');
    }

    public function test_non_home_header_center_shows_bikram_sambat_date(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 8));

        $response = $this->get(route('about'));

        $response->assertStatus(200);
        $response->assertSee('२०८३ असोज २२');
    }

    public function test_disabling_homepage_date_hides_it_from_all_public_site_headers(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 8));

        SiteSetting::query()->create([
            'key' => SiteSetting::HOMEPAGE_BIKRAM_SAMBAT_DATE,
            'value' => '0',
        ]);

        foreach ([
            route('category.show', ['slug' => 'forest-conservation']),
            route('category.show', ['slug' => 'wildlife']),
            route('category.show', ['slug' => 'environment']),
            route('category.show', ['slug' => 'climate-change']),
            route('gallery'),
            route('about'),
            route('contact'),
            route('search'),
            route('login'),
            route('register'),
        ] as $url) {
            $this->get($url)->assertDontSee('२०८३ असोज २२');
        }
    }

    public function test_home_header_shows_two_newest_header_ads_when_date_is_disabled(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 8));

        SiteSetting::query()->create([
            'key' => SiteSetting::HOMEPAGE_BIKRAM_SAMBAT_DATE,
            'value' => '0',
        ]);

        foreach ([
            ['title' => 'Newest header ad', 'path' => 'advertisements/newest.png', 'created_at' => now()],
            ['title' => 'Second header ad', 'path' => 'advertisements/second.png', 'created_at' => now()->subHour()],
            ['title' => 'Older header ad', 'path' => 'advertisements/older.png', 'created_at' => now()->subHours(2)],
        ] as $ad) {
            $advertisement = Advertisement::query()->create([
                'title' => $ad['title'],
                'position' => 'header',
                'banner_path' => $ad['path'],
                'active' => true,
            ]);
            $advertisement->created_at = $ad['created_at'];
            $advertisement->save();
        }

        $response = $this->get(route('home'));

        $response->assertSee('advertisements/newest.png')
            ->assertSee('advertisements/second.png')
            ->assertSee('grid-cols-1 gap-2 sm:grid-cols-2', false)
            ->assertDontSee('advertisements/older.png')
            ->assertDontSee('२०८३ असोज २२');
    }

    public function test_home_header_fills_missing_header_ads_with_other_active_ads_when_date_is_disabled(): void
    {
        SiteSetting::query()->create([
            'key' => SiteSetting::HOMEPAGE_BIKRAM_SAMBAT_DATE,
            'value' => '0',
        ]);

        foreach ([
            ['title' => 'Sidebar placement ad', 'position' => 'sidebar'],
            ['title' => 'Latest placement ad', 'position' => 'latest-bottom'],
            ['title' => 'Category placement ad', 'position' => 'categories-bottom'],
        ] as $ad) {
            Advertisement::query()->create([
                'title' => $ad['title'],
                'position' => $ad['position'],
                'banner_path' => 'advertisements/'.str_replace(' ', '-', strtolower($ad['title'])).'.png',
                'active' => true,
            ]);
        }

        $response = $this->get(route('home'));
        $html = $response->getContent();
        $homepageHeaderStart = strpos($html, 'aria-label="Social media"');
        $firstHeaderAdvertisement = strpos($html, 'alt="Latest placement ad"');
        $secondHeaderAdvertisement = strpos($html, 'alt="Category placement ad"');

        $response->assertSee('aspect-[728/90]', false)
            ->assertDontSee('aspect-[300/250]', false)
            ->assertDontSee('alt="Sidebar placement ad"', false)
            ->assertDontSee('२०८३ असोज २२');
        $this->assertNotFalse($homepageHeaderStart);
        $this->assertNotFalse($firstHeaderAdvertisement);
        $this->assertNotFalse($secondHeaderAdvertisement);
        $this->assertTrue($homepageHeaderStart < $firstHeaderAdvertisement);
        $this->assertTrue($firstHeaderAdvertisement < $secondHeaderAdvertisement);
    }

    public function test_date_disabled_public_headers_show_two_ads_even_when_image_content_repeats(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('advertisements/first.jpg', 'same image');
        Storage::disk('public')->put('advertisements/duplicate.jpg', 'same image');
        Storage::disk('public')->put('advertisements/second.jpg', 'different image');

        SiteSetting::query()->create([
            'key' => SiteSetting::HOMEPAGE_BIKRAM_SAMBAT_DATE,
            'value' => '0',
        ]);

        foreach ([
            ['title' => 'First ad', 'path' => 'advertisements/first.jpg', 'created_at' => now()],
            ['title' => 'Duplicate ad', 'path' => 'advertisements/duplicate.jpg', 'created_at' => now()->subMinute()],
            ['title' => 'Older ad', 'path' => 'advertisements/second.jpg', 'created_at' => now()->subMinutes(2)],
        ] as $ad) {
            $advertisement = Advertisement::query()->create([
                'title' => $ad['title'],
                'position' => 'header',
                'banner_path' => $ad['path'],
                'active' => true,
            ]);
            $advertisement->created_at = $ad['created_at'];
            $advertisement->save();
        }

        foreach ([route('home'), route('category.show', ['slug' => 'forest-conservation'])] as $url) {
            $response = $this->get($url);

            $response->assertSee('alt="First ad"', false)
                ->assertSee('alt="Duplicate ad"', false)
                ->assertDontSee('alt="Older ad"', false)
                ->assertDontSee('२०८३ असोज २२')
                ->assertSee('grid-cols-1', false)
                ->assertSee('sm:grid-cols-2', false);
        }
    }
}
