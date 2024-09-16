<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Get the count of reviews by the logged-in user
        $reviewCount = Review::where('created_by', $userId)->count();
        

        // Get the latest review by the logged-in user
        $latestReview = Review::where('created_by', $userId)
            ->latest('created_at')
            ->first();

        return view('dashboard', compact('reviewCount', 'latestReview'));
    }
}
