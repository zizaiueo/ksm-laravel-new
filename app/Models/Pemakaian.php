<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $fillable = [
        'pelanggan_id',
        'periode',
        'meter_awal',
        'meter_akhir',
        'total_pemakaian',
    ];
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pelanggan_id', 'pelanggan_id');
    }
}


