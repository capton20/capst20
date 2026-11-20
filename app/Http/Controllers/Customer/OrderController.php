<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan milik customer yang sedang login
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with(['diningTable', 'items'])->latest()->get();

        return view('customer.order-tracking', compact('orders'));
    }

    // Menampilkan detail pesanan (hanya pesanan milik sendiri)
    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()->with(['diningTable', 'items'])->findOrFail($id);

        return view('customer.order-detail', compact('order'));
    }
}
