<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu - JOGO Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">☕ Katalog Menu JOGO Kopi</h1>

        <!-- Form Pencarian & Filter -->
        <form method="GET" action="{{ route('catalog.index') }}" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu kopi..." class="border p-2 rounded w-1/3">
            <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded">Cari</button>
        </form>

        <!-- Daftar Menu -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($menus as $menu)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-xl font-semibold">{{ $menu->name }}</h2>
                    <p class="text-gray-600 mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-500 mb-4">{{ $menu->description }}</p>
                    
                    <!-- Tombol Tambah ke Keranjang (CP-7) -->
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <button type="submit" class="bg-green-600 text-white w-full py-2 rounded hover:bg-green-700">
                            + Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">Menu tidak ditemukan.</p>
            @endforelse
        </div>
    </div>
</body>
</html>