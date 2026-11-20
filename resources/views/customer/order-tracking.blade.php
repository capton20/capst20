<x-customer-layout title="Lacak Pesanan">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <p class="text-sm text-stone-500">Layanan Mandiri / <span class="text-espresso font-medium">Pelacakan Pesanan</span></p>
                <h1 class="text-3xl font-extrabold text-espresso mt-1">Lacak Status Pesanan</h1>
            </div>
            <a href="{{ route('orders.index') }}" class="shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-stone-200 text-xs font-semibold text-stone-700 hover:bg-stone-100">
                <span class="w-2 h-2 rounded-full bg-green-500"></span> Muat Ulang
            </a>
        </div>

        @forelse ($orders as $order)
            <article class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-stone-200/70 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                    <div>
                        <div class="flex flex-wrap gap-2 text-xs font-semibold">
                            <span class="px-2.5 py-0.5 rounded-full bg-stone-100 text-stone-700 uppercase">{{ $order->order_type === 'takeaway' ? 'Takeaway' : 'Dine-In' }}</span>
                            @if ($order->diningTable)
                                <span class="px-2.5 py-0.5 rounded-full bg-espresso text-white">Meja {{ $order->diningTable->number }}</span>
                            @endif
                            <x-order-status :status="$order->status" />
                        </div>
                        <h2 class="text-2xl font-extrabold text-espresso mt-2">Pesanan {{ $order->code }}</h2>
                        <p class="text-xs text-stone-500">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB &bull; {{ $order->items->sum('quantity') }} item</p>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-xs text-stone-500">Total</p>
                        <p class="text-xl font-extrabold text-espresso">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <a href="{{ route('orders.show', $order->id) }}" class="inline-block mt-1 text-sm font-semibold text-coffee-700 hover:text-coffee-900">Lihat Detail &rarr;</a>
                    </div>
                </div>
                <x-order-progress :order="$order" compact />
            </article>
        @empty
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-stone-200/70">
                <p class="text-stone-500 mb-5">Belum ada pesanan yang tercatat.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-3 rounded-xl bg-espresso hover:bg-black text-white font-semibold">Pesan Sekarang</a>
            </div>
        @endforelse
    </div>
</x-customer-layout>
