<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs text-stone-500">Kasir POS / Katalog &amp; Stok / <span class="text-coffee-700 font-semibold">Ketersediaan Menu</span></p>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight mt-1">Kelola Ketersediaan Menu</h2>
                <p class="text-sm text-stone-600 mt-1 max-w-2xl">
                    Atur status ketersediaan menu secara langsung. Menu yang ditandai <span class="font-semibold text-rose-700">Habis</span> tidak bisa dipesan pelanggan dari katalog.
                </p>
            </div>
            <form method="POST" action="{{ route('kasir.menus.available-all') }}" onsubmit="return confirm('Tandai semua menu sebagai tersedia?');">
                @csrf
                @method('PATCH')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-stone-300 rounded-lg text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Tandai Semua Tersedia
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Ringkasan -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Total Menu</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $stats['total'] }}</span> <span class="text-sm text-stone-600">item terdaftar</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Menu Tersedia</p>
                    <p class="mt-2 flex items-center gap-2">
                        <span class="text-3xl font-extrabold text-stone-900">{{ $stats['tersedia'] }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Siap Dipesan</span>
                    </p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Menu Habis (Sold Out)</p>
                    <p class="mt-2 flex items-center gap-2">
                        <span class="text-3xl font-extrabold text-rose-700">{{ $stats['habis'] }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Kunci Pesanan</span>
                    </p>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white p-4 rounded-xl border border-stone-200/80 shadow-sm space-y-3">
                <form method="GET" action="{{ route('kasir.menus.index') }}" class="flex flex-col md:flex-row gap-3">
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..." class="flex-1 bg-stone-50 border border-stone-200 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 p-2.5" />
                    <div class="inline-flex rounded-lg bg-stone-100 p-1 text-sm">
                        @foreach (['' => 'Semua Status (' . $stats['total'] . ')', 'tersedia' => 'Tersedia (' . $stats['tersedia'] . ')', 'habis' => 'Habis (' . $stats['habis'] . ')'] as $value => $label)
                            <button type="submit" name="status" value="{{ $value }}" class="px-3 py-1.5 rounded-md font-medium transition {{ request('status', '') === $value ? 'bg-coffee-950 text-white' : 'text-stone-600 hover:text-stone-900' }}">{{ $label }}</button>
                        @endforeach
                    </div>
                </form>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('kasir.menus.index', request()->except(['category_id', 'page'])) }}" class="px-3 py-1 rounded-full text-xs font-medium border {{ request('category_id') ? 'bg-white border-stone-200 text-stone-600 hover:bg-stone-100' : 'bg-coffee-950 border-coffee-950 text-white' }}">Semua Kategori</a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('kasir.menus.index', array_merge(request()->except('page'), ['category_id' => $cat->id])) }}" class="px-3 py-1 rounded-full text-xs font-medium border {{ request('category_id') == $cat->id ? 'bg-coffee-950 border-coffee-950 text-white' : 'bg-white border-stone-200 text-stone-600 hover:bg-stone-100' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            <!-- Tabel Menu -->
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-stone-500 bg-stone-50 border-b border-stone-200/80">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Item Menu</th>
                                <th class="px-6 py-4 font-semibold">Kategori</th>
                                <th class="px-6 py-4 font-semibold">Harga</th>
                                <th class="px-6 py-4 font-semibold text-end">Status Ketersediaan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($menus as $menu)
                                <tr class="{{ $menu->is_available ? 'hover:bg-stone-50/70' : 'bg-stone-50/60' }} transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="relative w-12 h-12 shrink-0">
                                                @if ($menu->image_url)
                                                    <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-12 h-12 rounded-lg object-cover border border-stone-200 {{ $menu->is_available ? '' : 'grayscale opacity-60' }}" />
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-stone-100 border border-stone-200"></div>
                                                @endif
                                                @unless ($menu->is_available)
                                                    <span class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-white bg-stone-800/50 rounded-lg">HABIS</span>
                                                @endunless
                                            </div>
                                            <div>
                                                <p class="font-bold {{ $menu->is_available ? 'text-stone-900' : 'text-stone-500 line-through' }}">{{ $menu->name }}</p>
                                                <p class="text-xs text-stone-500 line-clamp-1 max-w-sm">{{ $menu->description }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 rounded-md text-xs font-medium bg-stone-100 text-stone-700">{{ $menu->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-stone-900">{{ $menu->formatted_price }}</td>
                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('kasir.menus.availability', $menu) }}" class="flex items-center justify-end gap-3">
                                            @csrf
                                            @method('PATCH')
                                            @if ($menu->is_available)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800"><span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>Tersedia</span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-800"><span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>Habis</span>
                                            @endif
                                            <button type="submit" role="switch" aria-checked="{{ $menu->is_available ? 'true' : 'false' }}" aria-label="Ubah ketersediaan {{ $menu->name }}"
                                                    class="relative inline-flex h-7 w-12 items-center rounded-full transition focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 {{ $menu->is_available ? 'bg-coffee-950' : 'bg-stone-300' }}">
                                                <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition {{ $menu->is_available ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-stone-500">Tidak ada menu yang cocok dengan filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-stone-200/80 bg-stone-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs text-stone-500">
                    <span>Menampilkan {{ $menus->count() }} dari {{ $menus->total() }} menu</span>
                    {{ $menus->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
