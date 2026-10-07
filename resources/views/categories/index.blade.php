@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-bold text-gray-800">Kategori Aset</h1>
            <a href="{{ route('categories.create') }}"
                class="bg-[#F26522] hover:bg-[#FF7A00] text-white text-sm font-medium px-3.5 py-2 rounded-lg inline-flex items-center justify-center gap-1.5 transition">
                <x-icon name="plus" class="w-4 h-4" />
                Tambah Kategori
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 text-gray-500">
                    <th class="py-2 pr-4">Kode</th>
                    <th class="py-2 pr-4">Nama</th>
                    <th class="py-2 pr-4">Deskripsi</th>
                    <th class="py-2 pr-4">Jumlah Aset</th>
                    <th class="py-2 pr-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr class="border-b border-gray-100">
                        <td class="py-3 pr-4 font-mono text-gray-600">{{ $category->code }}</td>
                        <td class="py-3 pr-4">{{ $category->name }}</td>
                        <td class="py-3 pr-4 text-gray-500">{{ $category->description ?: '-' }}</td>
                        <td class="py-3 pr-4">{{ $category->assets_count }}</td>
                        <td class="py-3 pr-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="text-gray-400 hover:text-[#0A4C62]"
                                    title="Edit">
                                    <x-icon name="pencil" class="w-4 h-4" />
                                </a>

                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-[#D32F2F]" title="Hapus">
                                        <x-icon name="trash" class="w-4 h-4" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-400">
                            Belum ada kategori. Klik "Tambah Kategori" untuk mulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $categories->links() }}
        </div>

    </div>
@endsection