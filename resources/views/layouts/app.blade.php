<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris Kantor')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
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
</html>