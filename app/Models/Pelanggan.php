<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_plggn',
        'alamat_plggn',
        'no_hp',
    ];

    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(\App\Models\Pembayaran::class);
    }
}
