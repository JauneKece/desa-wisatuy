<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'reservasi_id',
        'amount',
        'method',
        'transaction_id',
        'proof_path',
        'status',
        'paid_at',
        'metadata',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'metadata' => 'array',
        'amount' => 'decimal:2',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }
}
