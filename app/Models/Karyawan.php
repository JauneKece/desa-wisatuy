<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    
    protected $fillable = [
        'user_id',
        'nomor_identitas',
        'departemen',
        'posisi',
        'gaji',
        'foto',
    ];

    /**
     * Get the user associated with the karyawan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
