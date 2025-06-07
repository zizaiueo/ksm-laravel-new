<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'periode',
        'tarif_per_m3',
        'total_pemakaian',
        'jumlah_tagihan',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
        public function pemakaian()
    {
        return $this->belongsTo(Pemakaian::class, 'pelanggan_id', 'pelanggan_id');
    }

public function pembayaran()
{
    return $this->hasOne(Pembayaran::class, 'pelanggan_id', 'pelanggan_id')
        ->whereColumn('pembayarans.periode', 'periode');
}




}
