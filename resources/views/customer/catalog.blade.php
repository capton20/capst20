<x-customer-layout title="Katalog Menu">
    @php
        $cart = session('cart', []);
        $cartTotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
    @endphp

    <x-slot name="banner">
        <div class="bg-espresso text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex items-center gap-4">
                <span class="w-11 h-11 shrink-0 rounded-full bg-coffee-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M5 10v9m14-9v9M7 6h10l2 4H5l2-4z" /></svg>
                </span>
                <div>
                    <p class="font-bold text-lg flex flex-wrap items-center gap-2">
                        Selamat datang di JOGO KOPI
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-emerald-900/60 text-emerald-300 text-xs font-medium"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Pemesanan Mandiri</span>
                    </p>
                    <p class="text-sm text-stone-300">Silakan pilih menu favorit Anda. Nomor meja dipilih saat konfirmasi pesanan, tanpa perlu antre ke kasir.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 space-y-6">
            <!-- Pencarian & kategori -->
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-stone-200/70 space-y-3">
                <form method="GET" action="{{ route('catalog.index') }}" class="flex gap-2">
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    <label for="search" class="sr-only">Cari menu</label>
                    <input id="search" type="text" name="search" value="{{ request('search') }}" placeholder="Cari kopi, minuman, atau camilan..."
                           class="flex-1 rounded-xl border-stone-200 bg-stone-50 text-sm focus:border-coffee-700 focus:ring-coffee-700" />
                    <button type="submit" class="px-5 rounded-xl bg-coffee-700 hover:bg-coffee-800 text-white text-sm font-semibold transition">Cari</button>
                </form>
                <div class="flex gap-2 overflow-x-auto pb-1">
                    <a href="{{ route('catalog.index', array_filter(['search' => request('search')])) }}"
                       class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium {{ request('category_id') ? 'bg-stone-100 text-stone-700 hover:bg-stone-200' : 'bg-espresso text-white' }}">Semua</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('catalog.index', array_filter(['search' => request('search'), 'category_id' => $category->id])) }}"
                           class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium {{ request('category_id') == $category->id ? 'bg-espresso text-white' : 'bg-stone-100 text-stone-700 hover:bg-stone-200' }}">
                            {{ $category->name }} ({{ $category->menus_count }})
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-end justify-between">
                <h1 class="text-2xl font-extrabold text-espresso">Katalog Pilihan <span class="text-sm font-semibold text-coffee-600">Dipanggang Segar Setiap Hari</span></h1>
                <span class="text-xs text-stone-500">{{ $menus->count() }} menu</span>
            </div>

            <!-- Daftar menu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                @forelse ($menus as $menu)
                    <article class="bg-white rounded-2xl p-3 shadow-sm border border-stone-200/70 flex flex-col {{ $menu->is_available ? '' : 'opacity-60' }}">
                        <div class="relative aspect-[16/10] rounded-xl overflow-hidden bg-stone-100">
                            @if ($menu->image_url)
                                <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy" class="w-full h-full object-cover {{ $menu->is_available ? '' : 'grayscale' }}" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <span class="absolute top-2 left-2 px-2.5 py-0.5 rounded-full bg-white/90 text-xs font-medium text-coffee-800">{{ $menu->category->name ?? 'Menu' }}</span>
                            <x-like-count :count="$menu->likes_count" class="absolute top-2 right-2" />
                            @unless ($menu->is_available)
                                <span class="absolute inset-0 flex items-center justify-center bg-stone-900/40 text-white font-bold tracking-wider">STOK HABIS</span>
                            @endunless
                        </div>

                        <div class="px-1 pt-3 flex-1 flex flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <h2 class="font-bold text-espresso">{{ $menu->name }}</h2>
                                <p class="font-extrabold text-coffee-700 whitespace-nowrap">{{ $menu->formatted_price }}</p>
                            </div>
                            <p class="text-xs text-stone-500 mt-1 line-clamp-2 flex-1">{{ $menu->description }}</p>

                            @if ($menu->is_available)
                                <form action="{{ route('cart.store') }}" method="POST" class="mt-3 space-y-2">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                    <label for="note-{{ $menu->id }}" class="sr-only">Catatan untuk {{ $menu->name }}</label>
                                    <input id="note-{{ $menu->id }}" type="text" name="note" maxlength="150" placeholder="Catatan (cth: less sugar, es sedikit)..."
                                           class="w-full rounded-lg border-0 bg-stone-100 text-xs placeholder:text-stone-400 focus:ring-2 focus:ring-coffee-600" />
                                    <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button type="button" disabled class="mt-3 w-full py-2.5 rounded-lg bg-stone-200 text-stone-500 text-sm font-semibold cursor-not-allowed">Stok Habis</button>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="sm:col-span-2 bg-white rounded-2xl p-10 text-center text-stone-500">Menu tidak ditemukan. Coba kata kunci atau kategori lain.</p>
                @endforelse
            </div>
        </div>

        <!-- Ringkasan pesanan -->
        <aside class="bg-white rounded-2xl shadow-sm border border-stone-200/70 lg:sticky lg:top-24">
            <div class="p-5 border-b border-stone-100 flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-orange-100 text-coffee-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                </span>
                <div>
                    <h2 class="font-extrabold text-espresso text-lg">Pesanan Anda</h2>
                    <p class="text-xs text-coffee-600">{{ array_sum(array_column($cart, 'quantity')) }} item di keranjang</p>
                </div>
            </div>

            <div class="p-5 space-y-3">
                @forelse ($cart as $id => $item)
                    <div class="rounded-xl bg-stone-50 p-3">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm font-bold text-espresso">{{ $item['name'] }}</p>
                                <p class="text-sm font-semibold text-coffee-700">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                            </div>
                            <form method="POST" action="{{ route('cart.update', $id) }}" class="flex items-center rounded-lg border border-stone-200 bg-white">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="note" value="{{ $item['note'] ?? '' }}">
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="w-7 h-7 text-stone-600 hover:text-espresso" aria-label="Kurangi {{ $item['name'] }}">&minus;</button>
                                <span class="w-6 text-center text-sm font-semibold">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="w-7 h-7 text-stone-600 hover:text-espresso" aria-label="Tambah {{ $item['name'] }}">+</button>
                            </form>
                        </div>
                        @if (! empty($item['note']))
                            <p class="mt-2 text-xs text-stone-500 bg-white rounded px-2 py-1">{{ $item['note'] }}</p>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-stone-500 text-center py-6">Keranjang masih kosong. Tambahkan menu dari katalog.</p>
                @endforelse

                @if (count($cart) > 0)
                    <div class="flex items-center justify-between rounded-xl bg-stone-100 px-4 py-3">
                        <span class="font-bold text-espresso">Total Bayar</span>
                        <span class="text-xl font-extrabold text-coffee-700">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('cart.index') }}" class="flex items-center justify-center gap-2 w-full py-3 rounded-xl bg-green-600 hover:bg-green-700 text-white font-semibold transition">
                        Lanjut Konfirmasi Pesanan &rarr;
                    </a>
                @endif
            </div>
        </aside>
    </div>
</x-customer-layout>
