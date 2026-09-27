<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_requires_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_login_accepts_default_credentials(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@vankokhabar.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@vankokhabar.com',
            'password' => 'Admin@123',
        ]);

        $response->assertRedirect('/admin');
    }

    public function test_admin_navigation_pages_are_available(): void
    {
        User::factory()->create([
            'email' => 'admin@vankokhabar.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        $this->actingAs(User::first())
            ->get('/admin/articles')
            ->assertOk();

        $this->actingAs(User::first())
            ->get('/admin/categories')
            ->assertOk();

        $this->actingAs(User::first())
            ->get('/admin/gallery')
            ->assertOk();

        $this->actingAs(User::first())
            ->get('/admin/users')
            ->assertOk();

        $this->actingAs(User::first())
            ->get('/admin/reports')
            ->assertOk();

        $this->actingAs(User::first())
            ->get('/admin/settings')
            ->assertOk();
    }

    public function test_admin_categories_are_loaded_from_database(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@vankokhabar.com',
            'role' => 'admin',
        ]);

        Category::create([
            'name' => 'Forest Conservation',
            'slug' => 'forest-conservation',
            'description' => 'Tree and habitat protection',
        ]);

        $response = $this->actingAs($admin)
            ->get('/admin/categories');

        $response->assertOk();
        $response->assertSee('Forest Conservation');
    }

    public function test_admin_can_create_news_and_update_password_timestamp(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@vankokhabar.com',
            'role' => 'admin',
            'password_changed_at' => now()->subDays(10),
        ]);

        $category = Category::create([
            'name' => 'Climate Change',
            'slug' => 'climate-change',
            'description' => 'Coverage of climate impacts',
        ]);

        $this->actingAs($admin)
            ->post('/admin/articles', [
                'title' => 'New climate initiative',
                'slug' => 'new-climate-initiative',
                'excerpt' => 'A new story about local climate work.',
                'content' => 'Detailed content body.',
                'category_id' => $category->id,
                'status' => 'published',
                'image_url' => 'https://example.com/forest.jpg',
                'author' => 'Admin User',
            ])
            ->assertRedirect('/admin/articles');

        $this->assertDatabaseHas('news', ['slug' => 'new-climate-initiative']);

        $this->actingAs($admin)
            ->post('/admin/settings/password', [
                'current_password' => 'password',
                'password' => 'NewPassword123',
                'password_confirmation' => 'NewPassword123',
            ])
            ->assertRedirect('/admin/settings');

        $admin->refresh();
        $this->assertNotNull($admin->password_changed_at);
        $this->assertTrue($admin->password_changed_at->isPast());
    }
}
