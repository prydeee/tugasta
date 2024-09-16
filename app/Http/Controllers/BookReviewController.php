<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Review;
use Illuminate\Http\Request;

class BookReviewController extends Controller
{
    public function index()
    {
        $books = Buku::withCount('reviews')
            ->get()
            ->map(function($book) {
                $genre_distribution = $this->calculateGenreDistribution($book->id_buku);

                // Ambil review terakhir
                $latest_review = Review::where('id_buku', $book->id_buku)
                    ->latest('created_at')
                    ->value('review_buku'); // Ganti dengan kolom yang sesuai untuk review

                // Gunakan URL gambar placeholder dari Lorem Picsum
                $cover_image = $book->cover_image ? asset('images/' . $book->cover_image) : 'https://picsum.photos/100/150?random=' . $book->id_buku;

                return (object) [
                    'id_buku' => $book->id_buku,
                    'nama_buku' => $book->nama_buku,
                    'review_count' => $book->reviews_count,
                    'genre_distribution' => $genre_distribution,
                    'latest_review' => $latest_review,
                    'sampul_buku' => $cover_image
                ];
            });

        return view('book-reviews', compact('books'));
    }

    private function calculateGenreDistribution($bookId)
    {
        $reviews = Review::where('id_buku', $bookId)->get();
        $genres = [];

        foreach ($reviews as $review) {
            $genre = trim(str_replace('Genre dari review ini adalah', '', $review->hasil_genre));
            if (isset($genres[$genre])) {
                $genres[$genre]++;
            } else {
                $genres[$genre] = 1;
            }
        }

        $totalReviews = count($reviews);
        foreach ($genres as $key => $count) {
            $genres[$key] = round(($count / $totalReviews) * 100, 2);
        }

        return $genres;
    }
}
