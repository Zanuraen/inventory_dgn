<div x-data="{
        showUploadModal: false,
        lightboxOpen: false,
        lightboxIndex: 0,
        photos: {{ $asset->photos->map(fn($p) => [
    'id' => $p->id,
    'url' => asset('storage/' . $p->path),
    'is_cover' => $p->is_cover,
])->toJson() }},
        maxVisible: 4,
        openLightbox(index) {
            this.lightboxIndex = index;
            this.lightboxOpen = true;
        },
        nextPhoto() {
            this.lightboxIndex = (this.lightboxIndex + 1) % this.photos.length;
        },
        prevPhoto() {
            this.lightboxIndex = (this.lightboxIndex - 1 + this.photos.length) % this.photos.length;
        }
    }" class="bg-white border border-[#E5E7EB] rounded-xl p-5 sm:p-6">
    <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3 mb-4">Foto Produk</h2>

    {{-- Empty state --}}
    <template x-if="photos.length === 0">
        <div class="text-center py-10">
            <x-icon name="box" class="w-10 h-10 text-gray-300 mx-auto mb-2" />
            <p class="text-sm text-gray-400 mb-3">Belum ada foto untuk aset ini</p>
            <button type="button" @click="showUploadModal = true"
                class="bg-[#F26522] hover:bg-[#FF7A00] text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                + Tambah Foto Pertama
            </button>
        </div>
    </template>

    {{-- Grid foto --}}
    <template x-if="photos.length > 0">
        <div>
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                <template x-for="(photo, index) in photos.slice(0, maxVisible)" :key="photo.id">
                    <div class="relative group aspect-square rounded-lg overflow-hidden cursor-pointer"
                        @click="openLightbox(index)">

                        <img :src="photo.url" class="w-full h-full object-cover">

                        <template x-if="index === maxVisible - 1 && photos.length > maxVisible">
                            <div
                                class="absolute inset-0 bg-black/60 flex items-center justify-center text-white font-semibold text-lg">
                                +<span x-text="photos.length - maxVisible"></span>
                            </div>
                        </template>

                        <div
                            class="absolute top-1.5 right-1.5 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition">
                            <button type="button" @click.stop="$dispatch('set-cover-photo', { photoId: photo.id })"
                                class="w-6 h-6 rounded-full bg-white/90 flex items-center justify-center"
                                :class="photo.is_cover ? 'text-[#F26522]' : 'text-gray-400'">
                                <svg viewBox="0 0 24 24" class="w-3.5 h-3.5"
                                    :fill="photo.is_cover ? 'currentColor' : 'none'" stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.27 5.82 21 7 14.14l-5-4.87 6.91-1.01L12 2z" />
                                </svg>
                            </button>
                            <button type="button" @click.stop="$dispatch('delete-photo', { photoId: photo.id })"
                                class="w-6 h-6 rounded-full bg-white/90 flex items-center justify-center text-gray-400 hover:text-[#D32F2F]">
                                <x-icon name="trash" class="w-3.5 h-3.5" />
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <button type="button" @click="showUploadModal = true"
                class="mt-4 text-sm text-[#F26522] font-medium hover:underline">
                + Tambah Foto
            </button>
        </div>
    </template>

    {{-- Lightbox --}}
    <div x-show="lightboxOpen" x-cloak @keydown.escape.window="lightboxOpen = false"
        @keydown.arrow-right.window="nextPhoto()" @keydown.arrow-left.window="prevPhoto()"
        class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4">

        <button type="button" @click="lightboxOpen = false"
            class="absolute top-4 right-4 text-white/70 hover:text-white text-2xl">&times;</button>

        <div class="absolute top-4 left-4 flex gap-2">
            <button type="button" @click="$dispatch('set-cover-photo', { photoId: photos[lightboxIndex].id })"
                class="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center"
                :class="photos[lightboxIndex]?.is_cover ? 'text-[#F26522]' : 'text-gray-500'">
                <svg viewBox="0 0 24 24" class="w-4.5 h-4.5"
                    :fill="photos[lightboxIndex]?.is_cover ? 'currentColor' : 'none'" stroke="currentColor"
                    stroke-width="2">
                    <path
                        d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.27 5.82 21 7 14.14l-5-4.87 6.91-1.01L12 2z" />
                </svg>
            </button>
            <button type="button" @click="$dispatch('delete-photo', { photoId: photos[lightboxIndex].id })"
                class="w-9 h-9 rounded-full bg-white/90 flex items-center justify-center text-gray-500 hover:text-[#D32F2F]">
                <x-icon name="trash" class="w-4.5 h-4.5" />
            </button>
        </div>

        <button type="button" @click="prevPhoto()"
            class="absolute left-4 text-white/70 hover:text-white text-3xl">&#8249;</button>

        <img :src="photos[lightboxIndex]?.url" class="max-h-[80vh] max-w-full rounded-lg object-contain">

        <button type="button" @click="nextPhoto()"
            class="absolute right-4 text-white/70 hover:text-white text-3xl">&#8250;</button>

        <div class="absolute bottom-6 text-white/80 text-sm">
            <span x-text="lightboxIndex + 1"></span> / <span x-text="photos.length"></span>
        </div>
    </div>

    {{-- Modal Upload Foto --}}
    <div x-show="showUploadModal" x-cloak x-data="{
            files: [],
            previews: [],
            submitting: false,
            handleFiles(e) {
                // Gabungkan file baru dengan yang sudah ada, jangan timpa
                const newFiles = Array.from(e.target.files);
                this.files = [...this.files, ...newFiles];
                this.previews = [...this.previews, ...newFiles.map(f => URL.createObjectURL(f))];
                e.target.value = '';
            },
            removeFile(index) {
                this.files.splice(index, 1);
                this.previews.splice(index, 1);
            },
            buildFileList() {
                const dt = new DataTransfer();
                this.files.forEach(file => dt.items.add(file));
                this.$refs.fileInput.files = dt.files;
            }
        }" @click.outside="showUploadModal = false"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="bg-white w-full max-w-md rounded-xl shadow-lg overflow-hidden">
            <div class="bg-[#0A4C62] px-6 py-4 flex items-center justify-between">
                <h2 class="text-white text-lg font-bold">Tambah Foto</h2>
                <button type="button" @click="showUploadModal = false"
                    class="text-white/80 hover:text-white text-xl leading-none">&times;</button>
            </div>

            <form action="{{ route('assets.photos.store', $asset) }}" method="POST" enctype="multipart/form-data"
                @submit="submitting = true; buildFileList()" x-ref="uploadForm" class="p-6 space-y-4">
                @csrf

                <label
                    class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center py-8 cursor-pointer hover:border-[#F26522] transition">
                    <input type="file" name="photos[]" accept="image/*" multiple x-ref="fileInput"
                        @change="handleFiles($event)" class="hidden">
                    <x-icon name="box" class="w-8 h-8 text-gray-300 mb-2" />
                    <span class="text-sm text-gray-400">Klik / pilih foto (bisa lebih dari satu)</span>
                </label>

                <template x-if="previews.length > 0">
                    <div class="grid grid-cols-4 gap-2">
                        <template x-for="(src, index) in previews" :key="index">
                            <div class="relative aspect-square rounded-lg overflow-hidden">
                                <img :src="src" class="w-full h-full object-cover">
                                <button type="button" @click="removeFile(index)"
                                    class="absolute top-0.5 right-0.5 w-5 h-5 rounded-full bg-black/60 text-white text-xs flex items-center justify-center">
                                    &times;
                                </button>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showUploadModal = false"
                        class="border border-gray-300 text-gray-600 font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit" :disabled="submitting || files.length === 0"
                        class="bg-[#F26522] hover:bg-[#FF7A00] text-white font-medium px-4 py-2 rounded-lg transition disabled:opacity-50">
                        <span x-show="!submitting">Upload</span>
                        <span x-show="submitting">Mengupload...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hidden form: set cover, dipicu event 'set-cover-photo' --}}
    <form x-ref="setCoverForm" method="POST" class="hidden" x-on:set-cover-photo.window="
            $refs.setCoverForm.action = `/assets/{{ $asset->id }}/photos/${$event.detail.photoId}/cover`;
            $refs.setCoverForm.submit();
        ">
        @csrf
        @method('PATCH')
    </form>

    {{-- Hidden form: hapus foto, dipicu event 'delete-photo' --}}
    <form x-ref="deletePhotoForm" method="POST" class="hidden" x-on:delete-photo.window="
            if (confirm('Yakin hapus foto ini?')) {
                $refs.deletePhotoForm.action = `/assets/{{ $asset->id }}/photos/${$event.detail.photoId}`;
                $refs.deletePhotoForm.submit();
            }
        ">
        @csrf
        @method('DELETE')
    </form>
</div>