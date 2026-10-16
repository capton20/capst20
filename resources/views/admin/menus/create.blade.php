<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.menus.index') }}" class="p-2 text-stone-500 hover:text-stone-800 hover:bg-stone-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Tambah Menu Baru
                </h2>
                <p class="text-sm text-stone-600 mt-0.5">
                    Masukkan menu makanan atau minuman baru ke dalam katalog JOGO Kopi.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8" x-data="{ previewUrl: null }">
                <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Nama Menu -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-700">Nama Menu <span class="text-rose-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Kopi Susu JOGO, Croissant Almond" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('name')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori & Harga Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Kategori -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-stone-700">Kategori <span class="text-rose-600">*</span></label>
                            <select id="category_id" name="category_id" required class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">
                                <option value="">Pilih Kategori...</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="price" class="block text-sm font-semibold text-stone-700">Harga (Rupiah) <span class="text-rose-600">*</span></label>
                            <div class="relative mt-1.5">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-stone-500 font-semibold text-sm">
                                    Rp
                                </div>
                                <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" step="500" placeholder="25000" class="bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full ps-10 p-2.5" />
                            </div>
                            @error('price')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-stone-700">Deskripsi Menu <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <textarea id="description" name="description" rows="3" placeholder="Informasi komposisi, rasa, atau catatan sajian menu..." class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto Menu -->
                    <div>
                        <label class="block text-sm font-semibold text-stone-700">Foto Menu <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <p class="text-xs text-stone-500 mb-2">Format: JPG, JPEG, PNG, WEBP. Maksimum ukuran file: 2 MB.</p>
                        
                        <div class="flex items-center space-x-6">
                            <!-- Preview Box -->
                            <div class="w-24 h-24 rounded-xl border-2 border-dashed border-stone-300 bg-stone-50 flex items-center justify-center overflow-hidden flex-shrink-0">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" alt="Preview Foto Menu" class="w-full h-full object-cover" />
                                </template>
                                <template x-if="!previewUrl">
                                    <div class="text-center p-2 text-stone-400">
                                        <svg class="mx-auto h-8 w-8 text-stone-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-[10px] block mt-1">Preview</span>
                                    </div>
                                </template>
                            </div>

                            <!-- File Input -->
                            <div class="flex-1">
                                <input type="file" id="image" name="image" accept="image/*" @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }" class="block w-full text-sm text-stone-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-stone-100 file:text-stone-700 hover:file:bg-stone-200 cursor-pointer" />
                                @error('image')
                                    <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-stone-200">
                        <a href="{{ route('admin.menus.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white text-sm font-medium rounded-lg transition shadow-sm focus:ring-2 focus:ring-coffee-600">
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
