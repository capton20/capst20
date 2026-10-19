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
        
        <!-- Hitung Total Item di Keranjang -->
        @php
            $cart = session()->get('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        @endphp

        <!-- Header dengan Tombol Keranjang & Badge -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">☕ Katalog Menu JOGO Kopi</h1>
            
            <a href="{{ route('cart.index') }}" class="relative bg-amber-600 hover:bg-amber-700 text-white font-semibold px-5 py-2.5 rounded-lg shadow flex items-center gap-2 transition">
                🛒 Lihat Keranjang
                @if($cartCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full border-2 border-white animate-bounce">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
        </div>

        <!-- Notifikasi Sukses dengan Tombol Modern -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-xl mb-6 flex flex-col sm:flex-row justify-between items-center shadow-sm gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xl">✨</span>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <a href="{{ route('cart.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-lg shadow transition flex items-center gap-1.5">
                    🛒 Lihat Keranjang Sekarang
                </a>
            </div>
        @endif

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('catalog.index') }}" class="mb-6 flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari menu kopi..." class="border p-2 rounded w-1/3 shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded font-semibold shadow">Cari</button>
        </form>

        <!-- Daftar Menu -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($menus as $menu)
                <div class="bg-white p-5 rounded-lg shadow flex flex-col justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $menu->name }}</h2>
                        <p class="text-amber-600 font-semibold mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $menu->description }}</p>
                    </div>
                    
                    <!-- Form Tambah ke Keranjang + Catatan -->
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        
                        <input type="text" name="note" placeholder="📝 Catatan (cth: Less sugar, es sedikit)..." 
                               class="w-full text-xs border rounded p-2 mb-3 focus:outline-none focus:ring-1 focus:ring-amber-500">

                        <button type="submit" class="bg-green-600 text-white w-full py-2.5 rounded-lg hover:bg-green-700 font-semibold shadow transition">
                            + Tambah ke Keranjang
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-gray-500">Menu tidak ditemukan atau belum ada data menu.</p>
            @endforelse
        </div>
    </div>
</body>
</html>