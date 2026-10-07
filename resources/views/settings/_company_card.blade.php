<div class="bg-white rounded-lg shadow p-6">

    <div class="flex items-center gap-2 mb-4">
        <span class="text-orange-500 text-lg">🏢</span>
        <h2 class="text-sm font-bold text-gray-700 tracking-wide">
            INFORMASI PERUSAHAAN
        </h2>
    </div>

    <form action="{{ route('settings.company.update') }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs text-gray-500 tracking-wide mb-1">NAMA PERUSAHAAN</label>
            <input type="text" name="company_name" value="{{ old('company_name', $company->company_name) }}"
                   class="w-full bg-gray-100 border border-gray-200 rounded px-3 py-2 font-semibold text-[#0B4A63] focus:outline-none focus:ring-2 focus:ring-[#0B4A63]/30">
            @error('company_name')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs text-gray-500 tracking-wide mb-1">KODE SINGKATAN</label>
            <input type="text" name="company_code" value="{{ old('company_code', $company->company_code) }}"
                   class="w-full bg-gray-100 border border-gray-200 rounded px-3 py-2 font-semibold text-[#0B4A63] focus:outline-none focus:ring-2 focus:ring-[#0B4A63]/30">
            @error('company_code')
                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end pt-1">
            <button type="submit"
                    class="px-4 py-2 rounded bg-[#F26522] text-white text-sm font-semibold hover:bg-orange-600 transition">
                Simpan
            </button>
        </div>
    </form>

</div>