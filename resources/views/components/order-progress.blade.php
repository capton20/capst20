@props(['order', 'compact' => false])

@php
    $steps = [
        'pending' => 'Terkirim',
        'diterima' => 'Diterima',
        'diproses' => 'Diracik',
        'siap' => 'Siap Saji',
        'selesai' => 'Selesai',
    ];
    $current = array_search($order->status, array_keys($steps), true);
@endphp

@if ($order->status === 'dibatalkan')
    <p class="rounded-xl bg-rose-50 border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-800">Pesanan ini dibatalkan oleh kasir.</p>
@else
    <ol class="grid grid-cols-5 gap-2">
        @foreach ($steps as $status => $label)
            @php $state = $loop->index < $current ? 'done' : ($loop->index === $current ? 'active' : 'next'); @endphp
            <li class="rounded-xl {{ $compact ? 'p-2' : 'p-3' }} {{ $state === 'active' ? 'bg-orange-100' : ($state === 'done' ? 'bg-stone-100' : 'bg-stone-50') }}">
                <span class="block h-1.5 rounded-full {{ $state === 'next' ? 'bg-stone-200' : ($state === 'active' ? 'bg-coffee-600' : 'bg-green-600') }}"></span>
                <span class="mt-2 block text-[11px] {{ $state === 'next' ? 'text-stone-400' : ($state === 'active' ? 'text-coffee-700 font-semibold' : 'text-green-700') }}">
                    {{ $loop->iteration }}. {{ $label }}
                </span>
                @unless ($compact)
                    <span class="block text-xs {{ $state === 'next' ? 'text-stone-400' : 'text-stone-600' }}">
                        {{ $state === 'done' ? 'Selesai' : ($state === 'active' ? 'Sedang berlangsung' : 'Menunggu') }}
                    </span>
                @endunless
            </li>
        @endforeach
    </ol>
@endif
