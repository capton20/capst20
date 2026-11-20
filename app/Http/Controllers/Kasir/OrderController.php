<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OrderController extends Controller
{
    // PBI-09: daftar pesanan masuk + rincian pesanan yang dipilih
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'diningTable', 'items'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->whereNotIn('status', ['selesai', 'dibatalkan']);
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $orderId = ltrim(preg_replace('/\D/', '', $keyword), '0');

            $query->where(function ($q) use ($keyword, $orderId) {
                $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%{$keyword}%"));
                if ($orderId !== '') {
                    $q->orWhere('id', $orderId);
                }
            });
        }

        $orders = $query->get();
        $selected = $request->filled('order')
            ? Order::with(['user', 'diningTable', 'items'])->find($request->order)
            : $orders->first();

        $counts = Order::whereDate('created_at', today())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $omzet = Order::whereDate('created_at', today())->where('status', 'selesai')->sum('total_price');

        return view('kasir.orders.index', compact('orders', 'selected', 'counts', 'omzet'));
    }

    // PBI-10: papan alur status pesanan
    public function board(): View
    {
        $columns = collect(['pending', 'diterima', 'diproses', 'siap', 'selesai'])
            ->mapWithKeys(fn ($status) => [$status => collect()]);

        Order::with(['diningTable', 'items'])
            ->where('status', '!=', 'dibatalkan')
            ->where(fn ($q) => $q->where('status', '!=', 'selesai')->orWhereDate('updated_at', today()))
            ->oldest()
            ->get()
            ->each(fn ($order) => $columns->get($order->status)?->push($order));

        return view('kasir.orders.board', compact('columns'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        if (in_array($order->status, ['selesai', 'dibatalkan'], true)) {
            return back()->with('error', "Pesanan {$order->code} sudah {$order->status_label}, status tidak bisa diubah lagi.");
        }

        $order->update(['status' => $validated['status']]);

        return back()->with('success', "Status pesanan {$order->code} diperbarui menjadi {$order->status_label}.");
    }
}
