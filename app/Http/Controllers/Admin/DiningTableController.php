<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DiningTableController extends Controller
{
    public function index(Request $request): View
    {
        $query = DiningTable::query()->orderBy('number');

        if ($request->filled('search')) {
            $query->where('number', 'like', '%' . $request->search . '%');
        }

        if ($request->status === 'aktif') {
            $query->where('is_active', true);
        } elseif ($request->status === 'nonaktif') {
            $query->where('is_active', false);
        }

        $tables = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => DiningTable::count(),
            'aktif' => DiningTable::where('is_active', true)->count(),
            'nonaktif' => DiningTable::where('is_active', false)->count(),
            'kapasitas' => DiningTable::where('is_active', true)->sum('capacity'),
        ];

        // Meja yang sedang dipakai pesanan dine-in yang belum selesai
        $occupied = DiningTable::whereHas('orders', fn ($q) => $q->whereNotIn('status', ['selesai', 'dibatalkan']))
            ->pluck('id')
            ->all();

        $allTables = DiningTable::orderBy('number')->get();

        return view('admin.tables.index', compact('tables', 'stats', 'occupied', 'allTables'));
    }

    public function create(): View
    {
        return view('admin.tables.form', ['table' => new DiningTable(['is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        DiningTable::create($this->validated($request));

        return redirect()->route('admin.tables.index')->with('success', 'Meja baru berhasil ditambahkan.');
    }

    public function edit(DiningTable $table): View
    {
        return view('admin.tables.form', compact('table'));
    }

    public function update(Request $request, DiningTable $table): RedirectResponse
    {
        $table->update($this->validated($request, $table));

        return redirect()->route('admin.tables.index')->with('success', 'Data meja berhasil diperbarui.');
    }

    public function toggle(DiningTable $table): RedirectResponse
    {
        $table->update(['is_active' => ! $table->is_active]);

        return back()->with('success', "Meja {$table->number} " . ($table->is_active ? 'diaktifkan.' : 'dinonaktifkan.'));
    }

    public function destroy(DiningTable $table): RedirectResponse
    {
        $table->delete();

        return redirect()->route('admin.tables.index')->with('success', 'Meja berhasil dihapus.');
    }

    private function validated(Request $request, ?DiningTable $table = null): array
    {
        $validated = $request->validate([
            'number' => ['required', 'string', 'max:20', Rule::unique('dining_tables', 'number')->ignore($table)],
            'area' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1', 'max:50'],
        ], [
            'number.unique' => 'Nomor meja sudah terpakai.',
            'capacity.min' => 'Kapasitas minimal 1 kursi.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        return $validated;
    }
}
