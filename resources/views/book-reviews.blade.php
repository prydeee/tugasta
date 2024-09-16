<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto px-4">
            <div class="grid grid-cols-1 gap-6"> <!-- Changed to 1 column layout -->
                @foreach($books as $book)
                    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col">
                        <div class="flex items-start mb-4">
                            <!-- Judul Buku dan Jumlah Review -->
                            <div class="flex flex-col flex-grow">
                                <h3 class="text-xl font-semibold mb-2">{{ $book->nama_buku }}</h3>
                                <p class="mb-4">Jumlah Review: {{ $book->review_count }}</p>

                                <!-- Gambar Sampul Buku -->
                                <img src="{{ $book->sampul_buku }}" alt="Cover" width="100">

                                <!-- Review Terakhir -->
                                <p class="mt-4 text-sm">Review Terakhir: {{ $book->latest_review ?? 'Belum ada review.' }}</p>
                            </div>

                            <!-- Pie Chart -->
                            <div class="flex-shrink-0 ml-4">
                                <canvas id="pieChart-{{ $book->id_buku }}" style="width: 150px; height: 150px;"></canvas>
                            </div>
                        </div>

                        <!-- Script untuk Pie Chart -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('pieChart-{{ $book->id_buku }}').getContext('2d');
                                const genreDistribution = @json($book->genre_distribution);

                                new Chart(ctx, {
                                    type: 'pie',
                                    data: {
                                        labels: Object.keys(genreDistribution),
                                        datasets: [{
                                            data: Object.values(genreDistribution),
                                            backgroundColor: [
                                                '#FF6384', '#36A2EB', '#FFCE56', 
                                                '#4BC0C0', '#9966FF', '#FF9F40'
                                            ],
                                        }],
                                    },
                                    options: {
                                        responsive: false,
                                        maintainAspectRatio: false,
                                    }
                                });
                            });
                        </script>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
