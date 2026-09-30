<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_post_redirects_regular_users_to_home(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => 'Secret123',
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Secret123',
        ]);

        $response->assertRedirect('/');
    }

    public function test_registration_requires_matching_password_confirmation(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    public function test_static_footer_pages_are_available(): void
    {
        $this->get('/privacy')->assertOk();
        $this->get('/terms')->assertOk();
        $this->get('/support')->assertOk();
    }

    public function test_home_page_shows_all_latest_news_without_pagination(): void
    {
        $category = Category::create([
            'name' => 'Forest',
            'slug' => 'forest',
        ]);

        foreach (range(1, 6) as $index) {
            $this->createPublishedStory(
                $category,
                "Database homepage story {$index}",
                "database-homepage-story-{$index}",
                100 * $index,
                $index === 1,
            );
        }

        $response = $this->get('/?page=2');

        $response->assertOk()
            ->assertSee('Database homepage story 6')
            ->assertSee('Database homepage story 1')
            ->assertSee('Breaking')
            ->assertSee('data-breaking-count="5"', false)
            ->assertDontSee('page=2');
    }

    public function test_home_category_cards_open_the_matching_category_pages(): void
    {
        $categories = [
            'forest-conservation' => 'वन संरक्षण',
            'wildlife' => 'वन्यजन्तु',
            'environment' => 'वातावरण',
            'climate-change' => 'जलवायु परिवर्तन',
            'community-forest' => 'सामुदायिक वन',
            'national-park' => 'राष्ट्रिय निकुञ्ज',
        ];

        foreach ($categories as $slug => $title) {
            $category = Category::create(['name' => $title, 'slug' => $slug]);
            $this->createPublishedStory($category, $title.' story', $slug.'-story', 125);
        }

        $homeResponse = $this->get('/');
        $homeResponse->assertOk();

        foreach ($categories as $slug => $title) {
            $homeResponse->assertSee(route('category.show', $slug), false);

            $this->get(route('category.show', $slug))
                ->assertOk()
                ->assertSee($title);
        }
    }

    public function test_trending_story_cards_are_full_card_links(): void
    {
        $category = Category::create(['name' => 'Wildlife', 'slug' => 'wildlife']);
        foreach (range(1, 5) as $index) {
            $this->createPublishedStory($category, "Trending story {$index}", "trending-story-{$index}", $index * 100);
        }

        $response = $this->get('/');

        $response->assertOk();
        $this->assertSame(5, substr_count($response->getContent(), 'aria-label="Open story:'));
    }

    public function test_insights_gallery_and_home_video_are_interactive(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('aria-label="Open insight: वन निगरानी"', false)
            ->assertSee('aria-label="Open gallery image: हिमाली वन"', false)
            ->assertSee('<video', false)
            ->assertSee('controls', false);
    }

    public function test_climate_change_category_shows_multiple_story_cards(): void
    {
        $this->get(route('category.show', 'climate-change'))
            ->assertOk()
            ->assertSee('हिमाली ग्लेशियर घट्दै जाँदा नदी प्रवाहमा परिवर्तन')
            ->assertSee('जलवायु परिवर्तनले हिमाली तालको जोखिम बढायो')
            ->assertSee('मनसुन चक्रमा परिवर्तनले खेतीपातीमा असर');
    }

    public function test_environment_category_shows_multiple_story_cards(): void
    {
        $this->get(route('category.show', 'environment'))
            ->assertOk()
            ->assertSee('नेपालका प्रमुख नदीहरूमा पानीको गुणस्तर परीक्षण बढ्यो')
            ->assertSee('नदी किनारका बस्तीमा फोहोरमैला नियन्त्रण अभियान')
            ->assertSee('सहरी क्षेत्रमा वायु प्रदूषण मापन केन्द्र विस्तार');
    }

    public function test_wildlife_category_shows_multiple_story_cards(): void
    {
        $this->get(route('category.show', 'wildlife'))
            ->assertOk()
            ->assertSee('चितवनमा कोसी नदा क्षेत्रमा बाघको बसाइँ बढ्यो')
            ->assertSee('वन्यजन्तुको बासस्थान जोगाउन क्यामेरा ट्र्याप विस्तार')
            ->assertSee('चितवन क्षेत्रमा गैँडाको गणना सुरु');
    }

    public function test_gallery_images_open_the_full_size_image(): void
    {
        $this->get(route('gallery'))
            ->assertOk()
            ->assertSee('href="https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&amp;fit=crop&amp;w=900&amp;q=80"', false)
            ->assertSee('target="_blank"', false)
            ->assertSee('aria-label="Open gallery image: हिमाली वन"', false);
    }

    private function createPublishedStory(Category $category, string $title, string $slug, int $views, bool $featured = false): News
    {
        return News::create([
            'title' => $title,
            'slug' => $slug,
            'category_id' => $category->id,
            'status' => 'published',
            'author' => 'Editorial Team',
            'excerpt' => "Read the latest report about {$title}.",
            'content' => "Full story content for {$title}.",
            'image_url' => '/image/samples/01.svg',
            'views' => $views,
            'featured' => $featured,
        ]);
    }

    public function test_home_featured_latest_and_category_cards_use_database_records(): void
    {
        $category = Category::create([
            'name' => 'Live forest category',
            'slug' => 'live-forest',
        ]);

        News::create([
            'title' => 'Featured database story',
            'slug' => 'featured-database-story',
            'category_id' => $category->id,
            'status' => 'published',
            'author' => 'Editorial Team',
            'excerpt' => 'An excerpt stored with the article record.',
            'content' => 'Article content stored in the database.',
            'image_url' => '/image/samples/01.svg',
            'views' => 1234,
            'featured' => true,
        ]);

        News::create([
            'title' => 'Latest database story',
            'slug' => 'latest-database-story',
            'category_id' => $category->id,
            'status' => 'published',
            'author' => 'News Desk',
            'excerpt' => 'Latest excerpt from the database.',
            'content' => 'Latest article content.',
            'image_url' => '/image/samples/02.svg',
            'views' => 321,
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Featured database story')
            ->assertSee('Latest database story')
            ->assertSee('Live forest category')
            ->assertSee('1,234')
            ->assertSee(route('category.show', 'live-forest'), false);

        $this->get(route('news.show', 'featured-database-story'))
            ->assertOk()
            ->assertSee('Featured database story')
            ->assertSee('Article content stored in the database.');

        $this->get(route('category.show', 'live-forest'))
            ->assertOk()
            ->assertSee('Live forest category')
            ->assertSee('Featured database story');
    }
}
