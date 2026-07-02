<?php

namespace App\Filament\Resources\TransaksiResource\Pages;

use App\Filament\Resources\TransaksiResource;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

class CreateTransaksi extends Page
{
    protected static string $resource = TransaksiResource::class;

    protected static string $view = 'pos.create-transaksi';

    public $cart = [];
    public $no_meja = '';
    public $metode_bayar = 'Tunai';
    public $total_bayar = 0;
    public $search = '';
    public $activeKategori = 'Semua';

    public function mount(): void
    {
        $this->total_bayar = 0;
    }

    public function addToCart($menuId)
    {
        $menu = Menu::find($menuId);
        if (!$menu || $menu->stok <= 0) {
            Notification::make()->title('Stok habis atau menu tidak ditemukan!')->danger()->send();
            return;
        }

        if (isset($this->cart[$menuId])) {
            if ($this->cart[$menuId]['jumlah'] >= $menu->stok) {
                Notification::make()->title('Jumlah porsi melebihi stok tersedia!')->danger()->send();
                return;
            }
            $this->cart[$menuId]['jumlah']++;
            $this->cart[$menuId]['subtotal'] = $this->cart[$menuId]['jumlah'] * $menu->harga;
        } else {
            $this->cart[$menuId] = [
                'menu_id' => $menu->id,
                'nama_menu' => $menu->nama_menu,
                'harga' => $menu->harga,
                'jumlah' => 1,
                'subtotal' => $menu->harga,
                'catatan_custom' => '',
            ];
        }

        $this->hitungTotal();
    }

    public function setKategori($kategori)
    {
        $this->activeKategori = $kategori;
    }

    public function decrementQty($menuId)
    {
        if (isset($this->cart[$menuId])) {
            if ($this->cart[$menuId]['jumlah'] > 1) {
                $this->cart[$menuId]['jumlah']--;
                $this->cart[$menuId]['subtotal'] = $this->cart[$menuId]['jumlah'] * $this->cart[$menuId]['harga'];
            } else {
                unset($this->cart[$menuId]);
            }
            $this->hitungTotal();
        }
    }

    public function removeFromCart($menuId)
    {
        unset($this->cart[$menuId]);
        $this->hitungTotal();
    }

    public function updatedCart($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $menuId = $parts[0];
            $field = $parts[1];

            if ($field === 'jumlah') {
                $menu = Menu::find($menuId);
                $jumlah = intval($value);

                if ($jumlah < 1) {
                    $this->cart[$menuId]['jumlah'] = 1;
                    $jumlah = 1;
                }

                if ($menu && $jumlah > $menu->stok) {
                    Notification::make()->title('Stok tidak mencukupi!')->danger()->send();
                    $this->cart[$menuId]['jumlah'] = $menu->stok;
                    $jumlah = $menu->stok;
                }

                $this->cart[$menuId]['subtotal'] = $jumlah * $this->cart[$menuId]['harga'];
            }
        }
        $this->hitungTotal();
    }

    public function hitungTotal()
    {
        $this->total_bayar = array_sum(array_column($this->cart, 'subtotal'));
    }

    public function simpanTransaksi()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Keranjang belanja masih kosong!')->danger()->send();
            return;
        }

        DB::transaction(function () {
            $transaksi = Transaksi::create([
                'tanggal' => now(),
                'no_meja' => $this->no_meja,
                'total_bayar' => $this->total_bayar,
                'metode_bayar' => $this->metode_bayar,
            ]);

            foreach ($this->cart as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu_id'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['subtotal'],
                    'catatan_custom' => $item['catatan_custom'],
                ]);
            }
    }); 

        Notification::make()->title('Transaksi Berhasil Disimpan!')->success()->send();

        return redirect($this->getResource()::getUrl('index'));
    }

    public function getMenus()
    {
        return Menu::query()
            ->when($this->search, fn($query) => $query->where('nama_menu', 'like', '%'.$this->search.'%'))
            ->when($this->activeKategori && $this->activeKategori !== 'Semua', fn($query) => $query->where('kategori', $this->activeKategori))
            ->get();
    }
}