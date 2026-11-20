<?php

namespace Tests\Feature;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_like_and_unlike_menu(): void
    {
        $admin = User::factory()->admin()->create();
        $menu = Menu::factory()->create();

        $this->actingAs($admin)->post(route('admin.menus.like', $menu))->assertSessionHas('success');
        $this->assertSame(1, $menu->likedBy()->count());

        // Like kedua dari admin yang sama membatalkan like, bukan menambah
        $this->post(route('admin.menus.like', $menu));
        $this->assertSame(0, $menu->likedBy()->count());
    }

    public function test_like_count_comes_from_different_admins(): void
    {
        $menu = Menu::factory()->create(['name' => 'Kopi Favorit']);
        $menu->likedBy()->attach(User::factory()->admin()->count(3)->create());

        $this->get('/')->assertOk()->assertSee('3 like dari JOGO KOPI', false);

        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer)->get(route('catalog.index'))->assertOk()->assertSee('3 like dari JOGO KOPI', false);

        $admin = User::factory()->admin()->create();
        $this->actingAs($admin)->get(route('admin.menus.index'))->assertOk()->assertSee('Beri like');
    }

    public function test_only_admin_can_like_menu(): void
    {
        $menu = Menu::factory()->create();

        $this->actingAs(User::factory()->kasir()->create())->post(route('admin.menus.like', $menu))->assertForbidden();
        $this->actingAs(User::factory()->create(['role' => 'customer']))->post(route('admin.menus.like', $menu))->assertForbidden();
        $this->assertSame(0, $menu->likedBy()->count());
    }
}
