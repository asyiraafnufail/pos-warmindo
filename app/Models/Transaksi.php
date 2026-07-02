<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'no_meja', 'total_bayar', 'metode_bayar'];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    // Relasi: Satu transaksi memiliki banyak detail item pesanan
    public function detailTransaksis(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}