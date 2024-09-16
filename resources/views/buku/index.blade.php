<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">
                    <!-- Tambahkan margin bawah untuk memisahkan tombol dari tabel -->
                    <a href="{{ route('buku.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Buku</a>

                    @if ($message = Session::get('success'))
                        <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">{{ $message }}</div>
                    @endif

                    <!-- Tambahkan link ke CSS DataTables CDN -->
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

                    <table id="books-table" class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Cover</th>
                                <th class="py-2 px-4 border-b">ID Buku</th>
                                <th class="py-2 px-4 border-b">Nama Buku</th>
                                <th class="py-2 px-4 border-b">Pengarang</th>
                                <th class="py-2 px-4 border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buku as $buku)
                                <tr>
                                    <td class="py-2 px-4 border-b">
                                        @if ($buku->cover_image)
                                            <img src="{{ asset('images/'.$buku->cover_image) }}" alt="Cover" width="50">
                                        @else
                                            <span>Tidak ada cover</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $buku->id_buku }}</td>
                                    <td class="py-2 px-4 border-b">{{ $buku->nama_buku }}</td>
                                    <td class="py-2 px-4 border-b">{{ $buku->pengarang }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('buku.edit', $buku->id_buku) }}" class="bg-blue-500 text-white px-4 py-2 rounded">Edit</a>
                                        <form action="{{ route('buku.destroy', $buku->id_buku) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded" onclick="return confirm('Apakah Anda yakin?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Tambahkan script DataTables CDN -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#books-table').DataTable();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
