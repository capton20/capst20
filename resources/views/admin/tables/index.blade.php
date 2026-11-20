<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs text-stone-500">Admin Dashboard / Manajemen Operasional / <span class="text-coffee-700 font-semibold">Kelola Meja</span></p>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight mt-1">Kelola Data Meja &amp; Kapasitas</h2>
                <p class="text-sm text-stone-600 mt-1 max-w-2xl">Kelola nomor meja, kapasitas kursi, dan status meja dine-in. Meja nonaktif tidak muncul saat pelanggan memilih meja.</p>
            </div>
            <a href="{{ route('admin.tables.create') }}" class="inline-flex items-center px-4 py-2 bg-coffee-950 rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-coffee-900 transition shadow-sm">
                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Meja Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Ringkasan -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Total Meja Terdaftar</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $stats['total'] }}</span> <span class="text-sm text-stone-600">meja</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Meja Aktif</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $stats['aktif'] }}</span> <span class="text-sm text-emerald-700 font-semibold">tampil di pelanggan</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Nonaktif / Perbaikan</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $stats['nonaktif'] }}</span> <span class="text-sm text-stone-600">meja</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-sm text-stone-500">Total Kapasitas Kursi</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $stats['kapasitas'] }}</span> <span class="text-sm text-stone-600">kursi tamu</span></p>
                </div>
            </div>

            <!-- Filter -->
            <form method="GET" action="{{ route('admin.tables.index') }}" class="bg-white p-4 rounded-xl border border-stone-200/80 shadow-sm flex flex-col md:flex-row gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor meja (cth: 01, B3)..." class="flex-1 bg-stone-50 border border-stone-200 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 p-2.5" />
                <select name="status" class="md:w-52 bg-stone-50 border border-stone-200 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 p-2.5">
                    <option value="">Semua Status</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                </select>
                <button type="submit" class="px-5 py-2.5 bg-stone-800 text-white text-sm font-medium rounded-lg hover:bg-stone-900 transition">Filter</button>
            </form>

            <!-- Tabel Meja -->
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-stone-500 uppercase bg-stone-50 border-b border-stone-200/80">
                            <tr>
                                <th class="px-6 py-4">Nomor Meja</th>
                                <th class="px-6 py-4">Area / Zona</th>
                                <th class="px-6 py-4">Kapasitas</th>
                                <th class="px-6 py-4">Status Meja</th>
                                <th class="px-6 py-4 text-center">Tampil di Pelanggan</th>
                                <th class="px-6 py-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($tables as $table)
                                @php $isOccupied = in_array($table->id, $occupied); @endphp
                                <tr class="{{ $table->is_active ? 'hover:bg-stone-50/70' : 'bg-stone-50/60 text-stone-500' }} transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="w-9 h-9 rounded-lg flex items-center justify-center font-bold {{ $isOccupied ? 'bg-orange-100 text-orange-800' : 'bg-stone-100 text-stone-800' }}">{{ $table->number }}</span>
                                            <span class="font-bold text-stone-900">Meja {{ $table->number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">{{ $table->area ?: '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-stone-100 text-stone-700">{{ $table->capacity }} Kursi</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if (! $table->is_active)
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">Nonaktif</span>
                                        @elseif ($isOccupied)
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">Terisi (Dine-in)</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">Tersedia / Kosong</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form method="POST" action="{{ route('admin.tables.toggle', $table) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" role="switch" aria-checked="{{ $table->is_active ? 'true' : 'false' }}" aria-label="Aktif/nonaktifkan meja {{ $table->number }}"
                                                    class="relative inline-flex h-7 w-12 items-center rounded-full transition focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 {{ $table->is_active ? 'bg-coffee-950' : 'bg-stone-300' }}">
                                                <span class="inline-block h-5 w-5 rounded-full bg-white shadow transition {{ $table->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-end">
                                        <div class="inline-flex items-center gap-1">
                                            <a href="{{ route('admin.tables.edit', $table) }}" class="p-1.5 text-stone-600 hover:text-coffee-800 hover:bg-stone-100 rounded-lg transition" title="Edit Meja">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                            </a>
                                            <form method="POST" action="{{ route('admin.tables.destroy', $table) }}" onsubmit="return confirm('Hapus meja {{ $table->number }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition" title="Hapus Meja">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-stone-500">Belum ada data meja.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tables->hasPages())
                    <div class="p-4 border-t border-stone-200/80 bg-stone-50">{{ $tables->links() }}</div>
                @endif
            </div>

            <!-- Denah meja -->
            @if ($allTables->isNotEmpty())
                <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
                        <div>
                            <h3 class="font-bold text-stone-900 text-lg">Denah Tata Letak Meja</h3>
                            <p class="text-xs text-stone-500">Klik meja untuk mengubah data dan kapasitasnya.</p>
                        </div>
                        <div class="flex gap-4 text-xs text-stone-600">
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>Tersedia</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-orange-400"></span>Terisi</span>
                            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-stone-300"></span>Nonaktif</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3 bg-stone-50 rounded-lg p-4">
                        @foreach ($allTables as $table)
                            @php
                                $tone = ! $table->is_active ? 'bg-stone-100 text-stone-400 border-stone-200'
                                    : (in_array($table->id, $occupied) ? 'bg-orange-50 text-orange-800 border-orange-200' : 'bg-white text-emerald-800 border-stone-200');
                            @endphp
                            <a href="{{ route('admin.tables.edit', $table) }}" class="rounded-lg border p-3 text-center hover:shadow-md transition {{ $tone }}">
                                <span class="block text-lg font-extrabold">{{ $table->number }}</span>
                                <span class="block text-xs font-semibold text-stone-700">Meja {{ $table->number }}</span>
                                <span class="block text-[11px] text-stone-500">{{ $table->capacity }} kursi</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
