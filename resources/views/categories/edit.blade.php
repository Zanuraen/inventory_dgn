@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="bg-white rounded-lg shadow p-6 max-w-lg">

    <h1 class="text-xl font-bold text-gray-800 mb-6">Edit Kategori</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm text-gray-600 mb-1">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Kode</label>
            <input type="text" name="code" value="{{ old('code', $category->code) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2">
            @error('code')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-600 mb-1">Deskripsi (opsional)</label>
            <textarea name="description" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('categories.index') }}"
               class="px-4 py-2 rounded border border-gray-300 text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit"
                    class="px-4 py-2 rounded bg-[#F26522] text-white hover:bg-orange-600 transition">Update</button>
        </div>
    </form>

</div>
@endsection