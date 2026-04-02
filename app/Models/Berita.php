<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = 'berita';
    
    protected $fillable = [
        'kategori_berita_id',
        'user_id',
        'judul',
        'konten',
        'foto',
        'status',
    ];

    /**
     * Get the kategori berita associated with the berita.
     */
    public function kategoriBerita()
    {
        return $this->belongsTo(KategoriBerita::class);
    }

    /**
     * Get the user associated with the berita.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
