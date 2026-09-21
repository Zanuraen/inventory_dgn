<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login — Inventaris Digitelnusa</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-bg-page font-sans antialiased">

    <div class="min-h-screen flex">

        <!-- =========================
             LEFT SIDE - BRANDING
        ========================== -->
        <div class="hidden lg:flex lg:w-1/2 bg-primary-darker relative overflow-hidden">

            <!-- Background decoration -->
            <div class="absolute -top-32 -left-32 w-96 h-96 bg-primary/40 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-accent/20 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex flex-col justify-between w-full px-16 xl:px-24 py-16 text-white">

                <!-- Logo -->
                <div class="inline-flex items-center rounded-xl bg-white px-4 py-3 shadow-lg w-fit">
                    <img
                        src="{{ asset('images/dgn-logo.png') }}"
                        alt="Digitelnusa"
                        class="h-8 w-auto object-contain"
                    >
                </div>

                <div>

                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 mb-6 rounded-full bg-white/10 border border-white/10 text-xs font-medium text-slate-200">
                        <span class="w-2 h-2 rounded-full bg-accent"></span>
                        Internal Inventory System
                    </div>

                    <!-- Heading -->
                    <h1 class="text-4xl xl:text-5xl font-bold leading-tight tracking-tight">
                        Kelola aset perusahaan
                        <span class="text-accent">lebih mudah.</span>
                    </h1>

                    <p class="mt-6 text-slate-300 text-base leading-relaxed max-w-lg">
                        Sistem inventaris terintegrasi untuk mengelola data barang, kategori,
                        pemeliharaan aset, dan laporan inventaris perusahaan dalam satu tempat.
                    </p>

                    <!-- Feature -->
                    <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center shrink-0">
                                <x-icon name="box" class="h-5 w-5 text-accent" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Pengelolaan Aset</p>
                                <p class="text-xs text-slate-400">Data barang terorganisir</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center shrink-0">
                                <x-icon name="file-text" class="h-5 w-5 text-accent" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Laporan Terintegrasi</p>
                                <p class="text-xs text-slate-400">Rekap inventaris otomatis</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center shrink-0">
                                <x-icon name="wrench" class="h-5 w-5 text-accent" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Riwayat Pemeliharaan</p>
                                <p class="text-xs text-slate-400">Jadwal &amp; status aset</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white/10 border border-white/10 flex items-center justify-center shrink-0">
                                <x-icon name="check-circle" class="h-5 w-5 text-accent" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-white">Akses Terstruktur</p>
                                <p class="text-xs text-slate-400">Khusus administrator</p>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <p class="text-xs text-slate-500">
                    © {{ date('Y') }} Digitelnusa. Internal use only.
                </p>

            </div>
        </div>


        <!-- =========================
             RIGHT SIDE - LOGIN
        ========================== -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="flex justify-center mb-8 lg:hidden">
                    <img
                        src="{{ asset('images/dgn-logo.png') }}"
                        alt="Digitelnusa"
                        class="h-9 w-auto object-contain"
                    >
                </div>

                <!-- Login Header -->
                <div class="text-center lg:text-left mb-8">

                    <p class="text-sm font-semibold text-accent mb-2 tracking-wide">
                        INVENTARIS DIGITELNUSA
                    </p>

                    <h2 class="text-3xl font-bold text-text-primary">
                        Selamat Datang
                    </h2>

                    <p class="mt-2 text-text-secondary">
                        Silakan masuk untuk mengakses dashboard.
                    </p>

                </div>

                <!-- Login Card -->
                <div class="rounded-card border border-border-subtle bg-bg-surface shadow-card p-8">

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-5 flex items-start gap-3 rounded-button bg-success-bg px-4 py-3 text-sm text-success-text">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-5 rounded-button bg-danger-bg px-4 py-3">
                            <p class="text-sm font-medium text-danger-text">
                                Login gagal
                            </p>
                            <ul class="mt-1 text-sm text-danger-text list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Nama Pengguna -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-text-secondary mb-2">
                                Nama Pengguna
                            </label>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Masukkan nama pengguna Anda"
                                class="w-full rounded-lg border border-border-subtle bg-bg-page px-4 py-3 text-sm text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition"
                            >
                        </div>

                        <!-- Password -->
                        <div class="mt-5">
                            <label for="password" class="block text-sm font-medium text-text-secondary mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password Anda"
                                class="w-full rounded-lg border border-border-subtle bg-bg-page px-4 py-3 text-sm text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition"
                            >
                        </div>

                        <!-- Remember -->
                        <div class="flex items-center justify-between mt-5">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="rounded border-border-subtle text-accent focus:ring-accent"
                                >
                                <span class="text-sm text-text-secondary">
                                    Ingat saya
                                </span>
                            </label>
                        </div>

                        <!-- Button -->
                        <button
                            type="submit"
                            class="w-full mt-7 inline-flex items-center justify-center gap-2 rounded-button bg-accent hover:bg-accent-bright text-white font-semibold py-3.5 text-sm shadow-card transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-accent focus-visible:ring-offset-2"
                        >
                            Masuk ke Dashboard
                        </button>

                    </form>

                </div>

                <!-- Footer -->
                <div class="text-center mt-8">
                    <p class="text-xs text-text-muted">
                        © {{ date('Y') }} Inventaris Digitelnusa
                    </p>
                    <p class="text-xs text-text-muted mt-1">
                        Sistem Manajemen Inventaris Perusahaan
                    </p>
                </div>

            </div>

        </div>

    </div>

</body>
</html>