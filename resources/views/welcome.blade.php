<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Survei UIN Antasari</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50">
    <header class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo UIN Antasari" class="h-10 w-10">
                    <span class="font-bold text-xl text-gray-800">Survei UIN Antasari</span>
                </div>
                <div class="flex items-center">
                    @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm font-medium text-gray-600 hover:text-indigo-600">
                            <span>{{ Auth::user()->username }}</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                            </form>
                        </div>
                    </div>
                    @else
                    {{-- DIPERBAIKI: Tautan ini sekarang mengarah ke halaman login terpadu yang benar --}}
                    <a href="{{ route('login') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                        Masuk
                    </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="container mx-auto mt-10 px-4 sm:px-6 lg:px-8">
        <section class="text-center py-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 tracking-tight">Suara Anda Membangun Masa Depan</h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">Partisipasi Anda dalam survei ini sangat berarti untuk peningkatan kualitas layanan dan fasilitas di lingkungan UIN Antasari Banjarmasin.</p>
        </section>

        <section class="mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-6">Survei yang Tersedia</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($surveys as $survey)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">{{ $survey->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Untuk: {{ $survey->unitKerja->pluck('uk_short_name')->join(', ') }}</p>
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Aktif</span>
                        </div>
                        <p class="mt-4 text-gray-600 text-sm h-16">{{ Str::limit($survey->description, 120) }}</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-4">
                        <a href="{{ route('surveys.fill', $survey) }}" class="w-full block text-center bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">Mulai Isi Survei</a>
                    </div>
                </div>
                @empty
                <div class="md:col-span-2 lg:col-span-3 text-center py-16 px-4 bg-white rounded-xl shadow-md border-2 border-dashed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-4 font-semibold text-gray-600">Belum Ada Survei yang Aktif</p>
                    <p class="text-sm mt-1">Silakan kembali lagi nanti untuk berpartisipasi.</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>

    <footer class="mt-16 py-8 bg-white border-t">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
            &copy; {{ date('Y') }} UIN Antasari Banjarmasin. All rights reserved.
        </div>
    </footer>
</body>

</html>