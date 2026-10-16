<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryAndMenuManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_category_list_with_menu_count(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Signature Coffee']);
        Menu::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Signature Coffee');
        $response->assertSee('3 menu');
    }

    public function test_admin_can_create_category_with_auto_generated_slug(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Manual Brew V60',
            'description' => 'Kopi seduh manual pilihan.',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'name' => 'Manual Brew V60',
            'slug' => 'manual-brew-v60',
            'description' => 'Kopi seduh manual pilihan.',
        ]);
    }

    public function test_category_name_must_be_unique(): void
    {
        $admin = User::factory()->admin()->create();
        Category::factory()->create(['name' => 'Espresso Based']);

        $response = $this->actingAs($admin)->post(route('admin.categories.store'), [
            'name' => 'Espresso Based',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_category(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Kategori Lama', 'slug' => 'kategori-lama']);

        $response = $this->actingAs($admin)->put(route('admin.categories.update', $category), [
            'name' => 'Kategori Baru',
            'description' => 'Deskripsi Baru',
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Kategori Baru',
            'slug' => 'kategori-baru',
        ]);
    }

    public function test_cannot_delete_category_with_assigned_menus(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create(['name' => 'Non Kopi']);
        Menu::factory()->create(['category_id' => $category->id]);

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }

    public function test_can_delete_empty_category(): void
    {
        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_view_menus_with_search_and_filter(): void
    {
        $admin = User::factory()->admin()->create();
        $cat1 = Category::factory()->create(['name' => 'Espresso']);
        $cat2 = Category::factory()->create(['name' => 'Snack']);

        $menu1 = Menu::factory()->create(['category_id' => $cat1->id, 'name' => 'Americano Dingin']);
        $menu2 = Menu::factory()->create(['category_id' => $cat2->id, 'name' => 'Kentang Goreng']);

        // Search test
        $response = $this->actingAs($admin)->get(route('admin.menus.index', ['search' => 'Americano']));
        $response->assertStatus(200);
        $response->assertSee('Americano Dingin');
        $response->assertDontSee('Kentang Goreng');

        // Filter category test
        $response2 = $this->actingAs($admin)->get(route('admin.menus.index', ['category_id' => $cat2->id]));
        $response2->assertStatus(200);
        $response2->assertSee('Kentang Goreng');
        $response2->assertDontSee('Americano Dingin');
    }

    public function test_admin_can_create_menu_with_image_upload(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();
        $file = UploadedFile::fake()->image('kopi-susu.jpg', 600, 600);

        $response = $this->actingAs($admin)->post(route('admin.menus.store'), [
            'name' => 'Kopi Susu Aren JOGO',
            'category_id' => $category->id,
            'price' => 22000,
            'description' => 'Espresso dengan gula aren dan susu murni.',
            'image' => $file,
        ]);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('menus', [
            'name' => 'Kopi Susu Aren JOGO',
            'category_id' => $category->id,
            'price' => 22000,
        ]);

        $menu = Menu::where('name', 'Kopi Susu Aren JOGO')->first();
        $this->assertNotNull($menu->image);
        Storage::disk('public')->assertExists($menu->image);
    }

    public function test_menu_validation_rules_are_enforced(): void
    {
        $admin = User::factory()->admin()->create();

        // Missing required fields
        $response = $this->actingAs($admin)->post(route('admin.menus.store'), []);
        $response->assertSessionHasErrors(['name', 'category_id', 'price']);

        // Negative price and invalid category
        $response2 = $this->actingAs($admin)->post(route('admin.menus.store'), [
            'name' => 'Test Menu',
            'category_id' => 99999,
            'price' => -5000,
        ]);
        $response2->assertSessionHasErrors(['category_id', 'price']);
    }

    public function test_admin_can_update_menu_and_replace_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $oldImage = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldImage->store('menus', 'public');

        $menu = Menu::factory()->create([
            'category_id' => $category->id,
            'name' => 'Menu Awal',
            'image' => $oldPath,
        ]);

        Storage::disk('public')->assertExists($oldPath);

        $newImage = UploadedFile::fake()->image('new.jpg');

        $response = $this->actingAs($admin)->put(route('admin.menus.update', $menu), [
            'name' => 'Menu Diperbarui',
            'category_id' => $category->id,
            'price' => 30000,
            'image' => $newImage,
        ]);

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success');

        $menu->refresh();
        $this->assertEquals('Menu Diperbarui', $menu->name);
        // Old image must be removed
        Storage::disk('public')->assertMissing($oldPath);
        // New image must exist
        Storage::disk('public')->assertExists($menu->image);
    }

    public function test_admin_can_delete_menu_and_image_is_removed(): void
    {
        Storage::fake('public');

        $admin = User::factory()->admin()->create();
        $category = Category::factory()->create();

        $image = UploadedFile::fake()->image('menu-foto.jpg');
        $imagePath = $image->store('menus', 'public');

        $menu = Menu::factory()->create([
            'category_id' => $category->id,
            'image' => $imagePath,
        ]);

        Storage::disk('public')->assertExists($imagePath);

        $response = $this->actingAs($admin)->delete(route('admin.menus.destroy', $menu));

        $response->assertRedirect(route('admin.menus.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
        Storage::disk('public')->assertMissing($imagePath);
    }

    public function test_kasir_is_forbidden_from_category_and_menu_crud(): void
    {
        $kasir = User::factory()->kasir()->create();
        $category = Category::factory()->create();
        $menu = Menu::factory()->create(['category_id' => $category->id]);

        $this->actingAs($kasir)->get(route('admin.categories.index'))->assertStatus(403);
        $this->actingAs($kasir)->post(route('admin.categories.store'), [])->assertStatus(403);
        $this->actingAs($kasir)->delete(route('admin.categories.destroy', $category))->assertStatus(403);

        $this->actingAs($kasir)->get(route('admin.menus.index'))->assertStatus(403);
        $this->actingAs($kasir)->post(route('admin.menus.store'), [])->assertStatus(403);
        $this->actingAs($kasir)->delete(route('admin.menus.destroy', $menu))->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect('/login');
        $this->get(route('admin.menus.index'))->assertRedirect('/login');
    }
}
