<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Dashboard Kasir
                </h2>
                <p class="text-sm text-stone-600 mt-1">
                    Selamat datang, <span class="font-semibold text-amber-900">{{ Auth::user()->name }}</span>. Anda masuk sebagai <span class="font-semibold text-stone-800">Kasir JOGO Kopi</span>.
                </p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-stone-100 text-stone-700 border border-stone-300">
                Kasir Aktif
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-800 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-stone-900">Akses Kasir Siap Digunakan</h3>
                        <p class="text-sm text-stone-600 mt-1">
                            Akun Anda memiliki hak akses untuk melayani pesanan self-ordering pelanggan dan reservasi meja kasir. Fitur konfigurasi sistem, pengelolaan akun pengguna, dan perubahan master katalog menu hanya dapat diakses oleh Administrator.
                        </p>
                        <div class="mt-4 flex items-center space-x-4 text-xs text-stone-500">
                            <span class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 me-1.5"></span>
                                Sesi Terautentikasi Aman
                            </span>
                            <span>&bull;</span>
                            <span>Email: {{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
