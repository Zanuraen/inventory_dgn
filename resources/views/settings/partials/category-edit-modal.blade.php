<div
    x-show="showEditCategoryModal"
    x-cloak
    x-transition
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
>
    <div
        @click.outside="showEditCategoryModal = false"
        x-show="editCategoryData"
        class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
    >
        <template x-if="editCategoryData">
            <form :action="'/categories/' + editCategoryData.id" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_modal_source" value="edit">
                <input type="hidden" name="id" x-model="editCategoryData.id">

                <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                    <h2 class="text-lg font-semibold text-[#111827]">Edit Kategori</h2>
                    <button type="button" @click="showEditCategoryModal = false" class="text-gray-400 hover:text-gray-600">
                        <x-icon name="x" class="w-5 h-5" />
                    </button>
                </div>

                <div class="px-6 py-5 space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-700">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" x-model="editCategoryData.name"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Kode <span class="text-red-500">*</span></label>
                        <input type="text" name="code" x-model="editCategoryData.code"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700">Deskripsi (opsional)</label>
                        <textarea name="description" rows="3" x-model="editCategoryData.description"
                            class="mt-1 w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                    <button type="button" @click="showEditCategoryModal = false"
                        class="px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg border border-gray-300 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-[#F26522] hover:bg-[#FF7A00] rounded-lg">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </template>
    </div>
</div>