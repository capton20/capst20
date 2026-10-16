<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="p-2 text-stone-500 hover:text-stone-800 hover:bg-stone-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="font-bold text-2xl text-stone-900 leading-tight">
                    Edit Kategori: {{ $category->name }}
                </h2>
                <p class="text-sm text-stone-600 mt-0.5">
                    Perbarui nama dan deskripsi kategori menu.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-stone-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Nama Kategori -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-stone-700">Nama Kategori <span class="text-rose-600">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required autofocus class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5" />
                        @error('name')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug URL (Read-only reference) -->
                    <div>
                        <label class="block text-sm font-semibold text-stone-700">Slug Saat Ini</label>
                        <input type="text" value="{{ $category->slug }}" disabled class="mt-1.5 bg-stone-100 border border-stone-200 text-stone-500 text-xs font-mono rounded-lg block w-full p-2.5 cursor-not-allowed" />
                        <p class="mt-1 text-xs text-stone-500">Slug akan otomatis diperbarui mengikuti perubahan nama kategori.</p>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-stone-700">Deskripsi Kategori <span class="text-stone-400 font-normal">(Opsional)</span></label>
                        <textarea id="description" name="description" rows="4" class="mt-1.5 bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-amber-700 focus:border-amber-700 block w-full p-2.5">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-rose-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-6 border-t border-stone-200">
                        <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-medium rounded-lg transition">
                            Batal
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-coffee-800 hover:bg-coffee-900 text-white text-sm font-medium rounded-lg transition shadow-sm focus:ring-2 focus:ring-coffee-600">
                            Perbarui Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
