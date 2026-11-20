<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JOGO KOPI - Artisanal Roastery &amp; Self-Ordering</title>
        <meta name="description" content="Pesan kopi dan makanan JOGO KOPI langsung dari meja Anda, tanpa antre.">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-cream text-stone-900">
        @php
            $orderUrl = auth()->check() ? route('dashboard') : route('login');
        @endphp

        <!-- Navigasi -->
        <header class="absolute inset-x-0 top-0 z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <a href="/" class="flex items-center gap-2.5">
                    <span class="w-10 h-10 rounded-xl bg-coffee-600 flex items-center justify-center text-amber-50">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/></svg>
                    </span>
                    <span class="leading-none">
                        <span class="block font-extrabold text-white text-lg">JOGO KOPI</span>
                        <span class="block text-[11px] text-coffee-300 mt-0.5">Artisanal Roastery</span>
                    </span>
                </a>

                <nav class="flex items-center gap-2 text-sm font-semibold">
                    <a href="#menu" class="hidden sm:inline-block px-4 py-2 text-stone-300 hover:text-white">Menu</a>
                    <a href="#cara-pesan" class="hidden sm:inline-block px-4 py-2 text-stone-300 hover:text-white">Cara Pesan</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-full bg-white text-espresso hover:bg-coffee-100 transition">Buka Aplikasi</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-white hover:text-coffee-200">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-white text-espresso hover:bg-coffee-100 transition">Daftar</a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <section class="relative overflow-hidden bg-espresso bg-[radial-gradient(ellipse_at_top_right,_#5c392c_0%,_#2b1a14_50%,_#140c09_100%)] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20 lg:pt-40 lg:pb-28 grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/10 text-xs font-medium text-emerald-300">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span> Buka hari ini &bull; 08.00 - 22.00 WIB
                    </span>
                    <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                        Kopi Nusantara,<br>
                        <span class="text-coffee-300">dipesan dari mejamu.</span>
                    </h1>
                    <p class="mt-5 text-lg text-stone-300 max-w-xl">
                        Pilih menu, tentukan nomor meja atau takeaway, lalu pantau pesananmu sampai siap disajikan. Tanpa antre, tanpa memanggil pelayan.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ $orderUrl }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-coffee-600 hover:bg-coffee-500 font-semibold shadow-lg shadow-black/30 transition">
                            Pesan Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                        <a href="#menu" class="inline-flex items-center px-7 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 font-semibold transition">Lihat Menu</a>
                    </div>
                    <dl class="mt-12 grid grid-cols-3 gap-6 max-w-md">
                        <div>
                            <dt class="text-xs text-stone-400">Biji Kopi</dt>
                            <dd class="text-2xl font-extrabold">100%</dd>
                            <dd class="text-xs text-stone-400">Nusantara</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-stone-400">Pesan</dt>
                            <dd class="text-2xl font-extrabold">3 Langkah</dd>
                            <dd class="text-xs text-stone-400">dari meja</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-stone-400">Status</dt>
                            <dd class="text-2xl font-extrabold">Real-time</dd>
                            <dd class="text-xs text-stone-400">bisa dilacak</dd>
                        </div>
                    </dl>
                </div>

                <!-- Ilustrasi kartu pesanan -->
                <div class="relative hidden lg:block">
                    <div class="absolute -inset-8 rounded-full bg-coffee-600/20 blur-3xl" aria-hidden="true"></div>
                    <div class="relative bg-cream text-stone-900 rounded-3xl p-6 shadow-2xl max-w-md ms-auto rotate-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-stone-500">Pesanan Meja 07</p>
                                <p class="text-xl font-extrabold text-espresso">#ORD-0042</p>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-orange-100 text-coffee-700 text-xs font-semibold">Sedang Diracik</span>
                        </div>
                        <ol class="mt-5 grid grid-cols-4 gap-2" aria-hidden="true">
                            <li class="h-1.5 rounded-full bg-green-600"></li>
                            <li class="h-1.5 rounded-full bg-green-600"></li>
                            <li class="h-1.5 rounded-full bg-coffee-600"></li>
                            <li class="h-1.5 rounded-full bg-stone-200"></li>
                        </ol>
                        <ul class="mt-5 space-y-3 text-sm">
                            <li class="flex justify-between rounded-xl bg-white p-3"><span><b>1x</b> Kopi Susu Gula Aren</span><span class="font-semibold">Rp 22.000</span></li>
                            <li class="flex justify-between rounded-xl bg-white p-3"><span><b>1x</b> Ceremonial Matcha Latte</span><span class="font-semibold">Rp 27.000</span></li>
                            <li class="flex justify-between rounded-xl bg-white p-3"><span><b>1x</b> Roti Bakar Kaya Butter</span><span class="font-semibold">Rp 20.000</span></li>
                        </ul>
                        <div class="mt-5 flex justify-between items-center border-t border-stone-200 pt-4">
                            <span class="text-sm text-stone-500">Total</span>
                            <span class="text-2xl font-extrabold text-espresso">Rp 69.000</span>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -left-2 bg-white text-stone-900 rounded-2xl px-4 py-3 shadow-xl flex items-center gap-3 -rotate-2">
                        <span class="w-9 h-9 rounded-full bg-green-100 text-green-700 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </span>
                        <span class="text-sm">
                            <span class="block font-bold">Pesanan diterima kasir</span>
                            <span class="block text-xs text-stone-500">Diteruskan ke barista</span>
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Menu pilihan -->
        <section id="menu" class="py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
                    <div>
                        <p class="text-sm font-semibold text-coffee-600">Dipanggang segar setiap hari</p>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-espresso mt-1">Menu Pilihan JOGO</h2>
                    </div>
                    <a href="{{ $orderUrl }}" class="text-sm font-semibold text-coffee-700 hover:text-coffee-900">Lihat semua menu &rarr;</a>
                </div>

                @if ($menus->isEmpty())
                    <p class="bg-white rounded-2xl p-10 text-center text-stone-500">Menu segera hadir.</p>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($menus as $menu)
                            <article class="group bg-white rounded-2xl p-3 shadow-sm border border-stone-200/70 hover:shadow-lg transition">
                                <div class="relative aspect-[4/3] rounded-xl overflow-hidden bg-gradient-to-br from-coffee-100 to-coffee-200">
                                    @if ($menu->image_url)
                                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" />
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-coffee-400">
                                            <svg class="w-14 h-14 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/></svg>
                                        </div>
                                    @endif
                                    <span class="absolute top-3 left-3 px-2.5 py-0.5 rounded-full bg-white/90 text-xs font-medium text-coffee-800">{{ $menu->category->name ?? 'Menu' }}</span>
                                </div>
                                <div class="p-2 pt-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <h3 class="font-bold text-espresso">{{ $menu->name }}</h3>
                                        <p class="font-extrabold text-coffee-700 whitespace-nowrap">{{ $menu->formatted_price }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-stone-500 line-clamp-2">{{ $menu->description }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <!-- Cara pesan -->
        <section id="cara-pesan" class="py-20 bg-white border-y border-stone-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <p class="text-sm font-semibold text-coffee-600">Self-ordering</p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-espresso mt-1">Pesan dalam 3 langkah</h2>
                    <p class="mt-3 text-stone-600">Duduk santai, pesanan langsung masuk ke kasir dan barista.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ([
                        ['Pilih Menu', 'Jelajahi katalog, tambahkan ke keranjang, dan beri catatan seperti less sugar atau es sedikit.', 'M4 6h16M4 12h16M4 18h7'],
                        ['Pilih Meja atau Takeaway', 'Pilih nomor meja untuk makan di tempat, atau takeaway untuk dibawa pulang.', 'M3 10h18M5 10v9m14-9v9M7 6h10l2 4H5l2-4z'],
                        ['Lacak Pesanan', 'Pantau status pesanan dari diterima, diracik, hingga siap disajikan.', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ] as $i => [$title, $text, $icon])
                        <div class="rounded-2xl bg-cream p-6 border border-stone-200/70">
                            <div class="flex items-center justify-between">
                                <span class="w-12 h-12 rounded-xl bg-espresso text-white flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" /></svg>
                                </span>
                                <span class="text-4xl font-extrabold text-stone-200">0{{ $i + 1 }}</span>
                            </div>
                            <h3 class="mt-5 text-lg font-bold text-espresso">{{ $title }}</h3>
                            <p class="mt-2 text-sm text-stone-600">{{ $text }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Ajakan -->
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="rounded-3xl bg-espresso bg-[radial-gradient(ellipse_at_bottom_left,_#724634_0%,_#2b1a14_60%)] text-white p-10 sm:p-14 text-center">
                    <h2 class="text-3xl sm:text-4xl font-extrabold">Sudah duduk di meja?</h2>
                    <p class="mt-3 text-stone-300">Masuk atau daftar akun, lalu pesan kopi favoritmu sekarang juga.</p>
                    <div class="mt-8 flex flex-wrap justify-center gap-3">
                        <a href="{{ $orderUrl }}" class="px-7 py-3.5 rounded-xl bg-coffee-600 hover:bg-coffee-500 font-semibold transition">Mulai Pesan</a>
                        @guest
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-7 py-3.5 rounded-xl border border-white/20 hover:bg-white/10 font-semibold transition">Daftar Akun</a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-stone-200/50 border-t border-stone-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between text-sm text-stone-600">
                <div>
                    <p class="font-extrabold text-espresso">JOGO KOPI <span class="ms-1 px-2 py-0.5 rounded-full bg-white text-stone-600 font-medium text-xs">Roastery &amp; Cafe</span></p>
                    <p class="mt-1 text-xs">Kenyamanan cita rasa kopi nusantara dalam suasana hangat dan bersahaja.</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-white text-xs w-fit">Buka: 08.00 - 22.00 WIB</span>
                <p class="text-xs">&copy; {{ date('Y') }} JOGO KOPI. All rights reserved.</p>
            </div>
        </footer>
    </body>
</html>
