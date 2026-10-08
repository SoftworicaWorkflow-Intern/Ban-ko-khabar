<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    public function test_home_banner_is_between_trending_and_insights(): void
    {
        $view = file_get_contents(base_path('resources/views/home.blade.php'));

        $this->assertNotFalse($view);
        $trendingPosition = strpos($view, 'id="wildlife"');
        $bannerPosition = strpos($view, '@if ($homeAdvertisements->has(\'article-bottom\'))');
        $insightsPosition = strpos($view, '<p class="text-xs font-bold uppercase tracking-[0.3em] text-[#2E7D32]">Insights</p>');

        $this->assertNotFalse($trendingPosition);
        $this->assertNotFalse($bannerPosition);
        $this->assertNotFalse($insightsPosition);
        $this->assertTrue($trendingPosition < $bannerPosition);
        $this->assertTrue($bannerPosition < $insightsPosition);
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
}
