<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs text-stone-500">Kasir POS / Alur Pelayanan / <span class="text-coffee-700 font-semibold">Status Pesanan</span></p>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight mt-1">Pembaruan Status Pesanan</h2>
                <p class="text-sm text-stone-600 mt-1 max-w-2xl">Perbarui alur pesanan dari <b>Diterima</b>, <b>Diproses</b>, <b>Siap Saji</b>, hingga <b>Selesai</b> agar waktu pelayanan tercatat.</p>
            </div>
            <a href="{{ route('kasir.orders.board') }}" class="inline-flex items-center px-4 py-2 bg-white border border-stone-300 rounded-lg text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                Refresh Antrean
            </a>
        </div>
    </x-slot>

    @php
        $actionLabels = [
            'diterima' => 'Terima Pesanan',
            'diproses' => 'Proses Pesanan',
            'siap' => 'Tandai Siap Saji',
            'selesai' => 'Selesaikan Pesanan',
        ];
        $dots = [
            'pending' => 'bg-orange-500',
            'diterima' => 'bg-amber-700',
            'diproses' => 'bg-stone-800',
            'siap' => 'bg-orange-400',
            'selesai' => 'bg-emerald-600',
        ];
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-4 overflow-x-auto pb-4">
                @foreach ($columns as $status => $orders)
                    <section class="w-72 shrink-0 bg-stone-100 rounded-xl p-3">
                        <div class="flex items-center justify-between px-1 mb-3">
                            <h3 class="flex items-center gap-2 font-bold text-stone-900 text-sm uppercase">
                                <span class="w-2 h-2 rounded-full {{ $dots[$status] }}"></span>
                                {{ $loop->iteration }}. {{ \App\Models\Order::STATUSES[$status] }}
                            </h3>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-white text-stone-700">{{ $orders->count() }}</span>
                        </div>

                        <div class="space-y-3">
                            @forelse ($orders as $order)
                                <article class="bg-white rounded-lg p-4 border border-stone-200 shadow-sm">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="font-extrabold text-stone-900">{{ $order->code }}</p>
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $order->order_type === 'takeaway' ? 'bg-orange-100 text-orange-800' : 'bg-stone-100 text-stone-700' }}">
                                            {{ $order->order_type === 'takeaway' ? 'Takeaway' : 'Meja ' . ($order->diningTable->number ?? '-') }}
                                        </span>
                                    </div>
                                    <ul class="mt-2 space-y-1 text-sm text-stone-700">
                                        @foreach ($order->items as $item)
                                            <li class="flex justify-between gap-2">
                                                <span>{{ $item->quantity }}x {{ $item->menu_name }}</span>
                                            </li>
                                            @if ($item->note)
                                                <li class="text-xs text-rose-800 bg-rose-50 rounded px-2 py-1">"{{ $item->note }}"</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <div class="flex items-center justify-between mt-3 text-xs text-stone-500">
                                        <span>{{ $order->updated_at->locale('id')->diffForHumans() }}</span>
                                        <span class="text-sm font-bold text-stone-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </div>

                                    @if ($order->next_status)
                                        <form method="POST" action="{{ route('kasir.orders.status', $order) }}" class="mt-3">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $order->next_status }}">
                                            <button type="submit" class="w-full py-2 rounded-lg text-sm font-semibold text-white transition {{ $order->next_status === 'selesai' ? 'bg-emerald-900 hover:bg-emerald-950' : ($order->next_status === 'siap' ? 'bg-coffee-700 hover:bg-coffee-800' : 'bg-coffee-950 hover:bg-coffee-900') }}">
                                                {{ $actionLabels[$order->next_status] }} &rarr;
                                            </button>
                                        </form>
                                    @else
                                        <p class="mt-3 text-xs font-semibold text-emerald-700">Tuntas {{ $order->updated_at->format('H:i') }}</p>
                                    @endif
                                </article>
                            @empty
                                <p class="text-xs text-stone-500 text-center py-6">Kosong</p>
                            @endforelse
                        </div>
                    </section>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
