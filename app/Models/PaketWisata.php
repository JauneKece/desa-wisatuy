<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $table = 'paket_wisata';
    
    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'harga_paket',
        'durasi_hari',
        'durasi_jam',
        'kuota_peserta',
        'itinerary',
        'foto',
    ];

    /**
     * Get the reservasi associated with the paket wisata.
     */
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
}
