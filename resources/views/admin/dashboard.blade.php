<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Dashboard Admin
                </h2>
                <p class="text-sm text-stone-600 mt-1">
                    Selamat datang kembali, <span class="font-semibold text-amber-900">{{ Auth::user()->name }}</span>. Kelola seluruh operasional sistem JOGO Kopi.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 bg-coffee-800 border border-transparent rounded-lg font-medium text-xs text-white uppercase tracking-wider hover:bg-coffee-900 focus:bg-coffee-900 active:bg-coffee-950 focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Menu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Akun Pengguna -->
                <div class="bg-white rounded-xl p-6 border border-stone-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Akun</p>
                        <h3 class="text-3xl font-extrabold text-stone-900 mt-1">{{ $stats['total_users'] }}</h3>
                        <p class="text-xs text-stone-600 mt-1">
                            <span class="text-amber-800 font-semibold">{{ $stats['total_admins'] }}</span> Admin &bull; 
                            <span class="text-stone-700 font-semibold">{{ $stats['total_kasir'] }}</span> Kasir
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Kategori -->
                <div class="bg-white rounded-xl p-6 border border-stone-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Kategori Menu</p>
                        <h3 class="text-3xl font-extrabold text-stone-900 mt-1">{{ $stats['total_categories'] }}</h3>
                        <p class="text-xs text-stone-600 mt-1">Katalog kategori aktif</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>

                <!-- Total Menu -->
                <div class="bg-white rounded-xl p-6 border border-stone-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Menu</p>
                        <h3 class="text-3xl font-extrabold text-stone-900 mt-1">{{ $stats['total_menus'] }}</h3>
                        <p class="text-xs text-stone-600 mt-1">Makanan & Minuman</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100/70 text-coffee-800 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>

                <!-- Status Sistem -->
                <div class="bg-white rounded-xl p-6 border border-stone-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Status Sistem</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-lg font-bold text-stone-900">Operasional</span>
                        </div>
                        <p class="text-xs text-stone-500 mt-1">JOGO Kopi Self-Order</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Quick Action Shortcuts -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.users.index') }}" class="group bg-white p-6 rounded-xl border border-stone-200/80 shadow-sm hover:border-amber-700/50 hover:shadow-md transition">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-800 flex items-center justify-center group-hover:bg-amber-800 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-stone-900 group-hover:text-amber-900 transition">Kelola Akun Pengguna</h4>
                            <p class="text-sm text-stone-500 mt-1">Tambah akun kasir/admin, ubah hak akses, dan atur ulang kata sandi.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="group bg-white p-6 rounded-xl border border-stone-200/80 shadow-sm hover:border-amber-700/50 hover:shadow-md transition">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-800 flex items-center justify-center group-hover:bg-emerald-800 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-stone-900 group-hover:text-amber-900 transition">Kelola Kategori Menu</h4>
                            <p class="text-sm text-stone-500 mt-1">Kelompokkan menu ke dalam kategori seperti Espresso, Manual Brew, dan Non-Kopi.</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.menus.index') }}" class="group bg-white p-6 rounded-xl border border-stone-200/80 shadow-sm hover:border-amber-700/50 hover:shadow-md transition">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-lg bg-amber-100 text-coffee-800 flex items-center justify-center group-hover:bg-coffee-800 group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-stone-900 group-hover:text-amber-900 transition">Kelola Menu & Harga</h4>
                            <p class="text-sm text-stone-500 mt-1">Atur nama menu, harga, deskripsi, dan upload foto produk.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Two Columns: Recent Menus & Recent Users -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Menus -->
                <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-stone-100 flex items-center justify-between">
                        <h4 class="font-bold text-stone-900 text-base">Menu Terbaru</h4>
                        <a href="{{ route('admin.menus.index') }}" class="text-xs font-semibold text-amber-800 hover:text-amber-900">Lihat Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-stone-100">
                        @forelse ($recentMenus as $menu)
                            <div class="p-4 flex items-center justify-between hover:bg-stone-50 transition">
                                <div class="flex items-center space-x-3.5">
                                    @if ($menu->image_url)
                                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-12 h-12 rounded-lg object-cover border border-stone-200" />
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-sm text-stone-900">{{ $menu->name }}</p>
                                        <span class="inline-block text-xs text-stone-500 font-medium">{{ $menu->category->name ?? '-' }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold text-sm text-amber-900">{{ $menu->formatted_price }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-stone-500 text-sm">
                                Belum ada menu yang didaftarkan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-stone-100 flex items-center justify-between">
                        <h4 class="font-bold text-stone-900 text-base">Akun Pengguna Terdaftar</h4>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-amber-800 hover:text-amber-900">Lihat Semua &rarr;</a>
                    </div>
                    <div class="divide-y divide-stone-100">
                        @forelse ($recentUsers as $user)
                            <div class="p-4 flex items-center justify-between hover:bg-stone-50 transition">
                                <div class="flex items-center space-x-3.5">
                                    <div class="w-10 h-10 rounded-full bg-stone-100 text-stone-700 flex items-center justify-center font-bold text-sm border border-stone-200">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-sm text-stone-900">{{ $user->name }}</p>
                                        <p class="text-xs text-stone-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-amber-100 text-amber-900 border border-amber-300' : 'bg-stone-100 text-stone-700 border border-stone-300' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-stone-500 text-sm">
                                Belum ada user terdaftar.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
