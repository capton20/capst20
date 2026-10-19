<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class CartController extends Controller
{
    // Menampilkan halaman keranjang belanja
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart', compact('cart'));
    }

    // Menambah menu ke keranjang (beserta catatan jika ada)
    public function store(Request $request)
    {
        $menuId = $request->input('menu_id');
        $note = $request->input('note', ''); // Tangkap catatan dari form
        $menu = Menu::findOrFail($menuId);

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

        return redirect()->route('cart.index')->with('success', 'Keranjang belanja berhasil diperbarui!');
    }

    // Menghapus menu dari keranjang
    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Menu berhasil dihapus dari keranjang!');
    }
}