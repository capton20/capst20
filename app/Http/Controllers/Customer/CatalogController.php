<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu; // Pastikan model Menu sudah ada
use App\Models\Category; // Pastikan model Category sudah ada

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data kategori untuk filter
        $categories = Category::all();

        // Query data menu berdasarkan pencarian atau kategori
        $query = Menu::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $menus = $query->get();

        return view('customer.catalog', compact('menus', 'categories'));
    }
}