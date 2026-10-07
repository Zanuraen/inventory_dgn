@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')

<div class="bg-[#0A4C62] text-white rounded-lg px-6 py-5 mb-6">
    <h1 class="text-lg font-bold">Pengaturan Sistem</h1>
    <p class="text-sm text-blue-200 mt-1">
        {{ $company->company_name }} — Sistem Inventaris Aset
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Kartu Informasi Perusahaan --}}
    @include('settings._company_card', ['company' => $company])

    {{-- Kartu Kategori & Kode Aset --}}
    @include('categories._card', ['categories' => $categories])

</div>

@endsection