<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['pelanggan_id', 'periode', 'status', 'tanggal_bayar', 'transaksi_sn', 'metode'];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    // Relasi ke Pemakaian berdasarkan pelanggan & periode
    public function pemakaian()
    {
        return $this->hasOne(Pemakaian::class, 'pelanggan_id', 'pelanggan_id');
    }

    // Relasi ke Tagihan berdasarkan pelanggan & periode
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'pelanggan_id', 'pelanggan_id');
    }
}
