<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
            <div>
                <p class="text-xs text-stone-500">Kasir POS / Pengelolaan Pesanan / <span class="text-coffee-700 font-semibold">Pesanan Masuk</span></p>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight mt-1">Daftar Pesanan Masuk &amp; Proses Pesanan</h2>
                <p class="text-sm text-stone-600 mt-1 max-w-2xl">Pantau pesanan dine-in maupun takeaway dari pelanggan, cek rincian item dan catatan, lalu teruskan ke barista/dapur.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kasir.orders.index', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-white border border-stone-300 rounded-lg text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                    <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    Muat Ulang
                </a>
                <a href="{{ route('kasir.orders.board') }}" class="inline-flex items-center px-4 py-2 bg-coffee-950 rounded-lg text-xs font-semibold text-white hover:bg-coffee-900 transition">
                    Papan Status Pesanan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <!-- Ringkasan hari ini -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pesanan Masuk</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $counts['pending'] ?? 0 }}</span> <span class="text-sm text-stone-600">tiket baru</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Sedang Diproses</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ ($counts['diterima'] ?? 0) + ($counts['diproses'] ?? 0) }}</span> <span class="text-sm text-stone-600">dibuat</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Siap Disajikan</p>
                    <p class="mt-2"><span class="text-3xl font-extrabold text-stone-900">{{ $counts['siap'] ?? 0 }}</span> <span class="text-sm text-stone-600">tinggal diantar</span></p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-stone-200/80 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Omzet Hari Ini</p>
                    <p class="mt-2 text-2xl font-extrabold text-stone-900">Rp {{ number_format($omzet, 0, ',', '.') }}</p>
                    <p class="text-xs text-stone-500">{{ $counts['selesai'] ?? 0 }} transaksi selesai</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                <!-- Daftar pesanan -->
                <div class="lg:col-span-2 space-y-3">
                    <form method="GET" action="{{ route('kasir.orders.index') }}" class="bg-white p-3 rounded-xl border border-stone-200/80 shadow-sm space-y-3">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor order atau nama pelanggan..." class="w-full bg-stone-50 border border-stone-200 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 p-2.5" />
                        <div class="flex gap-1.5 overflow-x-auto pb-1">
                            @foreach (['' => 'Aktif', 'pending' => 'Baru Masuk', 'diterima' => 'Diterima', 'diproses' => 'Diproses', 'siap' => 'Siap Saji', 'selesai' => 'Selesai'] as $value => $label)
                                <a href="{{ route('kasir.orders.index', array_filter(['status' => $value, 'search' => request('search')])) }}"
                                   class="shrink-0 px-3 py-1 rounded-md text-xs font-medium {{ request('status', '') === $value ? 'bg-coffee-950 text-white' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </form>

                    @forelse ($orders as $order)
                        <a href="{{ route('kasir.orders.index', array_merge(request()->query(), ['order' => $order->id])) }}"
                           class="block bg-white rounded-xl p-4 border shadow-sm transition {{ $selected && $selected->id === $order->id ? 'border-coffee-700 ring-2 ring-coffee-200' : 'border-stone-200/80 hover:border-stone-300' }}">
                            <div class="flex items-center justify-between gap-2">
                                <p class="font-bold text-stone-900">{{ $order->code }} <span class="text-xs font-normal text-stone-500">&bull; {{ $order->created_at->locale('id')->diffForHumans() }}</span></p>
                                <x-order-status :status="$order->status" />
                            </div>
                            <div class="flex items-center justify-between text-sm mt-1.5">
                                <span class="font-semibold text-stone-800">{{ $order->order_type === 'takeaway' ? 'Takeaway' : 'Meja ' . ($order->diningTable->number ?? '-') }}</span>
                                <span class="text-stone-600">{{ $order->user->name ?? 'Pelanggan' }}</span>
                            </div>
                            <p class="text-xs text-stone-500 mt-1 line-clamp-1">
                                {{ $order->items->count() }} menu ({{ $order->items->map(fn ($i) => $i->quantity . 'x ' . $i->menu_name)->implode(', ') }})
                            </p>
                            <p class="font-bold text-stone-900 mt-2">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </a>
                    @empty
                        <div class="bg-white rounded-xl p-8 border border-stone-200/80 text-center text-sm text-stone-500">Belum ada pesanan pada filter ini.</div>
                    @endforelse
                </div>

                <!-- Rincian pesanan -->
                <div class="lg:col-span-3 bg-white rounded-xl border border-stone-200/80 shadow-sm lg:sticky lg:top-20">
                    @if ($selected)
                        <div class="p-6 border-b border-stone-100 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                            <div>
                                <h3 class="text-2xl font-extrabold text-stone-900">Rincian Pesanan {{ $selected->code }}</h3>
                                <p class="text-xs text-stone-500 mt-1">Waktu masuk: {{ $selected->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                            </div>
                            <div class="flex flex-wrap gap-1.5 sm:justify-end">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-stone-100 text-stone-700">
                                    {{ $selected->order_type === 'takeaway' ? 'Takeaway' : 'Dine-In • Meja ' . ($selected->diningTable->number ?? '-') }}
                                </span>
                                <x-order-status :status="$selected->status" />
                            </div>
                        </div>

                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-stone-50 rounded-lg p-4 text-sm">
                                <div>
                                    <p class="text-xs font-semibold uppercase text-stone-500">Nama Pelanggan</p>
                                    <p class="font-semibold text-stone-900 mt-0.5">{{ $selected->user->name ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase text-stone-500">Kontak</p>
                                    <p class="font-semibold text-stone-900 mt-0.5 break-all">{{ $selected->user->email ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase text-stone-500">Lokasi Meja</p>
                                    <p class="font-semibold text-stone-900 mt-0.5">
                                        @if ($selected->diningTable)
                                            Meja {{ $selected->diningTable->number }}{{ $selected->diningTable->area ? ' (' . $selected->diningTable->area . ')' : '' }}
                                        @else
                                            Takeaway
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-semibold uppercase text-stone-500 mb-2">
                                    <span>Daftar Menu Pesanan</span>
                                    <span>Total {{ $selected->items->sum('quantity') }} item</span>
                                </div>
                                <div class="space-y-2">
                                    @forelse ($selected->items as $item)
                                        <div class="flex items-start justify-between gap-3 bg-stone-50 rounded-lg p-3">
                                            <div class="flex items-start gap-3">
                                                <span class="shrink-0 px-2 py-0.5 rounded-md bg-coffee-950 text-white text-xs font-bold">{{ $item->quantity }}x</span>
                                                <div>
                                                    <p class="font-bold text-stone-900">{{ $item->menu_name }}</p>
                                                    @if ($item->note)
                                                        <p class="mt-1 text-xs text-rose-800 bg-rose-50 border border-rose-100 rounded px-2 py-1">Catatan: "{{ $item->note }}"</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="font-bold text-stone-900 whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-stone-500">Pesanan ini tidak memiliki rincian item.</p>
                                    @endforelse
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-stone-200 pt-4">
                                <span class="text-lg font-bold text-stone-900">Total Pembayaran</span>
                                <span class="text-2xl font-extrabold text-stone-900">Rp {{ number_format($selected->total_price, 0, ',', '.') }}</span>
                            </div>

                            @if ($selected->next_status)
                                <form method="POST" action="{{ route('kasir.orders.status', $selected) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="{{ $selected->next_status }}">
                                    <button type="submit" class="w-full py-3 rounded-lg bg-coffee-950 hover:bg-coffee-900 text-white font-semibold transition">
                                        {{ $selected->status === 'pending' ? 'Terima & Teruskan ke Barista / Dapur' : 'Ubah status ke ' . \App\Models\Order::STATUSES[$selected->next_status] }}
                                    </button>
                                </form>
                                @if ($selected->status === 'pending')
                                    <form method="POST" action="{{ route('kasir.orders.status', $selected) }}" onsubmit="return confirm('Tolak/batalkan pesanan {{ $selected->code }}?');" class="text-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="dibatalkan">
                                        <button type="submit" class="text-sm font-semibold text-rose-700 hover:text-rose-900">Tolak / Batalkan Pesanan</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="p-12 text-center text-stone-500 text-sm">Pilih pesanan di sebelah kiri untuk melihat rinciannya.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
