<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index(Request $request): View
    {
        $query = Menu::with('category');

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menus = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    /**
     * Show the form for creating a new menu.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created menu in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu makanan/minuman berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified menu.
     */
    public function edit(Menu $menu): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified menu in storage.
     */
    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $imagePath = $menu->image;
        if ($request->hasFile('image')) {
            // Delete previous image file safely if exists
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu makanan/minuman berhasil diperbarui.');
    }

    /**
     * Remove the specified menu from storage.
     */
    public function destroy(Menu $menu): RedirectResponse
    {
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
