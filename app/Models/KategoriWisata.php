<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWisata extends Model
{
    protected $table = 'kategori_wisata';
    
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
    ];

    /**
     * Get the objek wisata associated with the kategori wisata.
     */
    public function objekWisata()
    {
        return $this->hasMany(ObjekWisata::class);
    }
}
