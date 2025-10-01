@csrf

{{-- Inisialisasi Alpine.js untuk mengelola state form secara dinamis --}}
<div x-data="{
    options: {{ json_encode(old('options', isset($question) ? $question->options->map->only(['id', 'option_body', 'option_score']) : [['id' => null, 'option_body' => '', 'option_score' => 0], ['id' => null, 'option_body' => '', 'option_score' => 0]])) }}
}" class="space-y-8">

    {{-- Input tersembunyi karena tipe pertanyaan sekarang hanya satu --}}
    <input type="hidden" name="type" value="multiple_choice">

    {{-- KARTU 1: DETAIL PERTANYAAN --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pertanyaan</h3>
        <div>
            <label for="question_body" class="block text-sm font-medium text-gray-700 mb-1">Tulis Pertanyaan Anda:</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                </div>
                <textarea id="question_body" name="question_body" rows="3" class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200" required placeholder="Contoh: Seberapa puaskah Anda dengan layanan kami?">{{ old('question_body', $question->question_body ?? '') }}</textarea>
            </div>
            @error('question_body') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- KARTU 2: OPSI JAWABAN (DESAIN BARU) --}}
    <div class="p-6 bg-gray-50 rounded-lg border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Opsi Jawaban</h3>
        <div class="space-y-4">
            <template x-for="(option, index) in options" :key="index">
                {{-- DIUBAH: Desain baris opsi jawaban yang unik --}}
                <div class="flex items-center space-x-3 bg-indigo-50/60 p-3 rounded-r-lg border-l-4 border-indigo-300 transition-shadow hover:shadow-md">
                    <div class="cursor-grab text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16" />
                        </svg>
                    </div>
                    <input type="hidden" x-bind:name="`options[${index}][id]`" x-model="option.id">

                    {{-- Input Teks Opsi dengan gaya garis bawah --}}
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="text" x-bind:name="`options[${index}][option_body]`" x-model="option.option_body" class="w-full pl-10 bg-transparent border-0 border-b-2 border-gray-300/50 focus:border-indigo-400 focus:ring-0 transition" placeholder="Teks Opsi Jawaban" required>
                    </div>

                    {{-- Input Skor dengan gaya garis bawah --}}
                    <div class="relative w-32">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345h5.584a.563.563 0 01.321.988l-4.204 3.055a.563.563 0 00-.182.635l2.125 5.11a.563.563 0 01-.84.622l-4.204-3.055a.563.563 0 00-.652 0l-4.204 3.055a.563.563 0 01-.84-.622l2.125-5.111a.563.563 0 00-.182-.635l-4.204-3.055a.563.563 0 01.321-.988h5.584a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg>
                        </div>
                        <input type="number" x-bind:name="`options[${index}][option_score]`" x-model="option.option_score" class="w-full pl-10 text-center bg-transparent border-0 border-b-2 border-gray-300/50 focus:border-indigo-400 focus:ring-0 transition" placeholder="Skor" required>
                    </div>

                    <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2" class="text-gray-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
        @error('options') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
        @error('options.*.option_body') <span class="text-red-500 text-xs mt-2">Teks opsi tidak boleh kosong.</span> @enderror
        @error('options.*.option_score') <span class="text-red-500 text-xs mt-2">Skor opsi tidak boleh kosong.</span> @enderror
        <button type="button" @click="options.push({id: null, option_body: '', option_score: 0 })" class="mt-4 bg-indigo-100 text-indigo-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-200 transition duration-300 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Opsi
        </button>
    </div>
</div>

{{-- Separator & Tombol Aksi --}}
<div class="relative my-8">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-200"></div>
    </div>
    <div class="relative flex justify-center">
        <span class="bg-white px-4 text-gray-300">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
        </span>
    </div>
</div>

<div class="flex items-center justify-end space-x-4">
    <a href="{{ route('surveys.show', $survey) }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition duration-300">
        Batal
    </a>
    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition duration-300 shadow-lg flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ isset($question) ? 'Perbarui Pertanyaan' : 'Simpan Pertanyaan' }}</span>
    </button>
</div>