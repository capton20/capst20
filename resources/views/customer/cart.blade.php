<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - JOGO Kopi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg relative">
        
        <!-- Alert / Toast Sukses -->
        @if(session('success'))
            <div id="toast-alert" class="bg-emerald-600 text-white px-5 py-3 rounded-xl shadow-md mb-6 flex justify-between items-center transition-all duration-300">
                <span class="font-medium">✨ {{ session('success') }}</span>
                <button onclick="document.getElementById('toast-alert').style.display='none'" class="text-white font-bold ml-4 hover:text-gray-200">✕</button>
            </div>
        @endif

        <!-- Header Keranjang dengan Tombol Aksi Modern -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">🛒 Keranjang Belanja Anda</h1>
            <a href="{{ route('catalog.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-4 py-2 rounded-xl shadow-sm transition flex items-center gap-2 text-sm">
                ← Tambah Menu Lain
            </a>
        </div>

        @php $cart = session()->get('cart', []); @endphp

        @if(count($cart) > 0)
            <div class="overflow-x-auto mb-6">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-left text-gray-700 text-sm">
                            <th class="p-3 border-b">Nama Menu & Catatan</th>
                            <th class="p-3 border-b">Harga</th>
                            <th class="p-3 border-b text-center">Jumlah</th>
                            <th class="p-3 border-b">Subtotal</th>
                            <th class="p-3 border-b text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity']; 
                                $total += $subtotal; 
                            @endphp
                            <tr class="border-b hover:bg-gray-50/50 transition">
                                <td class="p-3">
                                    <div class="font-semibold text-gray-800">{{ $item['name'] }}</div>
                                    @if(!empty($item['note']))
                                        <div class="text-xs text-amber-800 bg-amber-50 px-2 py-1 rounded-md mt-1 inline-block border border-amber-200">
                                            📝 {{ $item['note'] }}
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3 text-gray-600 text-sm">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                
                                <!-- Form Update Jumlah & Catatan -->
                                <td class="p-3 text-center">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex flex-col items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex items-center gap-1">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-14 border rounded-lg text-center p-1 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow transition">
                                                Update
                                            </button>
                                        </div>
                                        <input type="text" name="note" value="{{ $item['note'] ?? '' }}" placeholder="Ubah catatan..." class="w-full text-xs border rounded-lg p-1.5 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                                    </form>
                                </td>

                                <td class="p-3 font-semibold text-gray-800 text-sm">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                
                                <!-- Form Hapus Item -->
                                <td class="p-3 text-center">
                                    <form action="{{ route('cart.destroy', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold shadow transition flex items-center gap-1 mx-auto">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Bayar & Tombol Navigasi Bawah -->
            <div class="flex flex-col md:flex-row justify-between items-center bg-gray-50 p-5 rounded-xl border gap-4">
                <div class="text-xl font-bold text-gray-800">
                    Total Bayar: <span class="text-amber-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('catalog.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow transition text-sm">
                        Kembali Belanja
                    </a>
                    <button class="bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow transition text-sm">
                        Lanjut ke Checkout →
                    </button>
                </div>
            </div>

        @else
            <!-- State Kosong dengan Tombol Modern -->
            <div class="text-center py-12">
                <div class="text-5xl mb-3">🛒</div>
                <p class="text-gray-500 mb-6 font-medium">Keranjang belanja kamu masih kosong.</p>
                <a href="{{ route('catalog.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-xl shadow-md transition text-sm">
                    Lihat Katalog Menu
                </a>
            </div>
        @endif=

    </div>
</body>
</html>