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
                    Edit Menu: {{ $menu->name }}
                </h2>
                <p class="text-sm text-stone-600 mt-0.5">
                    Perbarui informasi menu, kategori, harga, dan foto produk.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8" x-data="{ previewUrl: null }">
                <form method="POST" action="{{ route('admin.menus.update', $menu) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Menu -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-700">Nama Menu <span class="text-rose-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $menu->name) }}" required autofocus class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
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
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $menu->category_id) == $cat->id ? 'selected' : '' }}>
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
                                <input type="number" id="price" name="price" value="{{ old('price', (int)$menu->price) }}" required min="0" step="500" class="bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full ps-10 p-2.5" />
                            </div>
                            @error('price')
                                <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-stone-700">Deskripsi Menu <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <textarea id="description" name="description" rows="3" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">{{ old('description', $menu->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Upload Foto Menu -->
                    <div>
                        <label class="block text-sm font-semibold text-stone-700">Foto Menu</label>
                        <p class="text-xs text-stone-500 mb-2">Pilih file baru jika ingin mengganti foto saat ini. Format: JPG, PNG, WEBP (Max 2MB).</p>
                        
                        <div class="flex items-center space-x-6">
                            <!-- Preview Box -->
                            <div class="w-24 h-24 rounded-xl border-2 border-stone-200 bg-stone-50 flex items-center justify-center overflow-hidden flex-shrink-0 relative shadow-sm">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" alt="Foto Baru" class="w-full h-full object-cover" />
                                </template>
                                <template x-if="!previewUrl">
                                    @if ($menu->image_url)
                                        <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" class="w-full h-full object-cover" />
                                    @else
                                        <div class="text-center p-2 text-stone-400">
                                            <svg class="mx-auto h-8 w-8 text-stone-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-[10px] block mt-1">Belum Ada</span>
                                        </div>
                                    @endif
                                </template>
                            </div>

                            <!-- File Input -->
                            <div class="flex-1">
                                <input type="file" id="image" name="image" accept="image/*" @change="const file = $event.target.files[0]; if (file) { previewUrl = URL.createObjectURL(file); }" class="block w-full text-sm text-stone-500 file:me-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-stone-100 file:text-stone-700 hover:file:bg-stone-200 cursor-pointer" />
                                @if ($menu->image)
                                    <p class="text-xs text-emerald-700 font-medium mt-1.5 flex items-center">
                                        <svg class="w-3.5 h-3.5 me-1 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Foto aktif tersimpan di storage: {{ basename($menu->image) }}
                                    </p>
                                @endif
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
                            Perbarui Menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
