<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjekWisata extends Model
{
    protected $table = 'objek_wisata';
    
    protected $fillable = [
        'kategori_wisata_id',
        'nama_objek',
        'deskripsi',
        'lokasi',
        'harga_tiket',
        'jam_buka',
        'jam_tutup',
        'foto',
        'rating',
    ];

    /**
     * Get the kategori wisata associated with the objek wisata.
     */
    public function kategoriWisata()
    {
        return $this->belongsTo(KategoriWisata::class);
    }
}
