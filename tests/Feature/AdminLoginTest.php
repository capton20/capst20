<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_valid_credentials_and_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@jogokopi.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@jogokopi.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($admin);
        $response->assertRedirect(route('admin.dashboard', absolute: false));
    }

    public function test_kasir_can_login_with_valid_credentials_and_redirects_to_kasir_dashboard(): void
    {
        $kasir = User::factory()->kasir()->create([
            'email' => 'kasir@jogokopi.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => 'kasir@jogokopi.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($kasir);
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_admin_cannot_login_with_invalid_password(): void
    {
        User::factory()->admin()->create([
            'email' => 'admin@jogokopi.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@jogokopi.com',
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/login');
    }

    public function test_kasir_cannot_access_admin_dashboard(): void
    {
        $kasir = User::factory()->kasir()->create();

        $response = $this->actingAs($kasir)->get('/admin/dashboard');

        $response->assertStatus(403);
    }

    public function test_admin_accessing_general_dashboard_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_logout_and_session_is_terminated(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
