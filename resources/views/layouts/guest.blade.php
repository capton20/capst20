<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JOGO Kopi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-900 antialiased">
        <div class="min-h-screen flex flex-col bg-espresso bg-[radial-gradient(ellipse_at_center,_#4a3a33_0%,_#2b1a14_45%,_#140c09_100%)]">
            <header class="flex items-center justify-between p-4 sm:p-6">
                <a href="/" class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5">
                    <span class="w-9 h-9 rounded-lg bg-coffee-600 flex items-center justify-center text-amber-100">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M2,21H20V19H2M20,8H18V5H20M20,3H4V13A4,4 0 0,0 8,17H14A4,4 0 0,0 18,13V10H20A2,2 0 0,0 22,8V5C22,3.89 21.1,3 20,3Z"/></svg>
                    </span>
                    <span>
                        <span class="block font-extrabold text-white leading-none">JOGO KOPI</span>
                        <span class="block text-xs text-stone-300 mt-1">Artisanal Roastery &amp; Kitchen</span>
                    </span>
                </a>
                <span class="hidden sm:inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Sistem Online
                </span>
            </header>

            <main class="flex-1 flex flex-col items-center justify-center px-4 pb-10">
                <div class="w-full sm:max-w-md bg-stone-100 rounded-2xl shadow-2xl px-6 py-8 sm:px-8">
                    {{ $slot }}
                </div>
                <p class="mt-5 text-xs text-stone-400 text-center">&copy; {{ date('Y') }} JOGO KOPI &bull; Sistem Self-Ordering, Kasir &amp; Manajemen Meja</p>
            </main>
        </div>
    </body>
</html>
