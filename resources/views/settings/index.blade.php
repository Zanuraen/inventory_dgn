<x-layouts.app>

    <div x-data="{
        showAddCategoryModal: {{ old('_modal_source') === 'add' ? 'true' : 'false' }},
        showEditCategoryModal: {{ old('_modal_source') === 'edit' ? 'true' : 'false' }},
        editCategoryData: {{ old('_modal_source') === 'edit' ? Js::from(['id' => old('id'), 'name' => old('name'), 'code' => old('code'), 'description' => old('description')]) : 'null' }},
    }" @open-category-edit.window="editCategoryData = $event.detail; showEditCategoryModal = true">

        <x-header-banner title="Pengaturan Sistem"
            description="PT Digital Inteligensi Nusantara — Sistem Inventaris Aset" />

        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Kartu Informasi Perusahaan --}}
                @include('settings._company_card', ['company' => $company])

                {{-- Kartu Kategori & Kode Aset --}}
                <div class="bg-white rounded-lg shadow p-6">

                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-orange-500 text-lg">🏷️</span>
                            <h2 class="text-sm font-bold text-gray-700 tracking-wide">
                                KATEGORI &amp; KODE ASET
                            </h2>
                        </div>
                        <button type="button" @click="showAddCategoryModal = true"
                            class="w-7 h-7 flex items-center justify-center rounded bg-[#F26522] text-white hover:bg-orange-600 transition"
                            title="Tambah kategori">
                            +
                        </button>
                    </div>

                    <table class="w-full text-sm">
                        <thead>
                            <tr
                                class="bg-gray-50 border-y border-gray-200 text-gray-500 text-xs uppercase tracking-wide">
                                <th class="py-2.5 text-center font-semibold">Nama Kategori</th>
                                <th class="py-2.5 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                                        <tr class="border-b border-gray-100">
                                                            <td class="py-3 text-center font-medium text-[#0B4A63]">
                                                                {{ $category->name }}
                                                            </td>
                                                            <td class="py-3 text-center">
                                                                <div class="flex items-center justify-center gap-2">
                                                                    <button type="button" @click="$dispatch('open-category-edit', {{ Js::from([
                                    'id' => $category->id,
                                    'name' => $category->name,
                                    'code' => $category->code,
                                    'description' => $category->description,
                                ]) }})" class="text-gray-400 hover:text-[#0A4C62]" title="Edit">
                                                                        <x-icon name="pencil" class="w-4 h-4" />
                                                                    </button>

                                                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                                        onsubmit="return confirm('Hapus kategori &quot;{{ $category->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="text-gray-400 hover:text-[#D32F2F]"
                                                                            title="Hapus">
                                                                            <x-icon name="trash" class="w-4 h-4" />
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-gray-400 text-xs">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        @include('settings.partials.category-create-modal')
        @include('settings.partials.category-edit-modal')

    </div>

</x-layouts.app>