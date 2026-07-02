<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use App\Models\Menu;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RingkasanWarmindo extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung total uang masuk dari semua transaksi kasir
        $totalOmzet = Transaksi::sum('total_bayar');
        // Hitung total nota kasir masuk
        $totalTransaksi = Transaksi::count();
        // Cari menu mi/minuman yang stoknya menipis di bawah 10 porsi
        $stokKritis = Menu::where('stok', '<=', 10)->count();

        return [
            Stat::make('Total Omzet Warmindo', 'Rp ' . number_format($totalOmzet, 0, ',', '.'))
                ->description('Total akumulasi pendapatan kasir')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->color('success'),

            Stat::make('Pesanan Selesai', $totalTransaksi . ' Transaksi')
                ->description('Jumlah nota lunas tercetak')
                ->descriptionIcon('heroicon-m-shopping-cart', IconPosition::Before)
                ->color('info'),

            Stat::make('Peringatan Stok Gudang', $stokKritis . ' Item')
                ->description($stokKritis > 0 ? 'Ada item kritis di bawah 10 porsi!' : 'Semua aman di atas 10 porsi')
                ->descriptionIcon('heroicon-m-exclamation-triangle', IconPosition::Before)
                ->color($stokKritis > 0 ? 'danger' : 'success'),
        ];
    }
}