<x-customer-layout title="Pesanan {{ $order->code }}">
    @php
        $statusInfo = [
            'pending' => ['Menunggu Konfirmasi', 'Pesanan sudah terkirim dan menunggu diterima kasir.'],
            'diterima' => ['Pesanan Diterima', 'Kasir sudah menerima pesanan dan meneruskannya ke barista & dapur.'],
            'diproses' => ['Sedang Diracik', 'Pesanan sedang disiapkan dengan teliti oleh barista & dapur.'],
            'siap' => ['Siap Disajikan', $order->order_type === 'takeaway' ? 'Pesanan siap diambil di meja pick-up kasir.' : 'Pesanan siap diantar ke meja Anda.'],
            'selesai' => ['Selesai', 'Terima kasih, selamat menikmati!'],
            'dibatalkan' => ['Dibatalkan', 'Pesanan dibatalkan. Silakan hubungi kasir untuk informasi lebih lanjut.'],
        ][$order->status] ?? [$order->status_label, ''];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between">
            <p class="text-sm text-stone-500"><a href="{{ route('orders.index') }}" class="hover:text-espresso">Layanan Mandiri</a> / <span class="text-espresso font-medium">Pelacakan Pesanan</span></p>
            <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-stone-200 text-xs font-semibold text-stone-700 hover:bg-stone-100">
                <span class="w-2 h-2 rounded-full bg-green-500"></span> Muat Ulang Status
            </a>
        </div>

        <!-- Kartu status -->
        <section class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200/70 space-y-6">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">
                <div>
                    <div class="flex flex-wrap gap-2 text-xs font-semibold">
                        <span class="px-2.5 py-0.5 rounded-full bg-stone-100 text-stone-700 uppercase">{{ $order->order_type === 'takeaway' ? 'Takeaway' : 'Dine-In' }}</span>
                        @if ($order->diningTable)
                            <span class="px-2.5 py-0.5 rounded-full bg-espresso text-white">Meja {{ $order->diningTable->number }}{{ $order->diningTable->area ? ' (' . $order->diningTable->area . ')' : '' }}</span>
                        @endif
                    </div>
                    <h1 class="text-3xl font-extrabold text-espresso mt-3">Pesanan {{ $order->code }}</h1>
                    <p class="text-sm text-stone-600 mt-1">Dipesan {{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                </div>
                <div class="flex items-center gap-4 rounded-xl bg-orange-50 border border-orange-100 p-4 lg:min-w-[320px]">
                    <span class="w-12 h-12 shrink-0 rounded-full bg-orange-100 text-coffee-700 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    <div>
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-stone-500">Status Pesanan</p>
                        <p class="text-lg font-extrabold text-espresso">{{ $statusInfo[0] }}</p>
                        <p class="text-xs text-coffee-700">{{ $statusInfo[1] }}</p>
                    </div>
                </div>
            </div>

            <x-order-progress :order="$order" />
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
            <!-- Detail menu -->
            <section class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-stone-200/70">
                <h2 class="text-lg font-bold text-espresso">Detail Menu yang Dipesan</h2>
                <p class="text-xs text-stone-500 mb-4">{{ $order->items->sum('quantity') }} item pada pesanan ini</p>
                <div class="space-y-3">
                    @forelse ($order->items as $item)
                        <div class="flex items-start justify-between gap-3 rounded-xl bg-stone-50 p-4">
                            <div>
                                <p class="font-bold text-espresso">{{ $item->quantity }}x {{ $item->menu_name }}</p>
                                @if ($item->note)
                                    <p class="text-xs text-stone-600 mt-1">Catatan: {{ $item->note }}</p>
                                @endif
                            </div>
                            <p class="font-bold text-espresso whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-stone-500">Rincian item tidak tersedia untuk pesanan ini.</p>
                    @endforelse
                </div>
            </section>

            <!-- Rincian pembayaran -->
            <aside class="bg-white rounded-2xl p-6 shadow-sm border border-stone-200/70 space-y-4">
                <h2 class="text-lg font-bold text-espresso">Rincian Pembayaran</h2>
                <div class="flex justify-between text-sm text-stone-600">
                    <span>Subtotal ({{ $order->items->sum('quantity') }} item)</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-end border-t border-stone-200 pt-4">
                    <span class="text-xs font-semibold uppercase text-stone-500">Total Transaksi</span>
                    <span class="text-2xl font-extrabold text-espresso">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('catalog.index') }}" class="block text-center w-full py-3 rounded-xl bg-espresso hover:bg-black text-white font-semibold transition">Tambah Pesanan Baru</a>
                <a href="{{ route('orders.index') }}" class="block text-center w-full py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold transition">Kembali ke Daftar Pesanan</a>
            </aside>
        </div>
    </div>
</x-customer-layout>
