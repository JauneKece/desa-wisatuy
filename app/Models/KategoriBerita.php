<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBerita extends Model
{
    protected $table = 'kategori_berita';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Get the berita associated with the kategori berita.
     */
    public function berita()
    {
        return $this->hasMany(Berita::class);
    }
}
