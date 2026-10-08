<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRouteTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available_to_guests_and_authenticated_users(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false);

        $this->actingAs(User::factory()->create())
            ->get('/login')
            ->assertOk()
            ->assertSee('Welcome back');
    }

    public function test_register_page_is_available_to_guests_and_authenticated_users(): void
    {
        $this->get('/register')
            ->assertOk()
            ->assertSee('Create account')
            ->assertSee('name="password_confirmation"', false);

        $this->actingAs(User::factory()->create())
            ->get('/register')
            ->assertOk()
            ->assertSee('Create account')
            ->assertSee('name="password_confirmation"', false);
    }

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

    public function test_registered_user_appears_in_admin_users_page(): void
    {
        $this->post('/register', [
            'name' => 'New Reader',
            'email' => 'reader@example.com',
            'password' => 'Secret123',
            'password_confirmation' => 'Secret123',
        ])->assertRedirect('/');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('New Reader')
            ->assertSee('reader@example.com');
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

    public function test_homepage_displays_only_active_advertisements_inside_their_flight_window(): void
    {
        $this->travelTo(now()->setDate(2026, 10, 2)->setTime(12, 0));

        Advertisement::create([
            'title' => 'Live header sponsor',
            'position' => 'header',
            'banner_path' => 'advertisements/live-header.png',
            'click_url' => 'https://example.com/live',
            'active' => true,
        ]);

        Advertisement::create([
            'title' => 'Live article placement',
            'position' => 'article-top',
            'banner_path' => 'advertisements/live-article.png',
            'active' => true,
            'starts_at' => '2026-10-01 00:00:00',
            'ends_at' => '2026-10-03 00:00:00',
        ]);

        foreach ([
            'article-center' => 'Live center placement',
            'article-bottom' => 'Live bottom placement',
            'sidebar' => 'Live sidebar placement',
            'footer' => 'Live footer placement',
        ] as $position => $title) {
            Advertisement::create([
                'title' => $title,
                'position' => $position,
                'banner_path' => 'advertisements/'.str_replace(' ', '-', strtolower($title)).'.png',
                'active' => true,
            ]);
        }

        Advertisement::create([
            'title' => 'Inactive sponsor',
            'position' => 'header',
            'banner_path' => 'advertisements/inactive.png',
            'active' => false,
        ]);

        Advertisement::create([
            'title' => 'Future sponsor',
            'position' => 'header',
            'banner_path' => 'advertisements/future.png',
            'active' => true,
            'starts_at' => '2026-10-03 00:00:00',
        ]);

        Advertisement::create([
            'title' => 'Expired sponsor',
            'position' => 'header',
            'banner_path' => 'advertisements/expired.png',
            'active' => true,
            'ends_at' => '2026-10-01 23:59:59',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Live header sponsor')
            ->assertSee('/storage/advertisements/live-header.png', false)
            ->assertSee('Live article placement')
            ->assertSee('Live center placement')
            ->assertSee('Live bottom placement')
            ->assertSee('Live sidebar placement')
            ->assertSee('Live footer placement')
            ->assertDontSee('Inactive sponsor')
            ->assertDontSee('Future sponsor')
            ->assertDontSee('Expired sponsor');
    }

    public function test_insights_top_advertisement_is_rendered_on_the_homepage(): void
    {
        Advertisement::create([
            'title' => 'Insights sponsor',
            'position' => 'insights-top',
            'banner_path' => 'advertisements/insights-sponsor.png',
            'active' => true,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('/storage/advertisements/insights-sponsor.png', false);
    }

    public function test_header_advertisement_is_displayed_on_public_category_and_information_pages(): void
    {
        Advertisement::create([
            'title' => 'Shared site banner',
            'position' => 'header',
            'banner_path' => 'advertisements/shared-site-banner.png',
            'active' => true,
        ]);

        foreach ([
            '/category/forest-conservation',
            '/category/wildlife',
            '/category/environment',
            '/category/climate-change',
            '/gallery',
            '/about',
            '/contact',
        ] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('/storage/advertisements/shared-site-banner.png', false)
                ->assertSee('image/logo.png', false)
                ->assertSee('aria-label="Social media"', false)
                ->assertSee('title="Facebook"', false)
                ->assertSee('title="YouTube"', false);
        }
    }

    public function test_article_detail_shows_sidebar_ads_and_a_dynamic_comment_form(): void
    {
        News::create([
            'title' => 'Community forest story',
            'slug' => 'community-forest-story',
            'excerpt' => 'A report about community forests.',
            'content' => 'बर्दिया राष्ट्रिय निकुञ्जको दक्षिणी क्षेत्रमा क्यामेरा ट्रेपमा तीनवटा चितुवा रेकर्ड भएका छन्। वन विभागका अनुसार पछिल्लो दशकमा यो क्षेत्रमा चितुवाको संख्या बढ्दै गएको छ।',
            'status' => 'published',
            'image_url' => '/image/samples/01.svg',
        ]);

        News::create([
            'title' => 'Most read story',
            'slug' => 'most-read-story',
            'excerpt' => 'A popular community report.',
            'content' => 'Readers are following this conservation story.',
            'status' => 'published',
            'image_url' => '/image/samples/02.svg',
            'views' => 500,
        ]);

        News::create([
            'title' => 'Second most read story',
            'slug' => 'second-most-read-story',
            'excerpt' => 'Another popular report.',
            'content' => 'More readers are following this report.',
            'status' => 'published',
            'image_url' => '/image/samples/03.svg',
            'views' => 300,
        ]);

        foreach ([
            ['Third most read story', 'third-most-read-story', 250],
            ['Fourth most read story', 'fourth-most-read-story', 200],
            ['Fifth most read story', 'fifth-most-read-story', 150],
            ['Sixth most read story', 'sixth-most-read-story', 100],
        ] as [$title, $slug, $views]) {
            News::create([
                'title' => $title,
                'slug' => $slug,
                'excerpt' => 'A popular conservation report.',
                'content' => 'Readers are following this conservation story.',
                'status' => 'published',
                'image_url' => '/image/samples/04.svg',
                'views' => $views,
            ]);
        }

        Advertisement::create([
            'title' => 'Article sidebar campaign',
            'position' => 'sidebar',
            'banner_path' => 'advertisements/article-sidebar.png',
            'active' => true,
        ]);

        Advertisement::create([
            'title' => 'Article center campaign',
            'position' => 'article-center',
            'banner_path' => 'advertisements/article-center.png',
            'active' => true,
        ]);

        $this->get('/news/community-forest-story')
            ->assertOk()
            ->assertSee('/storage/advertisements/article-center.png', false)
            ->assertSeeInOrder([
                'Most Read',
                'Most read story',
                'Second most read story',
                'Third most read story',
                'Fourth most read story',
                'Fifth most read story',
                'Sixth most read story',
                '/storage/advertisements/article-center.png',
                '/storage/advertisements/article-sidebar.png',
            ], false)
            ->assertSee('data-article-sidebar-ad', false)
            ->assertSee('data-article-center-sidebar-ad', false)
            ->assertDontSee('data-article-center-ad', false)
            ->assertSee('वन विभागका अनुसार')
            ->assertDontSee('�')
            ->assertSee('500 views', false)
            ->assertSee('id="articleBodyWithAds"', false)
            ->assertSee('xl:grid-cols-[minmax(0,7fr)_minmax(280px,3fr)]', false)
            ->assertSee('name="name"', false)
            ->assertSee('name="body"', false)
            ->assertDontSee('मंगला')
            ->assertDontSee('गणेश');
    }

    public function test_reader_can_submit_a_comment_on_an_article(): void
    {
        News::create([
            'title' => 'Forest report',
            'slug' => 'forest-report-comments',
            'excerpt' => 'A report about forest protection.',
            'content' => 'Community members shared new findings.',
            'status' => 'published',
            'image_url' => '/image/samples/01.svg',
        ]);

        $this->post('/news/forest-report-comments/comments', [
            'name' => 'माया',
            'body' => 'यो समाचार उपयोगी छ।',
        ])->assertRedirect('/news/forest-report-comments#comments');

        $this->assertDatabaseHas('article_comments', [
            'article_slug' => 'forest-report-comments',
            'name' => 'माया',
            'body' => 'यो समाचार उपयोगी छ।',
        ]);

        $this->get('/news/forest-report-comments')
            ->assertOk()
            ->assertSee('माया')
            ->assertSee('यो समाचार उपयोगी छ।');
    }

    public function test_article_comments_require_a_name_and_message(): void
    {
        News::create([
            'title' => 'Forest report',
            'slug' => 'forest-report-validation',
            'excerpt' => 'A report about forest protection.',
            'status' => 'published',
            'image_url' => '/image/samples/01.svg',
        ]);

        $this->from('/news/forest-report-validation')
            ->post('/news/forest-report-validation/comments', [])
            ->assertRedirect('/news/forest-report-validation')
            ->assertSessionHasErrors(['name', 'body']);

        $this->assertDatabaseCount('article_comments', 0);
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
