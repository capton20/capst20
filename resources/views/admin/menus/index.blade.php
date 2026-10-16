<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Menu Makanan & Minuman
                </h2>
                <p class="text-sm text-stone-600 mt-1">
                    Kelola daftar katalog menu, harga, deskripsi, dan foto produk JOGO Kopi.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 bg-coffee-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-coffee-900 focus:bg-coffee-900 active:bg-coffee-950 focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 transition shadow-sm">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Menu
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Filter & Search Bar -->
            <div class="bg-white p-4 rounded-xl border border-stone-200/80 shadow-sm">
                <form method="GET" action="{{ route('admin.menus.index') }}" class="flex flex-col md:flex-row gap-3">
                    <!-- Search Input -->
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu atau deskripsi..." class="bg-stone-50 border border-stone-200 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full ps-10 p-2.5" />
                    </div>

                    <!-- Category Filter Dropdown -->
                    <div class="w-full md:w-64">
                        <select name="category_id" class="bg-stone-50 border border-stone-200 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-stone-800 text-white text-sm font-medium rounded-lg hover:bg-stone-900 transition">
                            Filter
                        </button>
                        @if (request()->hasAny(['search', 'category_id']))
                            <a href="{{ route('admin.menus.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-700 text-sm font-medium rounded-lg hover:bg-stone-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Menus Table -->
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-stone-600">
                        <thead class="text-xs text-stone-500 uppercase bg-stone-50 border-b border-stone-200/80">
                            <tr>
                                <th scope="col" class="px-6 py-4">Foto</th>
                                <th scope="col" class="px-6 py-4">Nama Menu</th>
                                <th scope="col" class="px-6 py-4">Kategori</th>
                                <th scope="col" class="px-6 py-4">Harga</th>
                                <th scope="col" class="px-6 py-4">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($menus as $menu)
                                <tr class="hover:bg-stone-50/70 transition">
                                    <td class="px-6 py-4">
                                        @if ($menu->image_url)
                                            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-14 h-14 rounded-lg object-cover border border-stone-200 shadow-sm" />
                                        @else
                                            <div class="w-14 h-14 rounded-lg bg-stone-100 border border-stone-200 flex items-center justify-center text-stone-400" title="Tidak ada foto">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-stone-900 text-base">{{ $menu->name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-900 border border-amber-200">
                                            {{ $menu->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-stone-900 text-base text-amber-900">
                                            {{ $menu->formatted_price }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs text-xs text-stone-500">
                                        {{ $menu->description ?: 'Tidak ada deskripsi' }}
                                    </td>
                                    <td class="px-6 py-4 text-end">
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.menus.edit', $menu) }}" class="p-1.5 text-stone-600 hover:text-amber-800 hover:bg-stone-100 rounded-lg transition" title="Edit Menu">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Hapus -->
                                            <form method="POST" action="{{ route('admin.menus.destroy', $menu) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu &quot;{{ $menu->name }}&quot;? Foto dan data menu akan dihapus secara permanen.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition" title="Hapus Menu">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-stone-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <p class="text-base font-semibold text-stone-700">Tidak ada menu ditemukan</p>
                                            <p class="text-xs text-stone-500 mt-1">Coba ganti filter kategori atau kata kunci pencarian Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($menus->hasPages())
                    <div class="p-4 border-t border-stone-200/80 bg-stone-50">
                        {{ $menus->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
