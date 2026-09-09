@php
    // $asset akan berisi data (dari DB) kalau dipanggil dari edit.blade.php
    // akan null kalau dipanggil dari create.blade.php — supaya old()/value bisa fallback aman
    $asset = $asset ?? null;
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
        <select name="category_id" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $asset?->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang *</label>
        <input type="text" name="name" value="{{ old('name', $asset?->name) }}" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Aset *</label>
        <input type="text" name="code_asset" value="{{ old('code_asset', $asset?->code_asset) }}" required
            placeholder="Contoh: INV-2026-001"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Serial Number</label>
        <input type="text" name="serial_number" value="{{ old('serial_number', $asset?->serial_number) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi *</label>
        <select name="condition_status" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
            <option value="">-- Pilih Kondisi --</option>
            @foreach (['Baik', 'Rusak Ringan', 'Rusak Berat'] as $status)
                <option value="{{ $status }}" @selected(old('condition_status', $asset?->condition_status) === $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Qty) *</label>
        <input type="number" name="qty" value="{{ old('qty', $asset?->qty ?? 1) }}" min="0" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Pengguna</label>
        <input type="text" name="pengguna" value="{{ old('pengguna', $asset?->pengguna) }}"
            placeholder="Contoh: Zen (Divisi IT)"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
        <input type="text" name="location" value="{{ old('location', $asset?->location) }}"
            placeholder="Contoh: Lantai 3 - IT Room"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Beli *</label>
        <input type="date" name="tanggal_beli"
            value="{{ old('tanggal_beli', $asset?->tanggal_beli?->format('Y-m-d')) }}" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Beli (Rp) *</label>
        <input type="number" name="harga_beli" value="{{ old('harga_beli', $asset?->harga_beli) }}" min="0" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Spesifikasi</label>
        <input type="text" name="spesifikasi" value="{{ old('spesifikasi', $asset?->spesifikasi) }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
        <textarea name="description" rows="3"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#0A4C62] focus:outline-none">{{ old('description', $asset?->description) }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Barang</label>
        <label class="border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center py-6 cursor-pointer hover:border-[#F26522] transition">
            <input type="file" name="image" accept="image/*" x-on:change="handleImage($event)" class="hidden">

            <template x-if="!preview">
                @if ($asset?->image)
                    {{-- Mode edit: tampilkan foto lama selama user belum pilih foto baru --}}
                    <img src="{{ asset('storage/' . $asset->image) }}" class="h-28 rounded-lg object-cover">
                @else
                    <span class="text-sm text-gray-400">Klik untuk upload foto barang</span>
                @endif
            </template>

            <template x-if="preview">
                <img :src="preview" class="h-28 rounded-lg object-cover">
            </template>
        </label>
        <p class="text-xs text-gray-400 mt-1">JPG/PNG, maks 2MB</p>
    </div>

</div>