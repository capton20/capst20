<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.users.index') }}" class="p-2 text-stone-500 hover:text-stone-800 hover:bg-stone-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Tambah Akun Pengguna Baru
                </h2>
                <p class="text-sm text-stone-600 mt-0.5">
                    Buat akun baru untuk Administrator atau Kasir JOGO Kopi.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-700">Nama Lengkap <span class="text-rose-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('name')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-stone-700">Alamat Email <span class="text-rose-600">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: kasir1@jogokopi.com" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-semibold text-stone-700 mb-2">Peran Akun (Role) <span class="text-rose-600">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="flex items-start p-4 bg-stone-50 border border-stone-200 rounded-lg cursor-pointer hover:bg-amber-50/40 hover:border-amber-400 transition">
                                <input type="radio" name="role" value="kasir" class="mt-1 text-amber-800 focus:ring-amber-700 border-stone-300" {{ old('role', 'kasir') === 'kasir' ? 'checked' : '' }} />
                                <div class="ms-3">
                                    <span class="block text-sm font-bold text-stone-900">Kasir</span>
                                    <span class="block text-xs text-stone-500 mt-0.5">Dapat melayani self-ordering, reservasi, dan transaksi kasir.</span>
                                </div>
                            </label>

                            <label class="flex items-start p-4 bg-stone-50 border border-stone-200 rounded-lg cursor-pointer hover:bg-amber-50/40 hover:border-amber-400 transition">
                                <input type="radio" name="role" value="admin" class="mt-1 text-amber-800 focus:ring-amber-700 border-stone-300" {{ old('role') === 'admin' ? 'checked' : '' }} />
                                <div class="ms-3">
                                    <span class="block text-sm font-bold text-stone-900">Administrator</span>
                                    <span class="block text-xs text-stone-500 mt-0.5">Akses penuh mengelola menu, kategori, pengguna, dan laporan.</span>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-stone-100">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-stone-700">Password <span class="text-rose-600">*</span></label>
                            <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                            @error('password')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-stone-700">Konfirmasi Password <span class="text-rose-600">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password di atas" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                            @error('password_confirmation')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-stone-200">
                        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white text-sm font-medium rounded-lg transition shadow-sm focus:ring-2 focus:ring-coffee-600">
                            Simpan Akun Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
