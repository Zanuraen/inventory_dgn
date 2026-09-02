<div class="bg-white rounded-lg shadow p-6">

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <span class="text-orange-500 text-lg">🏷️</span>
            <h2 class="text-sm font-bold text-gray-700 tracking-wide">
                KATEGORI &amp; KODE ASET
            </h2>
        </div>
        <a href="{{ route('categories.create') }}"
           class="w-7 h-7 flex items-center justify-center rounded bg-[#F26522] text-white hover:bg-orange-600 transition"
           title="Tambah kategori">
            +
        </a>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-y border-gray-200 text-gray-500 text-xs uppercase tracking-wide">
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
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="text-orange-500 hover:underline text-xs font-semibold">EDIT</a>

                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori &quot;{{ $category->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-500 hover:underline text-xs font-semibold">HAPUS</button>
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