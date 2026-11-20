<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DiningTable;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    // Menampilkan halaman keranjang belanja
    public function index()
    {
        $cart = session()->get('cart', []);
        $tables = DiningTable::where('is_active', true)->orderBy('number')->get();

        return view('customer.cart', compact('cart', 'tables'));
    }

    // Menambah menu ke keranjang (beserta catatan jika ada)
    public function store(Request $request)
    {
        $menuId = $request->input('menu_id');
        $note = $request->input('note', ''); // Tangkap catatan dari form
        $menu = Menu::findOrFail($menuId);

        if (! $menu->is_available) {
            return redirect()->back()->with('error', "Maaf, {$menu->name} sedang habis.");
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$menuId])) {
            $cart[$menuId]['quantity']++;
            // Jika ada catatan baru, perbarui catatan
            if (!empty($note)) {
                $cart[$menuId]['note'] = $note;
            }
        } else {
            $cart[$menuId] = [
                "name" => $menu->name,
                "quantity" => 1,
                "price" => $menu->price,
                "note" => $note,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }

    // Mengubah jumlah menu (+ / -) DAN catatan pesanan
    public function update(Request $request, $id)
    {
        $quantity = $request->input('quantity');
        $note = $request->input('note', '');

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
                $cart[$id]['note'] = $note; // Simpan pembaruan catatan
            } else {
                unset($cart[$id]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Keranjang belanja berhasil diperbarui!');
    }

    // Menghapus menu dari keranjang
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        // 1. Ambil data keranjang dari session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong!');
        }

        // 2. Validasi jenis pesanan & nomor meja (PBI-8)
        $validated = $request->validate([
            'order_type' => ['required', Rule::in(['dine_in', 'takeaway'])],
            'dining_table_id' => [
                'exclude_if:order_type,takeaway',
                'required',
                Rule::exists('dining_tables', 'id')->where('is_active', true),
            ],
        ], [
            'dining_table_id.required' =>'Pilih nomor meja untuk pesanan dine-in.',
            'dining_table_id.exists' => 'Meja yang dipilih tidak tersedia.',
        ]);

        // 3. Ambil harga & status terbaru dari database, bukan dari session
        $menus = Menu::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $habis = collect($cart)->keys()->filter(fn ($id) => ! $menus->get($id)?->is_available);

        if ($habis->isNotEmpty()) {
            $names = $habis->map(fn ($id) => $cart[$id]['name'])->implode(', ');

            return redirect()->route('cart.index')->with('error', "Menu berikut sedang habis: {$names}. Hapus dulu dari keranjang.");
        }

        $totalPrice = collect($cart)->sum(fn ($item, $id) => $menus[$id]->price * $item['quantity']);

        // 4. Simpan pesanan beserta item-itemnya
        DB::transaction(function () use ($cart, $menus, $validated, $totalPrice) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_type' => $validated['order_type'],
                'dining_table_id' => $validated['dining_table_id'] ?? null,
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            foreach ($cart as $id => $item) {
                $order->items()->create([
                    'menu_id' => $id,
                    'menu_name' => $menus[$id]->name,
                    'price' => $menus[$id]->price,
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?: null,
                ]);
            }
        });

        // 4. Bersihkan keranjang setelah checkout
        session()->forget('cart');

        // 5. Arahkan otomatis ke halaman Order Tracking (/orders)
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
        }

}