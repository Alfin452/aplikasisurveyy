<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin Unit Kerja</title>

    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

{{-- DIUBAH: Menambahkan variabel untuk modal hapus ke dalam x-data --}}

<body class="bg-gray-100" x-data="{ openLogout: false, openDeleteModal: false, deleteUrl: '', deleteItemName: '' }">

    {{-- Sidebar --}}
    <div class="bg-gradient-to-b from-teal-500 to-cyan-600 text-gray-100 h-screen w-64 fixed flex flex-col p-4 shadow-xl">
        <div class="text-2xl font-semibold text-white mb-2 flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo UIN" class="w-10 h-10 rounded-full">
            <span>SURVEY UIN</span>
        </div>
        <div class="text-sm text-cyan-200 pl-12 mb-6">Panel Unit Kerja</div>
        <nav class="flex-1">
            <a href="{{ route('unitkerja.admin.dashboard') }}" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Dasbor</a>
            <a href="{{ route('unitkerja.admin.surveys.index') }}" class="block p-4 text-gray-100 hover:bg-white/10 hover:text-yellow-300 rounded-lg transition duration-300">Manajemen Survei</a>
        </nav>
        <div class="mt-auto">
            <button @click="openLogout = true" class="w-full flex items-center gap-3 p-4 text-left text-gray-100 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </button>
        </div>
    </div>

    <!-- Konten Utama -->
    <main class="ml-64 p-8">
        @yield('content')
    </main>

    <!-- Modal Konfirmasi Logout -->
    <div x-cloak x-show="openLogout" x-transition.opacity class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div x-show="openLogout" @click.away="openLogout = false" x-transition.scale class="bg-white rounded-xl shadow-xl p-6 w-80 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Logout</h2>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar?</p>
            <div class="flex justify-center gap-3">
                <button @click="openLogout = false" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">Batal</button>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition">Logout</button>
                </form>
            </div>
        </div>
    </div>

    {{-- DITAMBAHKAN: Modal Konfirmasi Hapus --}}
    <div x-cloak x-show="openDeleteModal" x-transition.opacity class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div x-show="openDeleteModal" @click.away="openDeleteModal = false" x-transition.scale class="bg-white rounded-xl shadow-xl p-6 w-96 text-center">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Hapus</h2>
            <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menghapus item ini?</p>
            <p class="font-bold text-red-600 mb-6" x-text="deleteItemName"></p>
            <div class="flex justify-center gap-3">
                <button @click="openDeleteModal = false" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium transition">Batal</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white font-medium shadow-md transition">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>