<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Review Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">Daftar Semua Review</h1>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Buku</th>
                                <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Nama Pengguna</th>
                                <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Review</th>
                                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Genre</th>
                                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Tanggal</th>
                                <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2">{{ $review->nama_buku }}</td>
                                    <td class="border px-4 py-2">{{ $review->user->name }}</td>
                                    <td class="border px-4 py-2">{{ Str::limit($review->review_buku, 100) }}</td>
                                    <td class="border px-4 py-2">{{ Str::after($review->hasil_genre, 'adalah ') }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y') }}</td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('admin.reviews.delete', $review->id_review) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($reviews->isEmpty())
                        <p class="mt-4 text-gray-500">Tidak ada review yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
