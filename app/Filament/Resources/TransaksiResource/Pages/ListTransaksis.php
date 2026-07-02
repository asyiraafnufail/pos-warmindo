<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTransaksis extends ListRecords
{
    protected static string $resource = TransaksiResource::class;

    public function getTitle(): string
    {
        return 'Riwayat Transaksi Kasir';
    }

    /**
     * Memunculkan kembali tombol "Tambah Transaksi" di pojok kanan atas tabel
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Tambah Transaksi')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->url(fn (): string => static::getResource()::getUrl('create')),
        ];
    }
}