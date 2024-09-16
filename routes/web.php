<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and will be assigned to the "web" middleware group.
|
*/

Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');
Route::get('/get-reviews/{bookId}', [LandingPageController::class, 'getReviews']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/read', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/reviews/read/{id}', [ReviewController::class, 'show']);
    Route::get('/admin/reviews', [ReviewController::class, 'indexAdmin'])->name('admin.reviews');
    Route::delete('/admin/reviews/{id_review}', [ReviewController::class, 'destroyAdmin'])->name('admin.reviews.delete');
    

    Route::get('/book-reviews', [BookReviewController::class, 'index'])->name('book.reviews');

});
Route::resource('buku', BukuController::class);

require __DIR__.'/auth.php';
