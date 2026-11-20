@props(['status'])

@php
    $colors = [
        'pending' => 'bg-orange-100 text-orange-800',
        'diterima' => 'bg-amber-100 text-amber-900',
        'diproses' => 'bg-stone-200 text-stone-800',
        'siap' => 'bg-emerald-100 text-emerald-800',
        'selesai' => 'bg-green-700 text-white',
        'dibatalkan' => 'bg-rose-100 text-rose-800',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold whitespace-nowrap ' . ($colors[$status] ?? 'bg-stone-100 text-stone-700')]) }}>
    {{ \App\Models\Order::STATUSES[$status] ?? ucfirst($status) }}
</span>
