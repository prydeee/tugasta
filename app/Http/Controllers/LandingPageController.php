<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Buku;
use App\Models\User; // Import User model

class LandingPageController extends Controller
{
    public function index()
    {
        // Get all books
        $books = Buku::with('reviews.user')->get(); // Eager load reviews and user

        // Format data for each book
        $bookData = $books->map(function($book) {
            // Get the total review count
            $reviewCount = $book->reviews->count();

            // Calculate genre distribution
            $genreDistribution = $this->calculateGenreDistribution($book->id_buku);

            // Get the latest review
            $latestReview = $book->reviews->sortByDesc('created_at')->first();
            $cover_image = $book->cover_image ? asset('images/' . $book->cover_image) : 'https://picsum.photos/100/150?random=' . $book->id_buku;

            return [
                'id_buku' => $book->id_buku,
                'nama_buku' => $book->nama_buku,
                'pengarang' => $book->pengarang,
                'review_count' => $reviewCount,
                'genre_distribution' => $genreDistribution,
                'sampul_buku' => $cover_image,
                'latest_review' => $latestReview ? [
                    'text' => $latestReview->review_buku,
                    'user_name' => $latestReview->user ? $latestReview->user->name : 'Unknown'
                ] : null,
            ];
        });

        return view('welcome', ['bookData' => $bookData]);
    }

    private function calculateGenreDistribution($bookId)
    {
        $reviews = Review::where('id_buku', $bookId)->with('user')->get(); // Eager load user
        $genres = [];

        foreach ($reviews as $review) {
            // Remove the prefix and trim the genre
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

    public function getReviews($bookId)
    {
        $reviews = Review::where('id_buku', $bookId)->with('user')->get(); // Eager load user
        return response()->json(['reviews' => $reviews]);
    }
}
