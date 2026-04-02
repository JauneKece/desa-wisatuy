<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    protected $table = 'penginapan';
    
    protected $fillable = [
        'nama_penginapan',
        'deskripsi',
        'alamat',
        'telepon',
        'harga_penginapan',
        'jumlah_kamar',
        'tipe_kamar',
        'foto',
        'rating',
    ];

    /**
     * Get the reservasi associated with the penginapan.
     */
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
}
