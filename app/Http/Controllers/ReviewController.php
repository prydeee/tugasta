<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Services\OpenAIService;

class ReviewController extends Controller
{
    protected $openAI;

    public function __construct(OpenAIService $openAI)
    {
        $this->openAI = $openAI;
    }

    public function create()
    {
        $bukus = Buku::all();
        return view('reviews.create', compact('bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:master_buku,id_buku',
            'review_buku' => 'required',
        ]);

        // Menggunakan OpenAI untuk menentukan genre
        $hasil_genre = $this->openAI->generateGenre($request->input('review_buku'));

        Review::create([
            'id_buku' => $request->input('id_buku'),
            'review_buku' => $request->input('review_buku'),
            'hasil_genre' => $hasil_genre,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('reviews.create')->with('success', 'Review berhasil ditambahkan!');
    }

    public function index()
    {
        $reviews = Review::join('master_buku', 'reviews.id_buku', '=', 'master_buku.id_buku')
                         ->select('reviews.*', 'master_buku.nama_buku')
                         ->where('reviews.created_by', auth()->user()->id)
                         ->get();
    
        return view('reviews.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::join('master_buku', 'reviews.id_buku', '=', 'master_buku.id_buku')
                        ->select('reviews.*', 'master_buku.nama_buku')
                        ->where('reviews.id_review', $id)
                        ->first();

        return response()->json($review);
    }

    public function indexAdmin()
    {
        // Mengambil semua review beserta user yang membuat review
        $reviews = Review::join('master_buku', 'reviews.id_buku', '=', 'master_buku.id_buku')
        ->select('reviews.*', 'master_buku.nama_buku')
        ->get();
    
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function destroyAdmin($id_review)
    {
        $review = Review::findOrFail($id_review);
        $review->delete();
    
        return redirect()->route('admin.reviews')->with('success', 'Review berhasil dihapus.');
    }
    
    
}
