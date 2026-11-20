<?php

namespace Tests\Feature;

use App\Models\DiningTable;
use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KasirOrderFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_mark_menu_as_sold_out_and_customer_cannot_add_it(): void
    {
        $kasir = User::factory()->kasir()->create();
        $menu = Menu::factory()->create();

        $this->actingAs($kasir)->patch(route('kasir.menus.availability', $menu))->assertSessionHas('success');
        $this->assertFalse($menu->fresh()->is_available);

        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer)->post(route('cart.store'), ['menu_id' => $menu->id])->assertSessionHas('error');
        $this->assertEmpty(session('cart', []));
    }

    public function test_customer_only_sees_own_orders(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $mine = Order::create(['user_id' => $customer->id, 'order_type' => 'takeaway', 'total_price' => 10000, 'status' => 'diproses']);
        $theirs = Order::create(['user_id' => $other->id, 'order_type' => 'takeaway', 'total_price' => 99000, 'status' => 'pending']);

        $this->actingAs($customer)->get(route('orders.index'))
            ->assertOk()
            ->assertSee($mine->code)
            ->assertDontSee($theirs->code);

        $this->get(route('orders.show', $mine->id))->assertOk()->assertSee('Sedang Diracik');
        $this->get(route('orders.show', $theirs->id))->assertNotFound();
    }

    public function test_customer_pages_render(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menu = Menu::factory()->create(['name' => 'Kopi Tes']);
        DiningTable::create(['number' => '09', 'capacity' => 2]);

        $this->actingAs($customer)->get(route('catalog.index'))->assertOk()->assertSee('Kopi Tes');
        $this->post(route('cart.store'), ['menu_id' => $menu->id]);
        $this->get(route('cart.index'))->assertOk()->assertSee('Kopi Tes')->assertSee('09');
        $this->get(route('dashboard'))->assertRedirect(route('catalog.index'));
    }

    public function test_customer_cannot_open_kasir_pages(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get(route('kasir.orders.index'))->assertForbidden();
    }

    public function test_admin_can_create_table_with_unique_number(): void
    {
        $admin = User::factory()->admin()->create();
        DiningTable::create(['number' => '01', 'capacity' => 2]);

        $this->actingAs($admin)->post(route('admin.tables.store'), ['number' => '01', 'capacity' => 4])
            ->assertSessionHasErrors('number');

        $this->actingAs($admin)->post(route('admin.tables.store'), ['number' => '02', 'capacity' => 0])
            ->assertSessionHasErrors('capacity');

        $this->actingAs($admin)->post(route('admin.tables.store'), ['number' => '02', 'capacity' => 4, 'is_active' => 1])
            ->assertRedirect(route('admin.tables.index'));
        $this->assertDatabaseHas('dining_tables', ['number' => '02', 'capacity' => 4, 'is_active' => true]);

        $this->get(route('admin.tables.index'))->assertOk()->assertSee('Meja 02');
        $this->get(route('admin.tables.edit', DiningTable::first()))->assertOk();
    }

    public function test_dine_in_checkout_requires_table_and_saves_items(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menu = Menu::factory()->create(['price' => 22000]);
        $table = DiningTable::create(['number' => '07', 'capacity' => 2]);

        $this->actingAs($customer)->post(route('cart.store'), ['menu_id' => $menu->id, 'note' => 'Less sugar']);
        $this->actingAs($customer)->post(route('cart.store'), ['menu_id' => $menu->id]);

        $this->post(route('cart.checkout'), ['order_type' => 'dine_in'])->assertSessionHasErrors('dining_table_id');

        $this->post(route('cart.checkout'), ['order_type' => 'dine_in', 'dining_table_id' => $table->id])
            ->assertRedirect(route('orders.index'));

        $order = Order::with('items')->first();
        $this->assertSame('pending', $order->status);
        $this->assertSame($table->id, $order->dining_table_id);
        $this->assertEquals(44000, $order->total_price);
        $this->assertSame(2, $order->items->first()->quantity);
        $this->assertSame('Less sugar', $order->items->first()->note);
    }

    public function test_takeaway_checkout_has_no_table(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $menu = Menu::factory()->create();

        $this->actingAs($customer)->post(route('cart.store'), ['menu_id' => $menu->id]);
        $this->post(route('cart.checkout'), ['order_type' => 'takeaway', 'dining_table_id' => 999]);

        $this->assertDatabaseHas('orders', ['order_type' => 'takeaway', 'dining_table_id' => null]);
    }

    public function test_kasir_sees_incoming_order_and_moves_it_through_statuses(): void
    {
        $kasir = User::factory()->kasir()->create();
        $customer = User::factory()->create(['name' => 'Dimas Arya']);
        $order = Order::create(['user_id' => $customer->id, 'order_type' => 'takeaway', 'total_price' => 22000, 'status' => 'pending']);
        $order->items()->create(['menu_name' => 'Kopi Susu', 'price' => 22000, 'quantity' => 1, 'note' => 'Es sedikit']);

        $this->actingAs($kasir)->get(route('kasir.orders.index'))
            ->assertOk()
            ->assertSee('Dimas Arya')
            ->assertSee('Es sedikit');

        $this->actingAs($kasir)->get(route('kasir.orders.board'))->assertOk()->assertSee('Kopi Susu');

        foreach (['diterima', 'diproses', 'siap', 'selesai'] as $status) {
            $this->patch(route('kasir.orders.status', $order), ['status' => $status])->assertSessionHas('success');
            $this->assertSame($status, $order->fresh()->status);
        }

        // Pesanan selesai tidak boleh diubah lagi
        $this->patch(route('kasir.orders.status', $order), ['status' => 'pending'])->assertSessionHas('error');
        $this->assertSame('selesai', $order->fresh()->status);
    }
}
