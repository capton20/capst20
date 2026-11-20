<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.tables.index') }}" class="p-2 text-stone-500 hover:text-stone-800 hover:bg-stone-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">{{ $table->exists ? 'Edit Meja ' . $table->number : 'Tambah Meja Baru' }}</h2>
                <p class="text-sm text-stone-600 mt-0.5">Nomor meja harus unik dan kapasitas minimal 1 kursi.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ $table->exists ? route('admin.tables.update', $table) : route('admin.tables.store') }}" class="space-y-6">
                    @csrf
                    @if ($table->exists)
                        @method('PUT')
                    @endif

                    <div>
                        <label for="number" class="block text-sm font-semibold text-stone-700">Nomor Meja <span class="text-rose-600">*</span></label>
                        <input type="text" id="number" name="number" value="{{ old('number', $table->number) }}" required autofocus maxlength="20" placeholder="Contoh: 01, 12, B3" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 block w-full p-2.5" />
                        @error('number')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="area" class="block text-sm font-semibold text-stone-700">Area / Zona <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <input type="text" id="area" name="area" value="{{ old('area', $table->area) }}" placeholder="Contoh: Indoor AC, Outdoor Terrace" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 block w-full p-2.5" />
                        @error('area')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="capacity" class="block text-sm font-semibold text-stone-700">Kapasitas (kursi) <span class="text-rose-600">*</span></label>
                        <input type="number" id="capacity" name="capacity" value="{{ old('capacity', $table->capacity) }}" required min="1" max="50" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-coffee-700 focus:border-coffee-700 block w-full p-2.5" />
                        @error('capacity')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $table->is_active)) class="rounded border-stone-300 text-coffee-800 focus:ring-coffee-700" />
                        <span class="text-sm text-stone-700">Meja aktif dan bisa dipilih pelanggan</span>
                    </label>

                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-stone-200">
                        <a href="{{ route('admin.tables.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-coffee-950 hover:bg-coffee-900 text-white text-sm font-medium rounded-lg transition shadow-sm">Simpan Meja</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
