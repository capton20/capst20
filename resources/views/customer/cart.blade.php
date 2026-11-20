<x-customer-layout title="Konfirmasi Pesanan">
    @php
        $total = collect($cart)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $orderType = old('order_type', 'dine_in');
        $steps = ['Pilih Menu', 'Review Keranjang', 'Konfirmasi Meja', 'Lacak Pesanan'];
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <!-- Langkah pemesanan -->
        <ol class="grid grid-cols-2 lg:grid-cols-4 gap-3 bg-white rounded-2xl p-3 shadow-sm border border-stone-200/70">
            @foreach ($steps as $i => $step)
                @php $state = $i < 2 ? 'done' : ($i === 2 ? 'active' : 'next'); @endphp
                <li class="flex items-center gap-3 rounded-xl px-4 py-3 {{ $state === 'active' ? 'bg-espresso text-white' : 'bg-stone-50' }}">
                    <span class="w-7 h-7 shrink-0 rounded-full flex items-center justify-center text-xs font-bold
                        {{ $state === 'done' ? 'bg-green-500 text-white' : ($state === 'active' ? 'bg-coffee-600 text-white' : 'bg-stone-200 text-stone-500') }}">
                        {{ $state === 'done' ? '✓' : $i + 1 }}
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[11px] {{ $state === 'active' ? 'text-stone-300' : 'text-stone-500' }}">Langkah {{ $i + 1 }}</span>
                        <span class="block text-sm font-semibold {{ $state === 'next' ? 'text-stone-400' : '' }}">{{ $step }}</span>
                    </span>
                </li>
            @endforeach
        </ol>

        <div>
            <h1 class="text-3xl font-extrabold text-espresso">Konfirmasi Pesanan &amp; Kirim ke Dapur</h1>
            <p class="text-sm text-stone-600 mt-1 max-w-2xl">Pilih Dine-in (makan di tempat) dengan nomor meja, atau Takeaway (bawa pulang), agar pesanan langsung masuk ke kasir &amp; barista tanpa perlu memanggil pegawai.</p>
        </div>

        @if (count($cart) === 0)
            <div class="bg-white rounded-2xl p-12 text-center shadow-sm border border-stone-200/70">
                <p class="text-stone-500 mb-5">Keranjang belanja Anda masih kosong.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-3 rounded-xl bg-espresso hover:bg-black text-white font-semibold">Lihat Katalog Menu</a>
            </div>
        @else
            <div x-data="{ type: '{{ $orderType }}' }" class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">
                <div class="lg:col-span-3 space-y-6">
                    <!-- Opsi tipe pesanan -->
                    <section class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200/70">
                        <h2 class="font-bold text-espresso text-lg mb-4">Opsi Tipe Pesanan</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative rounded-xl border-2 p-4 cursor-pointer transition has-[:checked]:border-coffee-600 has-[:checked]:bg-orange-50/60 border-stone-200">
                                <input type="radio" name="order_type" value="dine_in" form="checkout-form" x-model="type" class="absolute top-4 right-4 text-coffee-700 focus:ring-coffee-600" {{ $orderType === 'dine_in' ? 'checked' : '' }}>
                                <p class="font-bold text-espresso">Dine-In (Makan di Tempat)</p>
                                <p class="text-sm text-stone-600 mt-1">Makanan &amp; minuman diantar langsung oleh staf ke meja Anda.</p>
                            </label>
                            <label class="relative rounded-xl border-2 p-4 cursor-pointer transition has-[:checked]:border-coffee-600 has-[:checked]:bg-orange-50/60 border-stone-200">
                                <input type="radio" name="order_type" value="takeaway" form="checkout-form" x-model="type" class="absolute top-4 right-4 text-coffee-700 focus:ring-coffee-600" {{ $orderType === 'takeaway' ? 'checked' : '' }}>
                                <p class="font-bold text-espresso">Takeaway (Bawa Pulang)</p>
                                <p class="text-sm text-stone-600 mt-1">Dikemas rapi, ambil di meja pick-up kasir saat pesanan siap.</p>
                            </label>
                        </div>
                    </section>

                    <!-- Pilih nomor meja -->
                    <section x-show="type === 'dine_in'" class="bg-white rounded-2xl p-5 shadow-sm border border-stone-200/70">
                        <h2 class="font-bold text-espresso text-lg">Pilih Nomor Meja Anda</h2>
                        <p class="text-xs text-stone-500 mb-4">Pastikan sesuai dengan stiker nomor di atas meja Anda.</p>

                        @if ($tables->isEmpty())
                            <p class="text-sm text-stone-500 bg-stone-50 rounded-xl p-4">Belum ada meja aktif. Silakan pilih Takeaway atau hubungi kasir.</p>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($tables as $table)
                                    <label class="rounded-xl border-2 border-transparent bg-stone-50 p-3 cursor-pointer transition hover:border-stone-300 has-[:checked]:bg-espresso has-[:checked]:text-white has-[:checked]:border-coffee-600">
                                        <input type="radio" name="dining_table_id" value="{{ $table->id }}" form="checkout-form" class="sr-only" {{ old('dining_table_id') == $table->id ? 'checked' : '' }}>
                                        <span class="flex items-center justify-between">
                                            <span class="text-lg font-extrabold">{{ $table->number }}</span>
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                        </span>
                                        <span class="block text-sm mt-2">{{ $table->area ?: 'Meja ' . $table->number }}</span>
                                        <span class="block text-xs opacity-70">{{ $table->capacity }} Kursi</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                        @error('dining_table_id')
                            <p class="mt-3 text-sm text-rose-700 font-medium">{{ $message }}</p>
                        @enderror
                    </section>
                </div>

                <!-- Ringkasan pesanan -->
                <aside class="lg:col-span-2 bg-white rounded-2xl p-5 shadow-sm border border-stone-200/70 lg:sticky lg:top-24 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="font-bold text-espresso text-lg">Ringkasan Pesanan <span class="ms-1 px-2 py-0.5 rounded-full bg-stone-100 text-xs font-semibold">{{ array_sum(array_column($cart, 'quantity')) }} item</span></h2>
                        <a href="{{ route('catalog.index') }}" class="text-xs font-semibold text-coffee-700 hover:text-coffee-900">Tambah Menu</a>
                    </div>

                    <div class="space-y-3">
                        @foreach ($cart as $id => $item)
                            <div class="rounded-xl bg-stone-50 p-3 space-y-2">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="font-semibold text-espresso text-sm">{{ $item['name'] }}</p>
                                    <p class="font-bold text-espresso text-sm whitespace-nowrap">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <label for="qty-{{ $id }}" class="sr-only">Jumlah {{ $item['name'] }}</label>
                                    <input id="qty-{{ $id }}" type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" form="update-{{ $id }}" class="w-16 rounded-lg border-stone-200 text-sm text-center py-1.5 focus:border-coffee-700 focus:ring-coffee-700">
                                    <label for="note-{{ $id }}" class="sr-only">Catatan {{ $item['name'] }}</label>
                                    <input id="note-{{ $id }}" type="text" name="note" maxlength="150" value="{{ $item['note'] ?? '' }}" placeholder="Catatan..." form="update-{{ $id }}" class="flex-1 min-w-0 rounded-lg border-stone-200 text-xs py-1.5 focus:border-coffee-700 focus:ring-coffee-700">
                                </div>
                                <div class="flex justify-end gap-3 text-xs font-semibold">
                                    <button type="submit" form="update-{{ $id }}" class="text-coffee-700 hover:text-coffee-900">Perbarui</button>
                                    <button type="submit" form="delete-{{ $id }}" class="text-rose-600 hover:text-rose-800">Hapus</button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="rounded-xl bg-stone-100 p-4 flex items-center justify-between">
                        <span>
                            <span class="block font-bold text-espresso">Total Pembayaran</span>
                            <span class="block text-xs text-stone-500">Bayar di kasir</span>
                        </span>
                        <span class="text-2xl font-extrabold text-espresso">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form id="checkout-form" method="POST" action="{{ route('cart.checkout') }}">
                        @csrf
                        <button type="submit" class="w-full py-3.5 rounded-xl bg-espresso hover:bg-black text-white font-semibold transition">
                            <span x-text="type === 'takeaway' ? 'Kirim Pesanan Takeaway →' : 'Kirim Pesanan Sekarang →'">Kirim Pesanan Sekarang &rarr;</span>
                        </button>
                    </form>
                    <p class="text-xs text-center text-stone-500">Pesanan langsung diteruskan ke kasir &amp; barista.</p>
                </aside>
            </div>

            {{-- Form ubah/hapus item, dipisah karena form tidak boleh bersarang --}}
            @foreach ($cart as $id => $item)
                <form id="update-{{ $id }}" method="POST" action="{{ route('cart.update', $id) }}" class="hidden">@csrf @method('PATCH')</form>
                <form id="delete-{{ $id }}" method="POST" action="{{ route('cart.destroy', $id) }}" class="hidden">@csrf @method('DELETE')</form>
            @endforeach
        @endif
    </div>
</x-customer-layout>
