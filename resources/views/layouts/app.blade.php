<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Inventaris Kantor'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@if (isset($slot))
    {{-- Mode Breeze: dipakai <x-app-layout> (halaman profil) --}}
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
@else
    {{-- Mode @extends: dipakai kategori, laporan, settings --}}
    <body x-data="{ sidebarOpen: false }" class="bg-bg-page text-text-primary">

        <x-flash-alert />

        <x-sidebar />

        <div class="flex min-h-screen flex-col lg:pl-(--width-sidebar)">

            {{-- Topbar mobile: hamburger, logo, avatar (cuma tampil di HP/tablet) --}}
            <x-topbar />

            <main class="flex-1 p-6">
                @yield('content')
            </main>
        </div>

    </body>
@endif
</html>