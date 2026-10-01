<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_top_navigation_bar_renders_all_required_components(): void
    {
        $admin = User::create([
            'name' => 'Prabesh Sharma',
            'email' => 'admin@vankokhabar.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();

        // 1. Left Section components
        $response->assertSee('id="adminSidebarToggle"', false);
        $response->assertSee('id="btnWebsiteToggle"', false);

        // 2. Center Section (Information Pill Cards)
        $response->assertSee('Live Clock', false);
        $response->assertSee('navLiveClock', false);

        $response->assertSee('नेपाली पात्रो (वि.सं.)');
        $response->assertSee('navNepaliDate', false);
        $response->assertSee('navNepaliWeekday', false);

        $response->assertSee('Last Login', false);
        $response->assertSee('Active', false);

        $response->assertSee('Hi,');
        $response->assertSee('Prabesh Sharma');

        // 3. User Profile Dropdown components
        $response->assertSee('id="userProfileDropdown"', false);
        $response->assertSee('admin@vankokhabar.com');
        $response->assertSee('Newsroom Settings');
        $response->assertSee('Editorial Pipeline');
        $response->assertSee('Logout from CMS');

        // 4. Right Section (Company Logo)
        $response->assertSee('image/fev icon.png');
        $response->assertSee('Ban ko khabar logo');
    }

    public function test_admin_navigation_is_present_across_all_admin_subpages(): void
    {
        $admin = User::create([
            'name' => 'Newsroom Lead',
            'email' => 'lead@vankokhabar.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        $subpages = [
            '/admin/articles',
            '/admin/categories',
            '/admin/gallery',
            '/admin/users',
            '/admin/reports',
            '/admin/settings/password',
            '/admin/settings/admins',
        ];

        foreach ($subpages as $url) {
            $response = $this->actingAs($admin)->get($url);
            $response->assertOk();
            $response->assertSee('id="adminSidebarToggle"', false);
            $response->assertSee('Live Clock', false);
            $response->assertSee('नेपाली पात्रो (वि.सं.)');
        }
    }
}
