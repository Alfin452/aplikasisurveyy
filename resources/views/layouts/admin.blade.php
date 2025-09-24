<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- CSS untuk Flatpickr Time Picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- DIUBAH: State untuk semua modal sekarang dikelola di sini --}}

<body class="bg-gray-100 font-sans leading-normal tracking-normal"
    x-data="{ openLogout: false, openDeleteModal: false, deleteUrl: '', deleteItemName: '' }">

    {{-- Sidebar --}}
    <div class="bg-gradient-to-b from-cyan-500 to-blue-600 text-gray-100 h-screen w-64 fixed flex flex-col p-4 shadow-xl">
        <div class="text-2xl font-semibold text-white mb-6 flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UIN" class="w-10 h-10 rounded-full">
            SURVEY UIN Antasari
        </div>
        <nav class="flex-1">
            <a href="{{ route('superadmin.dashboard') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Dashboard
            </a>
            <a href="{{ route('unit-kerja.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Unit Kerja
            </a>
            <a href="{{ route('surveys.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Survei
            </a>
            <a href="{{ route('users.index') }}"
                class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">
                Manajemen Pengguna
            </a>
        </nav>
        <div class="mt-auto">
            <button @click="openLogout = true"
                class="w-full flex items-center gap-3 p-4 text-left text-gray-100 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-300 ease-in-out transform hover:scale-[1.02]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Konten -->
    <div class="flex-1 ml-64 p-1">
        <div class="bg-white rounded-xl shadow-md">
            @yield('content')
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div x-cloak x-show="openLogout" x-transition.opacity class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div x-show="openLogout" x-transition.scale class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex justify-center gap-3">
                <button @click="openLogout = false" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition transform hover:scale-105">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- DITAMBAHKAN: Modal Konfirmasi Hapus sekarang ada di sini, di lapisan teratas --}}
    <div x-cloak
        x-show="openDeleteModal"
        x-transition.opacity
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div x-show="openDeleteModal"
            x-transition.scale
            @click.away="openDeleteModal = false"
            class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md text-center">

            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mt-4">Konfirmasi Hapus</h2>
            <p class="text-gray-600 my-4">
                Apakah Anda yakin ingin menghapus <strong x-text="deleteItemName" class="font-semibold text-gray-900"></strong>?
                <br>Aksi ini tidak dapat dibatalkan.
            </p>
            <div class="flex justify-center gap-4 mt-6">
                <button @click="openDeleteModal = false" class="px-6 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold transition">
                    Batal
                </button>
                <form x-bind:action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold shadow-md transition transform hover:scale-105">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- JavaScript untuk Flatpickr Time Picker --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- "Slot" untuk skrip khusus dari halaman lain --}}
    @stack('scripts')
</body>

</html>