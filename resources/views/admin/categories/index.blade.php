<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Kategori Menu
                </h2>
                <p class="text-sm text-stone-600 mt-1">
                    Kelola pengelompokan menu minuman dan makanan JOGO Kopi.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-coffee-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-coffee-900 focus:bg-coffee-900 active:bg-coffee-950 focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 transition shadow-sm">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kategori
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Search & Filter Bar -->
            <div class="bg-white p-4 rounded-xl border border-stone-200/80 shadow-sm">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi kategori..." class="bg-stone-50 border border-stone-200 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full ps-10 p-2.5" />
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-stone-800 text-white text-sm font-medium rounded-lg hover:bg-stone-900 transition">
                            Cari
                        </button>
                        @if (request()->filled('search'))
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-700 text-sm font-medium rounded-lg hover:bg-stone-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-stone-600">
                        <thead class="text-xs text-stone-500 uppercase bg-stone-50 border-b border-stone-200/80">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nama Kategori</th>
                                <th scope="col" class="px-6 py-4">Slug URL</th>
                                <th scope="col" class="px-6 py-4">Deskripsi</th>
                                <th scope="col" class="px-6 py-4 text-center">Jumlah Menu</th>
                                <th scope="col" class="px-6 py-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-stone-50/70 transition">
                                    <td class="px-6 py-4 font-bold text-stone-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-stone-500">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 text-stone-600 max-w-xs truncate">
                                        {{ $category->description ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $category->menus_count > 0 ? 'bg-amber-100 text-amber-900' : 'bg-stone-100 text-stone-600' }}">
                                            {{ $category->menus_count }} menu
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-end">
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- Edit -->
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="p-1.5 text-stone-600 hover:text-amber-800 hover:bg-stone-100 rounded-lg transition" title="Edit Kategori">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Hapus -->
                                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori &quot;{{ $category->name }}&quot;?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition" title="Hapus Kategori">
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
                                    <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            <p class="text-base font-semibold text-stone-700">Belum ada kategori menu</p>
                                            <p class="text-xs text-stone-500 mt-1">Klik tombol &quot;Tambah Kategori&quot; untuk menambahkan kategori pertama.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($categories->hasPages())
                    <div class="p-4 border-t border-stone-200/80 bg-stone-50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
