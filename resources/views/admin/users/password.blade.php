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
                    Atur Ulang Password: {{ $user->name }}
                </h2>
                <p class="text-sm text-stone-600 mt-0.5">
                    Masukkan kata sandi baru untuk akun {{ $user->email }}.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start space-x-3 text-amber-900 text-sm">
                    <svg class="w-5 h-5 text-amber-700 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <span class="font-bold">Keamanan Password</span>
                        <p class="text-xs text-amber-800 mt-0.5">Password baru akan otomatis dienkripsi dengan standar Bcrypt Laravel sebelum disimpan ke database.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.users.password.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Password Baru -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-stone-700">Password Baru <span class="text-rose-600">*</span></label>
                        <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-stone-700">Ulangi Password Baru <span class="text-rose-600">*</span></label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ketik ulang password baru" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('password_confirmation')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-stone-200">
                        <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white text-sm font-medium rounded-lg transition shadow-sm focus:ring-2 focus:ring-coffee-600">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
