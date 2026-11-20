@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 rounded-lg bg-espresso text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-coffee-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium text-stone-600 hover:text-espresso hover:bg-white/70 focus:outline-none focus:ring-2 focus:ring-coffee-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
