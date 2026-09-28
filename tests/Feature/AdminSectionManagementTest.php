<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->assertDatabaseHas('news', ['slug' => 'forest-canopy']);

        $photo = News::firstWhere('slug', 'forest-canopy');

        $this->actingAs($admin)
            ->post("/admin/gallery/{$photo->id}/delete")
            ->assertRedirect('/admin/gallery');

        $this->assertDatabaseMissing('news', ['id' => $photo->id]);
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
}
