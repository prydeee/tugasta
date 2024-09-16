<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Review Buku Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Daftar Review Buku</h1>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Buku</th>
                                <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Review</th>
                                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Genre</th>
                                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr class="cursor-pointer hover:bg-gray-100" onclick="showDetail({{ $review->id_review }})">
                                    <!-- Nama Buku -->
                                    <td class="border px-4 py-2">{{ $review->nama_buku }}</td>
                                    
                                    <!-- Potongan Review -->
                                    <td class="border px-4 py-2">{{ Str::limit($review->review_buku, 100) }}</td>
                                    
                                    <!-- Genre tanpa 'Genre dari review ini adalah ' -->
                                    <td class="border px-4 py-2">{{ Str::after($review->hasil_genre, 'adalah ') }}</td>
                                    
                                    <!-- Format Tanggal -->
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($reviews->isEmpty())
                        <p class="mt-4 text-gray-500">Belum ada review yang Anda buat.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Popup untuk detail review -->
    <div id="reviewDetailModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                <h2 id="modalNamaBuku" class="text-2xl font-bold mb-4"></h2>
                <p id="modalReviewBuku" class="mb-4"></p>
                <button onclick="closeModal()" class="bg-blue-500 text-white px-4 py-2 rounded">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showDetail(reviewId) {
            fetch(`/reviews/read/${reviewId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalNamaBuku').textContent = data.nama_buku;
                    document.getElementById('modalReviewBuku').textContent = data.review_buku;
                    document.getElementById('reviewDetailModal').classList.remove('hidden');
                })
                .catch(error => console.error('Error fetching review:', error));
        }

        function closeModal() {
            document.getElementById('reviewDetailModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
