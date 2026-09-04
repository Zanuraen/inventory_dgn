<x-layouts.app>

    <x-header-banner
        title="Tambah Aset"
        description="Lengkapi informasi aset baru untuk ditambahkan ke inventaris perusahaan."
    />

    <div class="p-4 sm:p-6">
        <div class="bg-white border border-[#E5E7EB] rounded-xl p-4 sm:p-6 max-w-3xl mx-auto">

            {{-- Tampilkan semua pesan error validasi sekaligus di atas form --}}
            @if ($errors->any())
                <div class="bg-[#FFEBEE] text-[#D32F2F] text-sm rounded-lg p-4 mb-5">
                    <p class="font-medium mb-1">Periksa kembali data yang kamu isi:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                x-data="{ preview: null, handleImage(e) {
                    const file = e.target.files[0];
                    this.preview = file ? URL.createObjectURL(file) : null;
                } }"
                action="{{ route('assets.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-5"
            >
                @csrf

                @include('assets.form')

                {{-- Tombol aksi, full-width stack di mobile, sejajar di desktop --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                    <a href="{{ route('assets.index') }}"
                        class="text-center border border-gray-300 text-gray-600 font-medium px-5 py-2.5 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#F26522] hover:bg-[#FF7A00] text-white font-medium px-5 py-2.5 rounded-lg transition">
                        Simpan Aset
                    </button>
                </div>

            </form>
        </div>
    </div>

</x-layouts.app>