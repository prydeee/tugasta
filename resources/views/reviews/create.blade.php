{{-- resources/views/reviews/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Review Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Tambah Review Buku</h1>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <!-- Pilih Buku -->
                        <div class="mb-4">
                            <label for="id_buku" class="block text-gray-700">Pilih Buku:</label>
                            <select name="id_buku" id="id_buku" class="border border-gray-300 p-2 w-full" required>
                                @foreach ($bukus as $buku)
                                    <option value="{{ $buku->id_buku }}">{{ $buku->nama_buku }}</option>
                                @endforeach
                            </select>
                            @error('id_buku')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Review Buku -->
                        <div class="mb-4">
                            <label for="review_buku" class="block text-gray-700">Review Buku:</label>
                            <textarea name="review_buku" id="review_buku" rows="4" class="border border-gray-300 p-2 w-full" required></textarea>
                            @error('review_buku')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tombol Rekam Suara dan Tambah Review -->
                        <button type="button" id="start-recording" class="bg-blue-500 text-white px-4 py-2 rounded">Mulai Rekam</button>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startRecordingButton = document.getElementById('start-recording');
            let isRecording = false;
            let recognition;

            if (!('webkitSpeechRecognition' in window)) {
                alert('Browser Anda tidak mendukung fitur Speech-to-Text.');
                return;
            }

            startRecordingButton.addEventListener('click', () => {
                if (isRecording) {
                    recognition.stop();
                    startRecordingButton.textContent = 'Mulai Rekam';
                    isRecording = false;
                } else {
                    recognition = new webkitSpeechRecognition();
                    recognition.lang = 'id-ID';
                    recognition.interimResults = false;
                    recognition.continuous = false;

                    recognition.onresult = (event) => {
                        document.getElementById('review_buku').value = event.results[0][0].transcript;
                    };

                    recognition.onerror = (event) => {
                        console.error('Speech recognition error:', event.error);
                    };

                    recognition.start();
                    startRecordingButton.textContent = 'Stop Rekam';
                    isRecording = true;
                }
            });
        });
    </script>
</x-app-layout>
