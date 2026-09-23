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

        $response->assertRedirect();
    }
}
