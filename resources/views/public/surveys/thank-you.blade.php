<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih!</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center">

    <main class="container mx-auto p-4">
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-lg text-center p-8">
            <svg class="w-16 h-16 mx-auto text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>

            <h1 class="text-3xl font-bold text-gray-800 mt-4">Terima Kasih!</h1>

            @if(session('info'))
            <p class="mt-2 text-gray-600">{{ session('info') }}</p>
            @else
            <p class="mt-2 text-gray-600">Jawaban survei Anda telah berhasil kami simpan. Partisipasi Anda sangat berarti bagi kami.</p>
            @endif

            <div class="mt-8">
                <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </main>

</body>

</html>