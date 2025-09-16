<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survei UIN Antasari</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center font-sans antialiased">
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 w-full max-w-2xl text-center animate-fade-in-up transition-all duration-500">
        <h1 class="text-4xl md:text-5xl font-extrabold text-uin-green mb-4">
            Aplikasi Survei
        </h1>
        <p class="text-lg md:text-xl text-gray-700 mb-6">
            Platform digital untuk mempermudah pengelolaan survei dan pengumpulan data di lingkungan UIN Antasari Banjarmasin.
        </p>
        <a href="{{ route('login') }}" class="inline-block py-3 px-8 text-lg font-semibold text-white bg-uin-green rounded-xl hover:bg-uin-gold hover:text-gray-800 transition-all duration-300 shadow-md transform hover:scale-105">
            Masuk ke Sistem
        </a>
    </div>
</body>

</html>