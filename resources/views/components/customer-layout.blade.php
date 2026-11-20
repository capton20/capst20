@props(['title' => 'JOGO Kopi'])

@php
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
    $cartTotal = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
@endphp

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - JOGO Kopi</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-stone-900 bg-cream">
        <div class="min-h-screen flex flex-col">
            <nav x-data="{ open: false }" class="bg-cream/95 backdrop-blur border-b border-stone-200/70 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    <a href="{{ route('catalog.index') }}" class="flex items-center gap-2.5">
                        <span class="w-9 h-9 rounded-lg bg-espresso flex items-center justify-center text-amber-100">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/></svg>
                        </span>
                        <span class="leading-none">
                            <span class="block font-extrabold text-espresso">JOGO KOPI</span>
                            <span class="block text-[11px] text-coffee-600 mt-0.5">Artisanal Roastery</span>
                        </span>
                    </a>

                    <div class="hidden md:flex items-center gap-1 rounded-full bg-stone-200/60 p-1 text-sm font-medium">
                        <a href="{{ route('catalog.index') }}" class="px-4 py-1.5 rounded-full transition {{ request()->routeIs('catalog.*') ? 'bg-espresso text-white' : 'text-stone-700 hover:text-espresso' }}">Katalog Menu</a>
                        <a href="{{ route('orders.index') }}" class="px-4 py-1.5 rounded-full transition {{ request()->routeIs('orders.*') ? 'bg-espresso text-white' : 'text-stone-700 hover:text-espresso' }}">Lacak Pesanan</a>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('cart.index') }}" class="flex items-center gap-2 rounded-full bg-espresso text-white ps-3 pe-4 py-1.5 hover:bg-black transition">
                            <span class="relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                                @if ($cartCount > 0)
                                    <span class="absolute -top-1.5 -right-1.5 min-w-[1rem] h-4 px-1 rounded-full bg-coffee-500 text-[10px] font-bold flex items-center justify-center">{{ $cartCount }}</span>
                                @endif
                            </span>
                            <span class="leading-none">
                                <span class="block text-[10px] text-stone-300">Keranjang</span>
                                <span class="block text-sm font-bold">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </span>
                        </a>

                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="w-9 h-9 rounded-full bg-espresso text-white flex items-center justify-center" aria-label="Menu akun">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-2 text-xs text-stone-500 border-b border-stone-100">{{ Auth::user()->name }}</div>
                                <x-dropdown-link :href="route('orders.index')" class="md:hidden">Lacak Pesanan</x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')">Profil Saya</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar</x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </nav>

            @isset($banner)
                {{ $banner }}
            @endisset

            <div class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 mt-6 empty:hidden">
                @if (session('success'))
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm font-medium">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <main class="flex-1 py-8">
                {{ $slot }}
            </main>

            <footer class="bg-stone-200/50 border-t border-stone-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between text-xs text-stone-600">
                    <div>
                        <p class="font-extrabold text-espresso text-sm">JOGO KOPI <span class="ms-1 px-2 py-0.5 rounded-full bg-white text-stone-600 font-medium text-[11px]">Roastery &amp; Cafe</span></p>
                        <p class="mt-1">Kenyamanan cita rasa kopi nusantara dalam suasana hangat dan bersahaja.</p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-white">Buka: 08.00 - 22.00 WIB</span>
                    <p>&copy; {{ date('Y') }} JOGO KOPI. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
