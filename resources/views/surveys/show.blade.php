@extends('layouts.admin')

@section('content')
{{-- Inisialisasi Alpine.js untuk mengelola state drag-and-drop dan akordeon --}}
<div class="p-6 bg-white rounded-xl shadow-md"
    x-data="questionManager({{ $survey->questions->pluck('id') }})">

    {{-- DIUBAH: Header Halaman Premium dengan Breadcrumbs --}}
    <div class="mb-8 bg-white rounded-xl p-4 md:p-6 border-l-4 border-purple-500 shadow">
        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
            <div>
                <!-- Breadcrumbs -->
                <nav class="text-sm mb-2 font-medium text-gray-500" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('superadmin.dashboard') }}" class="hover:text-purple-600">Dashboard</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('surveys.index') }}" class="hover:text-purple-600">Manajemen Survei</a>
                            <svg class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569 9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-700">Kelola Pertanyaan</span>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center gap-4 mt-2">
                    <div class="flex-shrink-0 bg-purple-500 text-white p-3 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $survey->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">Atur, urutkan, dan kelola semua pertanyaan untuk survei ini.</p>
                    </div>
                </div>
            </div>
            <div class="mt-4 md:mt-0 flex flex-col md:flex-row items-stretch md:items-center gap-3 self-start md:self-end">
                <a href="{{ route('surveys.index') }}" class="bg-white text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-100 transition flex items-center justify-center space-x-2 border border-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Kembali</span>
                </a>
                <button x-show="isOrderChanged" x-transition @click="saveOrder('{{ route('surveys.questions.reorder', $survey) }}')"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-600 transition shadow-md flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span>Simpan Urutan</span>
                </button>
                <a href="{{ route('surveys.questions.create', $survey) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition shadow-md flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    <span>Tambah Pertanyaan</span>
                </a>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    <div x-cloak x-show="notification.show" x-transition class="mb-4">
        <div class="p-4 rounded-lg text-sm font-semibold" :class="notification.success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" x-text="notification.message"></div>
    </div>

    {{-- Manajemen Pertanyaan (Desain Akordeon) --}}
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Pertanyaan</h2>
            <span class="text-sm text-gray-500 font-medium">Total: {{ $survey->questions->count() }} Pertanyaan</span>
        </div>

        <div x-ref="sortableContainer" class="space-y-3">
            @forelse ($survey->questions as $question)
            <div data-id="{{ $question->id }}" class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-lg hover:border-indigo-300 transition-all duration-300 group">
                {{-- Header Akordeon (Bisa di-klik dan di-drag) --}}
                <div @click="openAccordion = (openAccordion === {{ $question->id }} ? null : {{ $question->id }})" class="flex items-center p-4 cursor-pointer">
                    <div class="cursor-grab text-gray-400 group-hover:text-gray-600 mr-3" @mousedown.stop>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $loop->iteration }}. {{ $question->question_body }}</p>
                    </div>
                    <span class="text-xs font-medium px-2 py-0.5 rounded-full ml-4 flex-shrink-0 {{ $question->type === 'multiple_choice' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $question->type === 'multiple_choice' ? 'Pilihan Ganda' : 'Isian Teks' }}
                    </span>
                    <div class="flex items-center space-x-3 flex-shrink-0 ml-4">
                        <a href="{{ route('surveys.questions.edit', [$survey, $question]) }}" class="text-indigo-600 hover:text-indigo-800 opacity-0 group-hover:opacity-100 transition-opacity" title="Edit Pertanyaan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <button type="button" @click.stop="openDeleteModal = true; deleteUrl = '{{ route('surveys.questions.destroy', [$survey, $question]) }}'; deleteItemName = '{{ addslashes($question->question_body) }}'" class="text-red-600 hover:text-red-800 opacity-0 group-hover:opacity-100 transition-opacity" title="Hapus Pertanyaan">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                    <div class="ml-2 text-gray-400 transition-transform duration-300" :class="{'rotate-90': openAccordion === {{ $question->id }} }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
                {{-- Body Akordeon (muncul saat di-klik) --}}
                <div x-show="openAccordion === {{ $question->id }}" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="px-4 pb-4 pl-12 pt-2">
                    @if($question->type === 'multiple_choice' && $question->options->count() > 0)
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-600 text-sm mb-2">Opsi Jawaban:</h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach($question->options as $option)
                            <li class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ $option->option_body }} (Skor: <span class="font-semibold text-indigo-700">{{ $option->option_score }}</span>)</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($question->type === 'multiple_choice')
                    <p class="text-sm text-gray-500 pt-2 border-t">Belum ada opsi jawaban untuk pertanyaan ini.</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 px-4 border-2 border-dashed rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="mt-4 font-semibold text-gray-600">Belum ada pertanyaan</p>
                <p class="text-gray-500 text-sm mt-1">Klik tombol "Tambah Pertanyaan" untuk memulai.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- Sertakan library SortableJS --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<style>
    /* Styling untuk item yang sedang di-drag */
    .sortable-ghost {
        background: #f0f9ff;
        border-style: dashed;
        border-color: #0ea5e9;
        opacity: 0.7;
    }
</style>
<script>
    function questionManager(initialOrder) {
        return {
            openAccordion: null,
            initialOrder: [...initialOrder],
            currentOrder: [...initialOrder],
            isOrderChanged: false,
            notification: {
                show: false,
                message: '',
                success: false
            },
            init() {
                const sortable = new Sortable(this.$refs.sortableContainer, {
                    ghostClass: 'sortable-ghost',
                    animation: 150,
                    handle: '.cursor-grab',
                    onUpdate: () => {
                        this.currentOrder = Array.from(sortable.el.children).map(el => el.dataset.id);
                        this.isOrderChanged = JSON.stringify(this.initialOrder) !== JSON.stringify(this.currentOrder);
                    }
                });
            },
            saveOrder(url) {
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order: this.currentOrder
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            this.showNotification(data.message, true);
                            this.initialOrder = [...this.currentOrder];
                            this.isOrderChanged = false;
                        } else {
                            this.showNotification('Gagal menyimpan urutan.', false);
                        }
                    })
                    .catch(() => this.showNotification('Terjadi error saat menghubungi server.', false));
            },
            showNotification(message, success) {
                this.notification.message = message;
                this.notification.success = success;
                this.notification.show = true;
                setTimeout(() => this.notification.show = false, 3000);
            }
        }
    }
</script>
@endpush