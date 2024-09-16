<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'master_buku';
    protected $primaryKey = 'id_buku';
    protected $fillable = ['nama_buku', 'pengarang', 'cover_image'];

    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_buku', 'id_buku');
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    public function getGenreDistributionAttribute()
    {
        // Mengambil genre dari review dan menghitung distribusinya
        $genres = $this->reviews()->pluck('hasil_genre');
        $genreCounts = $genres->flatMap(function ($genre) {
            return explode(', ', Str::after($genre, 'Genre dari review ini adalah '));
        })->countBy()->toArray();

        return $genreCounts;
    }
}
