<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminSectionManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create([
            'email' => 'admin@vankokhabar.com',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_update_a_category(): void
    {
        $category = Category::create([
            'name' => 'Wildlife',
            'slug' => 'wildlife',
            'description' => 'Animals',
        ]);

        $this->actingAs($this->admin())
            ->post("/admin/categories/{$category->id}/update", [
                'name' => 'Wildlife Conservation',
                'slug' => 'wildlife-conservation',
                'description' => 'Updated description',
            ])
            ->assertRedirect('/admin/categories');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Wildlife Conservation',
            'slug' => 'wildlife-conservation',
        ]);
    }

    public function test_category_update_requires_unique_slug(): void
    {
        Category::create(['name' => 'Wildlife', 'slug' => 'wildlife']);
        $other = Category::create(['name' => 'Climate', 'slug' => 'climate']);

        $this->actingAs($this->admin())
            ->from('/admin/categories')
            ->post("/admin/categories/{$other->id}/update", [
                'name' => 'Climate',
                'slug' => 'wildlife',
            ])
            ->assertRedirect('/admin/categories')
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_add_and_delete_a_gallery_photo(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/admin/gallery', [
                'title' => 'Forest canopy',
                'slug' => 'forest-canopy',
                'image_url' => 'https://example.com/canopy.jpg',
            ])
            ->assertRedirect('/admin/gallery');

        $this->assertDatabaseHas('news', ['slug' => 'forest-canopy', 'media_type' => 'image']);

        $photo = News::firstWhere('slug', 'forest-canopy');

        $this->actingAs($admin)
            ->post("/admin/gallery/{$photo->id}/delete")
            ->assertRedirect('/admin/gallery');

        $this->assertDatabaseMissing('news', ['id' => $photo->id]);
    }

    public function test_gallery_page_offers_media_upload_preview_delete_and_type_filter(): void
    {
        $this->makeMedia(['title' => 'Canopy photo', 'slug' => 'canopy-photo']);

        $response = $this->actingAs($this->admin())->get('/admin/gallery');

        $response->assertOk()
            ->assertSee('Upload media')
            ->assertSee('Filter by type')
            ->assertSee('Media library')
            ->assertSee('Preview')
            ->assertSee('Delete')
            ->assertSee('multipart/form-data')
            ->assertSee('name="media"', false)
            ->assertSee('id="mediaPreviewModal"', false)
            ->assertSee('data-preview-url', false);
    }

    public function test_gallery_media_can_be_filtered_by_type(): void
    {
        $this->makeMedia(['title' => 'Photo one', 'slug' => 'photo-one', 'media_type' => 'image']);
        $this->makeMedia([
            'title' => 'Video one',
            'slug' => 'video-one',
            'media_type' => 'video',
            'image_url' => 'https://example.com/clip.mp4',
        ]);

        $this->actingAs($this->admin())
            ->get('/admin/gallery?type=video')
            ->assertOk()
            ->assertSee('Video one')
            ->assertDontSee('Photo one')
            ->assertSee('Filters applied');

        $this->actingAs(User::first())
            ->get('/admin/gallery?type=image')
            ->assertOk()
            ->assertSee('Photo one')
            ->assertDontSee('Video one');
    }

    public function test_gallery_accepts_a_file_upload_and_detects_its_media_type(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('forest-walk.mp4', 120, 'video/mp4');

        $this->actingAs($this->admin())
            ->post('/admin/gallery', [
                'title' => 'Forest walk',
                'slug' => 'forest-walk',
                'media' => $file,
            ])
            ->assertRedirect('/admin/gallery');

        $news = News::firstWhere('slug', 'forest-walk');

        $this->assertNotNull($news);
        $this->assertSame('video', $news->media_type);
        $this->assertStringContainsString('/storage/media/', $news->image_url);
        $this->assertStorageExists('media');
    }

    public function test_gallery_upload_requires_a_file_or_a_url(): void
    {
        $this->admin();

        $this->actingAs(User::first())
            ->from('/admin/gallery')
            ->post('/admin/gallery', [
                'title' => 'No media attached',
                'slug' => 'no-media-attached',
            ])
            ->assertRedirect('/admin/gallery')
            ->assertSessionHasErrors('media');

        $this->assertDatabaseMissing('news', ['slug' => 'no-media-attached']);

        // The typed values must survive the redirect so the admin does not retype them.
        $this->actingAs(User::first())
            ->get('/admin/gallery')
            ->assertOk()
            ->assertSee('value="No media attached"', false)
            ->assertSee('value="no-media-attached"', false);
    }

    public function test_gallery_detects_media_type_from_an_uploaded_url(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/gallery', [
                'title' => 'Field report',
                'slug' => 'field-report',
                'image_url' => 'https://example.com/docs/field-report.pdf',
            ])
            ->assertRedirect('/admin/gallery');

        $this->assertDatabaseHas('news', ['slug' => 'field-report', 'media_type' => 'document']);
    }

    /**
     * Assert at least one file landed in the public "media" disk directory.
     */
    private function assertStorageExists(string $directory): void
    {
        $this->assertNotEmpty(
            Storage::disk('public')->files($directory),
            "No file was stored in [{$directory}] on the public disk."
        );
    }

    public function test_admin_can_create_an_account_from_settings(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/settings/admins', [
                'name' => 'News Editor',
                'email' => 'editor@vankokhabar.com',
                'password' => 'Secret12345',
                'password_confirmation' => 'Secret12345',
                'role' => 'editor',
            ])
            ->assertRedirect('/admin/settings');

        $this->assertDatabaseHas('users', [
            'email' => 'editor@vankokhabar.com',
            'role' => 'editor',
        ]);
    }

    public function test_account_creation_rejects_duplicate_email(): void
    {
        $this->admin();

        $this->actingAs(User::first())
            ->from('/admin/settings')
            ->post('/admin/settings/admins', [
                'name' => 'Duplicate',
                'email' => 'admin@vankokhabar.com',
                'password' => 'Secret12345',
                'password_confirmation' => 'Secret12345',
                'role' => 'admin',
            ])
            ->assertRedirect('/admin/settings')
            ->assertSessionHasErrors('email');
    }

    public function test_admin_pages_are_paginated(): void
    {
        foreach (range(1, 9) as $i) {
            Category::create([
                'name' => "Category {$i}",
                'slug' => "category-{$i}",
            ]);
        }

        $this->actingAs($this->admin())
            ->get('/admin/categories')
            ->assertOk()
            ->assertSee('page=2');
    }

    public function test_reports_and_settings_are_paginated(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get('/admin/reports')->assertOk()->assertSee('page=2');
        $this->actingAs($admin)->get('/admin/settings')->assertOk()->assertSee('page=2');
    }

    public function test_users_page_shows_registration_records(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/users')
            ->assertOk()
            ->assertSee('Registered users')
            ->assertSee('admin@vankokhabar.com')
            ->assertSee('Joined');
    }

    public function test_settings_page_shows_last_login_and_admin_creator(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/settings')
            ->assertOk()
            ->assertSee('Create admin')
            ->assertSee('Last login');
    }

    public function test_reports_page_shows_business_growth_section(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/reports')
            ->assertOk()
            ->assertSee('New business growth')
            ->assertSee('Report library');
    }

    private function makeArticle(array $overrides = []): News
    {
        static $sequence = 0;
        $sequence++;

        return News::create(array_merge([
            'title' => "Article {$sequence}",
            'slug' => "article-{$sequence}",
            'status' => 'draft',
            'views' => 0,
        ], $overrides));
    }

    /**
     * Gallery rows are News records that carry a media URL.
     *
     * @param  array<string, mixed>  $overrides
     */
    private function makeMedia(array $overrides = []): News
    {
        static $sequence = 0;
        $sequence++;

        return News::create(array_merge([
            'title' => "Media {$sequence}",
            'slug' => "media-{$sequence}",
            'image_url' => "https://example.com/media-{$sequence}.jpg",
            'media_type' => 'image',
            'status' => 'published',
            'views' => 0,
        ], $overrides));
    }

    public function test_articles_page_shows_total_count_and_management_controls(): void
    {
        $this->makeArticle();
        $this->makeArticle(['status' => 'published']);

        $this->actingAs($this->admin())
            ->get('/admin/articles')
            ->assertOk()
            ->assertSee('Total articles')
            ->assertSee('Add new article')
            ->assertSee('Search articles')
            ->assertSee('Filter by category')
            ->assertSee('Publish / Draft status')
            ->assertSee('Featured article');
    }

    public function test_admin_can_edit_an_article(): void
    {
        $category = Category::create(['name' => 'Wildlife', 'slug' => 'wildlife']);
        $article = $this->makeArticle();

        $this->actingAs($this->admin())
            ->from('/admin/articles')
            ->post("/admin/articles/{$article->id}/update", [
                'title' => 'Updated title',
                'slug' => $article->slug,
                'status' => 'published',
                'category_id' => $category->id,
                'featured' => 1,
            ])
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('news', [
            'id' => $article->id,
            'title' => 'Updated title',
            'status' => 'published',
            'category_id' => $category->id,
            'featured' => true,
        ]);
    }

    public function test_article_update_rejects_duplicate_slug(): void
    {
        $this->makeArticle(['slug' => 'taken-slug']);
        $other = $this->makeArticle();

        $this->actingAs($this->admin())
            ->from('/admin/articles')
            ->post("/admin/articles/{$other->id}/update", [
                'title' => $other->title,
                'slug' => 'taken-slug',
                'status' => 'draft',
            ])
            ->assertRedirect('/admin/articles')
            ->assertSessionHasErrors('slug');
    }

    public function test_admin_can_toggle_article_status(): void
    {
        $article = $this->makeArticle(['status' => 'draft']);

        $this->actingAs($this->admin())
            ->from('/admin/articles')
            ->post("/admin/articles/{$article->id}/toggle-status")
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('news', ['id' => $article->id, 'status' => 'published']);

        $this->actingAs(User::first())
            ->from('/admin/articles')
            ->post("/admin/articles/{$article->id}/toggle-status");

        $this->assertDatabaseHas('news', ['id' => $article->id, 'status' => 'draft']);
    }

    public function test_admin_can_toggle_featured_article(): void
    {
        $article = $this->makeArticle();

        $this->actingAs($this->admin())
            ->from('/admin/articles')
            ->post("/admin/articles/{$article->id}/toggle-featured")
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('news', ['id' => $article->id, 'featured' => true]);

        $this->actingAs(User::first())
            ->from('/admin/articles')
            ->post("/admin/articles/{$article->id}/toggle-featured");

        $this->assertDatabaseHas('news', ['id' => $article->id, 'featured' => false]);
    }

    public function test_articles_can_be_searched_and_filtered(): void
    {
        $forest = Category::create(['name' => 'Forest', 'slug' => 'forest']);
        $wildlife = Category::create(['name' => 'Wildlife', 'slug' => 'wildlife']);

        $this->makeArticle(['title' => 'Canopy restoration drive', 'status' => 'published', 'category_id' => $forest->id]);
        $this->makeArticle(['title' => 'Tiger census begins', 'status' => 'draft', 'category_id' => $wildlife->id]);

        $this->actingAs($this->admin())
            ->get('/admin/articles?search=Canopy')
            ->assertOk()
            ->assertSee('Canopy restoration drive')
            ->assertDontSee('Tiger census begins');

        $this->actingAs(User::first())
            ->get("/admin/articles?category_id={$wildlife->id}")
            ->assertOk()
            ->assertSee('Tiger census begins')
            ->assertDontSee('Canopy restoration drive');

        $this->actingAs(User::first())
            ->get('/admin/articles?status=published')
            ->assertOk()
            ->assertSee('Canopy restoration drive')
            ->assertDontSee('Tiger census begins');
    }

    public function test_storing_an_article_can_mark_it_featured(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/articles', [
                'title' => 'Featured story',
                'slug' => 'featured-story',
                'status' => 'published',
                'featured' => 1,
            ])
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('news', [
            'slug' => 'featured-story',
            'featured' => true,
        ]);
    }

    public function test_article_requires_valid_status(): void
    {
        $this->actingAs($this->admin())
            ->from('/admin/articles')
            ->post('/admin/articles', [
                'title' => 'Bad status',
                'slug' => 'bad-status',
                'status' => 'archived',
            ])
            ->assertRedirect('/admin/articles')
            ->assertSessionHasErrors('status');
    }

    public function test_articles_page_does_not_claim_filters_are_active_when_none_are_set(): void
    {
        $response = $this->actingAs($this->admin())->get('/admin/articles');

        $response->assertOk();

        // No filters applied -> the Reset link must not render.
        $this->assertStringNotContainsString('>Reset</a>', $response->getContent());

        // Empty table with no filters -> plain empty state, not the "filters" message.
        $response->assertSee('No articles yet.');
        $response->assertDontSee('No articles match your filters.');
    }

    public function test_articles_page_shows_filter_empty_state_when_a_filter_matches_nothing(): void
    {
        $this->makeArticle(['title' => 'Something else', 'slug' => 'something-else']);

        $response = $this->actingAs($this->admin())->get('/admin/articles?search=zzz-no-match');

        $response->assertOk();
        $response->assertSee('No articles match your filters.');
        $response->assertSee('>Reset</a>', false);
    }

    public function test_articles_page_renders_styled_form_inputs(): void
    {
        // .form-input must come from the compiled stylesheet, not an @apply inside a
        // Blade <style> block (which browsers drop as an unknown at-rule).
        $response = $this->actingAs($this->admin())->get('/admin/articles');

        $response->assertOk();
        $response->assertDontSee('@apply', false);
        $response->assertDontSee('.form-input { @apply', false);
    }
}
