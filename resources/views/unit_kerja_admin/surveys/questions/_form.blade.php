@csrf

<div x-data="{
    options: {{ json_encode(old('options', isset($question) ? $question->options->map->only(['id', 'option_body', 'option_score']) : [['id' => null, 'option_body' => '', 'option_score' => 0], ['id' => null, 'option_body' => '', 'option_score' => 0]])) }}
}" class="space-y-8">

    <input type="hidden" name="type" value="multiple_choice">

    {{-- KARTU 1: DETAIL PERTANYAAN --}}
    <div class="p-6 bg-gradient-to-br from-white to-gray-50 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <span class="bg-teal-100 text-teal-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
            </span>
            Detail Pertanyaan
        </h3>
        <div>
            <label for="question_body" class="block text-sm font-medium text-gray-700 mb-1">Tulis Pertanyaan Anda:</label>
            <textarea id="question_body" name="question_body" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-teal-500 focus:ring-2 focus:ring-teal-200" required placeholder="Contoh: Seberapa puaskah Anda dengan layanan kami?">{{ old('question_body', $question->question_body ?? '') }}</textarea>
            @error('question_body') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- KARTU 2: OPSI JAWABAN (DESAIN BARU) --}}
    <div class="p-6 bg-gradient-to-br from-white to-gray-50 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <span class="bg-teal-100 text-teal-600 p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            Opsi Jawaban
        </h3>
        <div class="space-y-4">
            <template x-for="(option, index) in options" :key="index">
                <div class="flex items-center space-x-3 bg-white p-3 rounded-lg border border-gray-200 transition-shadow hover:shadow-md">
                    <div class="cursor-grab text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16" />
                        </svg></div>
                    <input type="hidden" x-bind:name="`options[${index}][id]`" x-model="option.id">
                    <div class="relative flex-grow"><input type="text" x-bind:name="`options[${index}][option_body]`" x-model="option.option_body" class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Teks Opsi Jawaban" required></div>
                    <div class="relative w-32">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345h5.584a.563.563 0 01.321.988l-4.204 3.055a.563.563 0 00-.182.635l2.125 5.11a.563.563 0 01-.84.622l-4.204-3.055a.563.563 0 00-.652 0l-4.204 3.055a.563.563 0 01-.84-.622l2.125-5.111a.563.563 0 00-.182-.635l-4.204-3.055a.563.563 0 01.321-.988h5.584a.563.563 0 00.475-.345L11.48 3.5z" />
                            </svg></div>
                        <input type="number" x-bind:name="`options[${index}][option_score]`" x-model="option.option_score" class="w-full pl-10 text-center rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm" placeholder="Skor" required>
                    </div>
                    <button type="button" @click="options.splice(index, 1)" x-show="options.length > 2" class="text-gray-400 hover:text-red-600 transition p-1 rounded-full hover:bg-red-50"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg></button>
                </div>
            </template>
        </div>
        @error('options') <span class="text-red-500 text-xs mt-2">{{ $message }}</span> @enderror
        @error('options.*.option_body') <span class="text-red-500 text-xs mt-2">Teks opsi tidak boleh kosong.</span> @enderror
        @error('options.*.option_score') <span class="text-red-500 text-xs mt-2">Skor opsi tidak boleh kosong.</span> @enderror
        <button type="button" @click="options.push({id: null, option_body: '', option_score: 0 })" class="mt-4 bg-teal-100 text-teal-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-200 transition duration-300 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
            Tambah Opsi
        </button>
    </div>
</div>