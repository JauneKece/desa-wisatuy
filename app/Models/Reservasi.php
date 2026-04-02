<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasi';
    
    protected $fillable = [
        'pelanggan_id',
        'paket_wisata_id',
        'penginapan_id',
        'tanggal_reservasi',
        'tanggal_kunjungan',
        'jumlah_peserta',
        'total_harga',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'tanggal_kunjungan' => 'date',
    ];

    /**
     * Get the pelanggan associated with the reservasi.
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Get the paket wisata associated with the reservasi.
     */
    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class);
    }

    /**
     * Get the penginapan associated with the reservasi.
     */
    public function penginapan()
    {
        return $this->belongsTo(Penginapan::class);
    }
}
