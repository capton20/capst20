<?php

namespace Tests\Feature;

use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_shows_available_menus_only(): void
    {
        Menu::factory()->create(['name' => 'Kopi Tersedia']);
        Menu::factory()->create(['name' => 'Kopi Kosong', 'is_available' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Kopi Tersedia')
            ->assertDontSee('Kopi Kosong');
    }
}
