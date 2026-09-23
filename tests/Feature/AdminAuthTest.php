<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    public function test_admin_requires_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_login_accepts_default_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@vankokhabar.com',
            'password' => 'Admin@123',
        ]);

        $response->assertRedirect('/admin');
    }
}
