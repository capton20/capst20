<x-guest-layout>
    <div class="text-center mb-6">
        <span class="mx-auto w-12 h-12 rounded-xl bg-coffee-100 border border-coffee-200 flex items-center justify-center text-espresso">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" /></svg>
        </span>
        <h1 class="mt-4 text-2xl font-extrabold text-espresso">Masuk ke Sistem</h1>
        <p class="mt-1 text-sm text-stone-600">Portal masuk pelanggan &amp; staf (Admin / Kasir) JOGO KOPI</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wide text-stone-700">Email</label>
            <div class="relative mt-1.5">
                <span class="absolute inset-y-0 start-0 flex items-center ps-3 text-stone-400" aria-hidden="true">@</span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com"
                       class="block w-full ps-9 rounded-xl border-stone-200 bg-white text-sm focus:border-coffee-700 focus:ring-coffee-700" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wide text-stone-700">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-coffee-600 hover:text-coffee-800">Lupa Kata Sandi?</a>
                @endif
            </div>
            <div class="relative mt-1.5">
                <input id="password" :type="show ? 'text' : 'password'" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi"
                       class="block w-full pe-10 rounded-xl border-stone-200 bg-white text-sm focus:border-coffee-700 focus:ring-coffee-700" />
                <button type="button" @click="show = !show" class="absolute inset-y-0 end-0 flex items-center pe-3 text-stone-400 hover:text-stone-700" :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-stone-300 text-coffee-800 focus:ring-coffee-700" name="remember">
            <span class="ms-2 text-sm text-stone-600">Ingat saya</span>
        </label>

        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-espresso hover:bg-black text-white font-semibold shadow-lg transition">
            Masuk
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-stone-600">Pelanggan baru? <a href="{{ route('register') }}" class="font-semibold text-coffee-700 hover:text-coffee-900">Daftar akun</a></p>
        @endif
    </form>
</x-guest-layout>
