<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $fillable = ['transaksi_id', 'menu_id', 'jumlah', 'subtotal', 'catatan_custom'];

    /**
     * Otomatis dipicu ketika ada data masuk ke tabel detail_transaksis
     */
    protected static function booted()
    {
        static::created(function ($detailTransaksi) {
            $menu = $detailTransaksi->menu;
            if ($menu) {
                // Kurangi stok menu tersebut berdasarkan jumlah porsi yang dibeli
                $menu->decrement('stok', $detailTransaksi->jumlah);
            }
        });
    }

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}