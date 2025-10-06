<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Survei: {{ $survey->title }}</title>
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

<body class="bg-slate-50">

    <main class="container mx-auto mt-10 p-4 md:p-8">
        <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ $survey->title }}</h1>
            <p class="mt-2 text-gray-600">{{ $survey->description }}</p>

            <div class="border-t my-6"></div>

            <form action="{{ route('surveys.storeResponse', $survey) }}" method="POST">
                @csrf
                <div class="space-y-8">
                    {{-- Pertanyaan akan ditampilkan di sini --}}
                    @foreach ($survey->questions as $question)
                    <div>
                        <p class="font-semibold text-gray-800">{{ $loop->iteration }}. {{ $question->question_body }}</p>
                        <div class="mt-4 space-y-3">
                            @foreach ($question->options as $option)
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-3 text-gray-700">{{ $option->option_body }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                        Kirim Jawaban Survei
                    </button>
                </div>
            </form>
        </div>
    </main>

</body>

</html>