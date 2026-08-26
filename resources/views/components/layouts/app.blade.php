<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} — Inventaris Digitelnusa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-bg-page font-sans text-text-primary antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-full">

        <x-sidebar />

        {{-- lg:pl-(--width-sidebar) reserves space for the always-visible desktop sidebar --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-(--width-sidebar)">
            <x-topbar />

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    <x-flash-alert />
</body>
</html>
