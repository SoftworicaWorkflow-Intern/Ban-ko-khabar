<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthRouteTest extends TestCase
{
    public function test_login_post_is_supported(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@vankokhabar.com',
            'password' => 'Admin@123',
        ]);

        $response->assertRedirect('/admin');
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
}
