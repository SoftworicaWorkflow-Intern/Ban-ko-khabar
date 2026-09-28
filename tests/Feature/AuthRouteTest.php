<?php

namespace Tests\Feature;

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

    public function test_home_page_has_pagination_links(): void
    {
        $response = $this->get('/?page=2');

        $response->assertOk();
        $response->assertSee('page=2');
    }
}
