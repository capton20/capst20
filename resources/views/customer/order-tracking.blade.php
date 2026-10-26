<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lacak Status Pesanan (Order Tracking)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-lg font-bold mb-4">Daftar Pesanan Anda</h3>

                @if(isset($orders) && $orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border p-4 rounded-lg flex justify-between items-center shadow-sm">
                                <div>
                                    <p class="font-semibold">Order ID: #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <span class="px-3 py-1 text-sm rounded-full font-semibold 
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <a href="{{ route('orders.show', $order->id) }}" class="ml-4 text-indigo-600 hover:underline text-sm font-medium">Detail</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Belum ada pesanan yang tercatat.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>