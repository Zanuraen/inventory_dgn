@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="bg-white rounded-lg shadow p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-gray-800">Kategori Aset</h1>
        <a href="{{ route('categories.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Kategori
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
                    <td class="py-3 pr-4 text-right space-x-2">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="text-blue-600 hover:underline">Edit</a>

                        <form action="{{ route('categories.destroy', $category) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
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