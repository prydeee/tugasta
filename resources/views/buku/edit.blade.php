<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">
                    <form action="{{ route('buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="id_buku" class="block text-gray-700">{{ __('ID Buku:') }}</label>
                            <input type="text" name="id_buku" id="id_buku" value="{{ $buku->id_buku }}" class="border border-gray-300 p-2 w-full" required>
                            @error('id_buku')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="nama_buku" class="block text-gray-700">{{ __('Nama Buku:') }}</label>
                            <input type="text" name="nama_buku" id="nama_buku" value="{{ $buku->nama_buku }}" class="border border-gray-300 p-2 w-full" required>
                            @error('nama_buku')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="pengarang" class="block text-gray-700">{{ __('Pengarang:') }}</label>
                            <input type="text" name="pengarang" id="pengarang" value="{{ $buku->pengarang }}" class="border border-gray-300 p-2 w-full" required>
                            @error('pengarang')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="cover_image" class="block text-gray-700">{{ __('Cover Buku:') }}</label>
                            <input type="file" name="cover_image" id="cover_image" class="border border-gray-300 p-2 w-full">
                            @error('cover_image')
                                <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
