<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 light:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white light:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 light:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Dashboard</h3>

                    <!-- Display total reviews by the user -->
                    <div class="mb-6">
                        <h4 class="text-md font-medium">Jumlah Review Anda:</h4>
                        <p class="text-lg">{{ $reviewCount }}</p>
                    </div>

                    <!-- Display latest review -->
                    <div>
                        <h4 class="text-md font-medium">Review Terbaru Anda:</h4>
                        @if($latestReview)
                            <p class="text-sm">{{ Str::limit($latestReview->review_buku, 100) }}</p>
                        @else
                            <p class="text-sm">Belum ada review terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
