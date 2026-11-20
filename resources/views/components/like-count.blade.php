@props(['count' => 0])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-white/90 text-xs font-semibold text-rose-700']) }} title="{{ $count }} like dari JOGO KOPI">
    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
    <span>{{ $count }} <span class="sr-only">like</span></span>
</span>
