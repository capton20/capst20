<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_management_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Pengelolaan Akun Pengguna');
    }

    public function test_admin_can_search_users(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['name' => 'Budi Santoso', 'email' => 'budi@example.com']);
        User::factory()->create(['name' => 'Siti Aminah', 'email' => 'siti@example.com']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Budi']));

        $response->assertStatus(200);
        $response->assertSee('Budi Santoso');
        $response->assertDontSee('Siti Aminah');
    }

    public function test_admin_can_create_new_user_with_hashed_password(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Baru Kasir',
            'email' => 'barukasir@jogokopi.com',
            'role' => 'kasir',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'barukasir@jogokopi.com',
            'role' => 'kasir',
        ]);

        $newUser = User::where('email', 'barukasir@jogokopi.com')->first();
        $this->assertTrue(Hash::check('secret123', $newUser->password));
    }

    public function test_creating_user_with_duplicate_email_fails(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->create(['email' => 'existing@jogokopi.com']);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Duplikat User',
            'email' => 'existing@jogokopi.com',
            'role' => 'kasir',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_can_update_user(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->kasir()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $targetUser), [
            'name' => 'Nama Baru',
            'email' => 'namabaru@jogokopi.com',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Nama Baru',
            'email' => 'namabaru@jogokopi.com',
            'role' => 'admin',
        ]);
    }

    public function test_admin_cannot_change_their_own_role(): void
    {
        $admin = User::factory()->admin()->create();
        // Create another admin so it's not the last admin constraint
        User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'kasir',
        ]);

        $response->assertSessionHas('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        $this->assertEquals('admin', $admin->fresh()->role);
    }

    public function test_admin_cannot_downgrade_the_last_admin(): void
    {
        $admin = User::factory()->admin()->create();
        $anotherAdmin = User::factory()->admin()->create();

        // Acting as anotherAdmin, trying to downgrade the only other admin when count is handled
        // If there's only 1 admin left:
        $anotherAdmin->delete(); // Now only $admin is left
        $this->assertEquals(1, User::where('role', 'admin')->count());

        // A fake request targeting the last admin
        $kasir = User::factory()->kasir()->create();
        // Acting as admin trying to downgrade last admin
        $response = $this->actingAs($admin)->put(route('admin.users.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'kasir',
        ]);

        $this->assertEquals('admin', $admin->fresh()->role);
    }

    public function test_admin_can_update_user_password(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->kasir()->create();

        $response = $this->actingAs($admin)->put(route('admin.users.password.update', $targetUser), [
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertTrue(Hash::check('newpassword123', $targetUser->fresh()->password));
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = User::factory()->admin()->create();
        $targetUser = User::factory()->kasir()->create();

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $targetUser));

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $targetUser->id]);
    }

    public function test_admin_cannot_delete_themselves(): void
    {
        $admin = User::factory()->admin()->create();
        User::factory()->admin()->create(); // second admin

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang masuk.');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_cannot_delete_the_last_admin(): void
    {
        $admin1 = User::factory()->admin()->create();
        $admin2 = User::factory()->admin()->create();

        // admin1 deletes admin2
        $response = $this->actingAs($admin1)->delete(route('admin.users.destroy', $admin2));
        $response->assertSessionHas('success');

        // Now admin1 is the only admin
        $response = $this->actingAs($admin1)->delete(route('admin.users.destroy', $admin1));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin1->id]);
    }

    public function test_kasir_is_forbidden_from_user_management(): void
    {
        $kasir = User::factory()->kasir()->create();

        $this->actingAs($kasir)->get(route('admin.users.index'))->assertStatus(403);
        $this->actingAs($kasir)->get(route('admin.users.create'))->assertStatus(403);
        $this->actingAs($kasir)->post(route('admin.users.store'), [])->assertStatus(403);
    }
}
