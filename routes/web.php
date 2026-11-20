<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiningTableController;
use App\Http\Controllers\Kasir\MenuAvailabilityController;
use App\Http\Controllers\Kasir\OrderController as KasirOrderController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CatalogController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $menus = Menu::with('category')->withCount('likedBy as likes_count')->where('is_available', true)->latest()->take(6)->get();

    return view('welcome', compact('menus'));
});

Route::get('/dashboard', function (Request $request) {
    if ($request->user() && $request->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if ($request->user() && $request->user()->isKasir()) {
        return redirect()->route('kasir.orders.index');
    }
    return redirect()->route('catalog.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengelolaan Akun Pengguna & Hak Akses (PBI-02)
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{user}/password', [UserController::class, 'editPassword'])->name('users.password.edit');
    Route::put('/users/{user}/password', [UserController::class, 'updatePassword'])->name('users.password.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Pengelolaan Kategori (PBI-03)
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Pengelolaan Menu (PBI-03)
    Route::resource('menus', MenuController::class)->except(['show']);
    Route::post('/menus/{menu}/like', [MenuController::class, 'toggleLike'])->name('menus.like'); // PBI-12

    // Pengelolaan Meja (PBI-05)
    Route::resource('tables', DiningTableController::class)->except(['show']);
    Route::patch('/tables/{table}/toggle', [DiningTableController::class, 'toggle'])->name('tables.toggle');
});

// ==========================================
// ROUTE KASIR (PBI-4, PBI-9, PBI-10)
// ==========================================
Route::middleware(['auth', 'role:kasir,admin'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/menus', [MenuAvailabilityController::class, 'index'])->name('menus.index');
    Route::patch('/menus/available-all', [MenuAvailabilityController::class, 'markAllAvailable'])->name('menus.available-all');
    Route::patch('/menus/{menu}/availability', [MenuAvailabilityController::class, 'update'])->name('menus.availability');

    Route::get('/orders', [KasirOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/board', [KasirOrderController::class, 'board'])->name('orders.board');
    Route::patch('/orders/{order}/status', [KasirOrderController::class, 'updateStatus'])->name('orders.status');
});

// ==========================================
// ROUTE PELANGGAN (Sprint 1: PBI-6, PBI-7, PBI-11)
// ==========================================
Route::middleware(['auth'])->group(function () {
    // PBI-6: Katalog Menu & Pencarian/Filter
    Route::get('/catalog', [App\Http\Controllers\Customer\CatalogController::class, 'index'])->name('catalog.index');
    
    // PBI-7: Keranjang Belanja (Cart)
    Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [App\Http\Controllers\Customer\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/update/{id}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\Customer\CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [App\Http\Controllers\Customer\CartController::class, 'checkout'])->name('cart.checkout');

    // PBI-11: Tracking / Pantau Status Pesanan
    Route::get('/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('orders.show');
});

require __DIR__.'/auth.php';
