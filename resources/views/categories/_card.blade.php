<div class="bg-bg-surface rounded-card shadow-card p-6">

    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-2">
            <span class="text-accent text-lg">🏷️</span>
            <h2 class="text-sm font-bold text-text-primary tracking-wide">
                KATEGORI &amp; KODE ASET
            </h2>
        </div>
        <a href="{{ route('categories.create') }}"
           class="w-7 h-7 flex items-center justify-center rounded bg-accent text-white hover:bg-accent-bright transition"
           title="Tambah kategori">
            +
        </a>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="bg-bg-page border-y border-border-subtle text-text-secondary text-xs uppercase tracking-wide">
                <th class="py-2.5 text-center font-semibold">Nama Kategori</th>
                <th class="py-2.5 text-center font-semibold">Jumlah Barang</th>
                <th class="py-2.5 text-center font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr class="border-b border-border-subtle">
                    <td class="py-3 text-center font-medium text-primary">
                        {{ $category->name }}
                    </td>
                    <td class="py-3 text-center text-text-secondary">
                        {{ $category->assets_count }} barang
                    </td>
                    <td class="py-3 text-center">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="text-text-secondary hover:text-primary transition"
                               title="Edit kategori">
                                <x-icon name="pencil" class="w-4 h-4" />
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Hapus kategori &quot;{{ $category->name }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-text-secondary hover:text-danger-text transition" title="Hapus kategori">
                                    <x-icon name="trash" class="w-4 h-4" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-text-muted text-xs">
                        Belum ada kategori.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>