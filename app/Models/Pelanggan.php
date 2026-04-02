<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    
    protected $fillable = [
        'user_id',
        'nomor_identitas',
        'jenis_identitas',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
    ];

    /**
     * Get the user associated with the pelanggan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the reservasi associated with the pelanggan.
     */
    public function reservasi()
    {
        return $this->hasMany(Reservasi::class);
    }
}
