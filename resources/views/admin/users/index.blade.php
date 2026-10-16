<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Pengelolaan Akun Pengguna
                </h2>
                <p class="text-sm text-stone-600 mt-1">
                    Kelola hak akses dan akun sistem (Administrator dan Kasir) JOGO Kopi.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-coffee-800 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-wider hover:bg-coffee-900 focus:bg-coffee-900 active:bg-coffee-950 focus:outline-none focus:ring-2 focus:ring-coffee-600 focus:ring-offset-2 transition shadow-sm">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah Pengguna
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Filter & Search Card -->
            <div class="bg-white p-4 rounded-xl border border-stone-200/80 shadow-sm">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-stone-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="bg-stone-50 border border-stone-200 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full ps-10 p-2.5" />
                    </div>

                    <div class="w-full md:w-48">
                        <select name="role" class="bg-stone-50 border border-stone-200 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">
                            <option value="">Semua Peran (Role)</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-5 py-2.5 bg-stone-800 text-white text-sm font-medium rounded-lg hover:bg-stone-900 transition focus:ring-2 focus:ring-stone-400">
                            Filter
                        </button>
                        @if (request()->hasAny(['search', 'role']))
                            <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 bg-stone-100 text-stone-700 text-sm font-medium rounded-lg hover:bg-stone-200 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Table Card -->
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-stone-600">
                        <thead class="text-xs text-stone-500 uppercase bg-stone-50 border-b border-stone-200/80">
                            <tr>
                                <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Peran (Role)</th>
                                <th scope="col" class="px-6 py-4">Tanggal Dibuat</th>
                                <th scope="col" class="px-6 py-4 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-stone-100">
                            @forelse ($users as $user)
                                <tr class="hover:bg-stone-50/70 transition">
                                    <td class="px-6 py-4 font-medium text-stone-900 flex items-center space-x-3">
                                        <div class="w-9 h-9 rounded-full bg-coffee-100 text-coffee-800 font-bold flex items-center justify-center text-xs border border-coffee-200">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span>{{ $user->name }}</span>
                                            @if ($user->id === Auth::id())
                                                <span class="ms-1.5 text-[10px] bg-stone-200 text-stone-700 px-1.5 py-0.5 rounded font-medium">Anda</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->isAdmin())
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-900 border border-amber-300">
                                                <svg class="w-3 h-3 me-1 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 011.08.17l1.414 1.414a1 1 0 01.17 1.08l-.8 1.6 1.582 3.954H20a1 1 0 110 2h-1.323l-1.582 3.954.8 1.6a1 1 0 01-.17 1.08l-1.414 1.414a1 1 0 01-1.08-.17l-1.6-.8-3.954 1.582V20a1 1 0 11-2 0v-1.323l-3.954-1.582-1.6.8a1 1 0 01-1.08-.17L2.43 16.32a1 1 0 01-.17-1.08l.8-1.6L1.478 9.68H1a1 1 0 110-2h1.323l1.582-3.954-.8-1.6a1 1 0 01.17-1.08L4.69 2.43a1 1 0 011.08.17l1.6.8L10 2.323V2z" clip-rule="evenodd"/>
                                                </svg>
                                                Administrator
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-stone-100 text-stone-700 border border-stone-300">
                                                <svg class="w-3 h-3 me-1 text-stone-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                </svg>
                                                Kasir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-stone-500 text-xs">
                                        {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-end">
                                        <div class="inline-flex items-center space-x-2">
                                            <!-- Edit Profil User -->
                                            <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 text-stone-600 hover:text-amber-800 hover:bg-stone-100 rounded-lg transition" title="Edit Akun">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Reset Password -->
                                            <a href="{{ route('admin.users.password.edit', $user) }}" class="p-1.5 text-stone-600 hover:text-amber-800 hover:bg-stone-100 rounded-lg transition" title="Ubah Password">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                </svg>
                                            </a>

                                            <!-- Hapus User -->
                                            @if ($user->id !== Auth::id())
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }} ({{ $user->email }})? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1.5 text-rose-600 hover:text-rose-800 hover:bg-rose-50 rounded-lg transition" title="Hapus Akun">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="p-1.5 text-stone-300 cursor-not-allowed" title="Tidak dapat menghapus akun sendiri">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-stone-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-base font-semibold text-stone-700">Tidak ada pengguna ditemukan</p>
                                            <p class="text-xs text-stone-500 mt-1">Coba sesuaikan kata kunci pencarian atau filter peran Anda.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="p-4 border-t border-stone-200/80 bg-stone-50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
