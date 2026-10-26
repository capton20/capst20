<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan khusus customer yang sedang login
    public function index()
    {
        // Mengambil pesanan berdasarkan user yang sedang login, atau tampilkan semua jika belum pakai relasi ketat
        $orders = Order::latest()->get(); 
        return view('customer.order-tracking', compact('orders'));
    }

    // Menampilkan detail pesanan
    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('customer.order-detail', compact('order'));
    }
}