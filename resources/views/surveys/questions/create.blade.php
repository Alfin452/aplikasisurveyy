@extends('layouts.admin')

@section('content')
<div class="p-6 bg-white rounded-xl shadow-md animate-fade-in-up">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"><br class="md:hidden">{{ $survey->title }}</h1>
    <form action="{{ route('surveys.questions.store', $survey->id) }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="question_body" class="block text-sm font-semibold text-gray-700 mb-1">Teks Pertanyaan:</label>
                <textarea id="question_body" name="question_body" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm transition duration-300 ease-in-out focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required></textarea>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:space-x-6 space-y-4 md:space-y-0">
                <label class="text-sm font-semibold text-gray-700">Tipe Pertanyaan:</label>
                <div class="flex space-x-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="type" value="multiple_choice" class="form-radio text-indigo-600" checked>
                        <span class="ml-2 text-gray-700">Pilihan Ganda</span>
                    </label>
                </div>
            </div>

            <div id="options-section">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Opsi Jawaban</h3>
                <div id="options-container" class="space-y-4">
                </div>
                <button type="button" onclick="addOption()" class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-300 transition duration-300">
                    + Tambah Opsi Jawaban
                </button>
            </div>
        </div>

        <div class="mt-8 flex items-center space-x-4">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg transform hover:scale-105">
                Simpan Pertanyaan
            </button>
            <a href="{{ route('surveys.questions.index', $survey->id) }}" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg text-lg font-medium hover:bg-gray-400 transition duration-300 shadow-lg transform hover:scale-105">
                Kembali
            </a>
        </div>
    </form>
</div>

<script>
    const optionsSection = document.getElementById('options-section');
    const optionsContainer = document.getElementById('options-container');

    // Fungsi untuk menampilkan/menyembunyikan bagian opsi berdasarkan tipe pertanyaan
    function toggleOptionsSection() {
        const questionType = document.querySelector('input[name="type"]:checked').value;
        if (questionType === 'multiple_choice') {
            optionsSection.style.display = 'block';
        } else {
            optionsSection.style.display = 'none';
        }
    }

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', toggleOptionsSection);

    // Jalankan saat tipe pertanyaan diubah
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', toggleOptionsSection);
    });

    function addOption() {
        const index = optionsContainer.children.length;
        const optionDiv = document.createElement('div');
        optionDiv.classList.add('flex', 'items-center', 'space-x-2');
        optionDiv.innerHTML = `
                <input type="text" name="options[${index}][option_body]" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" placeholder="Teks Opsi Jawaban" required>
                <input type="number" name="options[${index}][option_score]" class="w-20 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" placeholder="Skor">
                <button type="button" onclick="this.parentNode.remove()" class="text-red-500 hover:text-red-700 transition duration-300 text-xl font-bold leading-none">&times;</button>
            `;
        optionsContainer.appendChild(optionDiv);
    }
</script>
@endsection