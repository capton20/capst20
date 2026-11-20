<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuAvailabilityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Menu::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status === 'tersedia') {
            $query->where('is_available', true);
        } elseif ($request->status === 'habis') {
            $query->where('is_available', false);
        }

        $menus = $query->orderBy('name')->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        $stats = [
            'total' => Menu::count(),
            'tersedia' => Menu::where('is_available', true)->count(),
            'habis' => Menu::where('is_available', false)->count(),
        ];

        return view('kasir.menus.index', compact('menus', 'categories', 'stats'));
    }

    public function update(Menu $menu): RedirectResponse
    {
        $menu->update(['is_available' => ! $menu->is_available]);

        $status = $menu->is_available ? 'Tersedia' : 'Habis';

        return back()->with('success', "Status {$menu->name} diubah menjadi {$status}.");
    }

    public function markAllAvailable(): RedirectResponse
    {
        Menu::where('is_available', false)->update(['is_available' => true]);

        return back()->with('success', 'Semua menu ditandai tersedia.');
    }
}
