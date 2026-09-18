<div
    x-show="showAddCategoryModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
>
    <div
        @click.outside="showAddCategoryModal = false"
        class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
    >
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <input type="hidden" name="_modal_source" value="add">

            <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h2 class="text-lg font-semibold text-[#111827]">Tambah Kategori</h2>
                    <p class="text-sm text-gray-400 mt-0.5">Menambahkan kategori aset baru.</p>
                </div>
                <button type="button" @click="showAddCategoryModal = false" class="text-gray-400 hover:text-gray-600">
                    <x-icon name="x" class="w-5 h-5" />
                </button>
            </div>

            <div class="px-6 py-5 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Kode <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}"
                        placeholder="Contoh: A / ELK"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('code') border-red-400 @enderror">
                    @error('code')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                    <textarea name="description" rows="3"
                        class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none @error('description') border-red-400 @enderror">{{ old('description') }}</textarea>
                    @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                <button type="button" @click="showAddCategoryModal = false"
                    class="px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg border border-gray-300 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2.5 text-sm font-medium text-white bg-[#F26522] hover:bg-[#FF7A00] rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>