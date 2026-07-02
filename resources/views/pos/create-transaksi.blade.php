<x-filament-panels::page>
    <style>
        /* POS Layout Grid System */
        .pos-container {
            display: flex;
            flex-direction: column;
            gap: 2rem !important;
        }
        @media (min-width: 992px) {
            .pos-container {
                display: grid !important;
                grid-template-columns: 1.5fr 1fr !important;
                gap: 2rem !important;
                align-items: start !important;
            }
        }

        /* Hover Transitions and Premium UI Effects */
        .menu-card {
            transition: all 0.2s ease-in-out;
            border-radius: 12px !important;
        }
        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.01) !important;
            border-color: #cbd5e1 !important;
        }

        /* Category Filter Buttons Override */
        .category-btn {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 0.5rem 1rem !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            transition: all 0.2s ease-in-out !important;
            cursor: pointer !important;
        }
        .category-btn:hover:not(.active) {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
        }
        .category-btn.active {
            background-color: #0f172a !important;
            color: #ffffff !important;
            border-color: #0f172a !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1) !important;
        }

        /* Premium Add-to-Cart Button */
        .add-to-cart-btn {
            background-color: #ea580c !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important;
            width: 32px !important;
            height: 32px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05) !important;
        }
        .add-to-cart-btn:hover {
            background-color: #c2410c !important;
            transform: scale(1.05);
        }
        .add-to-cart-btn:disabled {
            background-color: #f1f5f9 !important;
            color: #cbd5e1 !important;
            cursor: not-allowed !important;
            transform: none !important;
            box-shadow: none !important;
        }
        .add-to-cart-btn svg {
            color: #ffffff !important;
            stroke: #ffffff !important;
            width: 1rem !important;
            height: 1rem !important;
        }

        /* Quantity Changer Buttons */
        .qty-btn {
            width: 24px !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            border-radius: 6px !important;
            font-weight: bold !important;
            font-size: 0.75rem !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
        }
        .qty-btn:hover {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        /* Remove Cart Item Button */
        .remove-item-btn {
            color: #94a3b8 !important;
            background: none !important;
            border: none !important;
            cursor: pointer !important;
            transition: color 0.15s ease !important;
            padding: 4px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .remove-item-btn:hover {
            color: #ef4444 !important;
        }
        .remove-item-btn svg {
            width: 1rem !important;
            height: 1rem !important;
        }

        /* Custom Scrollbar for Shopping Cart */
        .cart-scroll-container::-webkit-scrollbar {
            width: 4px;
        }
        .cart-scroll-container::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 4px;
        }
        .cart-scroll-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .cart-scroll-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Clean Receipt Style Separator */
        .receipt-divider {
            border-top: 1px dashed #cbd5e1;
            margin: 1rem 0;
        }
    </style>

    <div class="pos-container">
        
        <!-- ================= PANEL KIRI: KATALOG MENU (1.5fr) ================= -->
        <div class="space-y-6">
            
            <!-- SEARCH BAR & LIVE CLOCK (Premium & Minimalist) -->
            <div class="p-5 bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="relative w-full sm:w-80">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input 
                        type="text" 
                        wire:model.live="search" 
                        placeholder="Cari mi instan, minuman, atau toping..." 
                        class="w-full pl-9 pr-4 py-2 rounded-lg text-sm border border-slate-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 bg-slate-50/50 text-slate-800"
                    />
                </div>
                
                <!-- LIVE TIME ENGINE -->
                <div class="text-xs font-semibold px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 text-slate-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Waktu Operasional:</span>
                    <span id="live-clock-digital" class="text-slate-800 font-mono font-bold">--:--:--</span>
                </div>
            </div>

            <!-- TABS FILTER KATEGORI MENU -->
            <div class="flex gap-2 overflow-x-auto pb-1">
                @foreach(['Semua', 'Makanan', 'Minuman', 'Toping'] as $kat)
                    @php
                        $active = $activeKategori === $kat;
                        $label = match($kat) {
                            'Semua' => 'Semua Menu',
                            'Makanan' => 'Makanan',
                            'Minuman' => 'Minuman',
                            'Toping' => 'Toping & Ekstra',
                        };
                    @endphp
                    <button 
                        type="button"
                        wire:click="setKategori('{{ $kat }}')"
                        class="category-btn whitespace-nowrap {{ $active ? 'active' : '' }}"
                    >
                        <span>{{ $label }}</span>
                    </button>
                @endforeach
            </div>

            <!-- GRID KATALOG KARTU MENU -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($this->getMenus() as $menu)
                    <div class="menu-card bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between relative overflow-hidden">
                        <div>
                            <!-- Kategori Badge (Filament Design System Consistent) -->
                            @if($menu->kategori == 'Makanan')
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/20 uppercase tracking-wider">Makanan</span>
                            @elseif($menu->kategori == 'Minuman')
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-600/20 uppercase tracking-wider">Minuman</span>
                            @else
                                <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[10px] font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-600/20 uppercase tracking-wider">Toping</span>
                            @endif

                            <h3 class="font-bold text-slate-800 mt-3 text-sm line-clamp-2 pr-2 min-h-[40px] leading-snug">
                                {{ $menu->nama_menu }}
                            </h3>

                            <!-- Info Stok -->
                            <div class="mt-2 flex items-center gap-1.5">
                                @if($menu->stok <= 0)
                                    <span class="inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-medium bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-600/10">Habis</span>
                                @elseif($menu->stok <= 10)
                                    <span class="inline-flex items-center rounded-md px-1.5 py-0.5 text-[10px] font-medium bg-amber-50 text-amber-800 ring-1 ring-inset ring-amber-600/10">Sisa {{ $menu->stok }} porsi</span>
                                @else
                                    <span class="text-[10px] text-slate-400">Tersedia: <span class="font-semibold text-slate-600">{{ $menu->stok }}</span></span>
                                @endif
                            </div>
                        </div>

                        <!-- Harga & Tombol Tambah (Minimalist) -->
                        <div class="flex justify-between items-center mt-4 pt-3 border-t border-slate-100">
                            <span class="font-extrabold text-sm text-slate-900">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </span>
                            
                            <button 
                                type="button"
                                wire:click="addToCart({{ $menu->id }})"
                                class="add-to-cart-btn"
                                {{ $menu->stok <= 0 ? 'disabled' : '' }}
                            >
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-slate-200 text-slate-400 text-sm">
                        Menu tidak ditemukan. Silakan gunakan kata kunci pencarian yang lain.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- ================= PANEL KANAN: RINGKASAN BELANJA (1fr) ================= -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex flex-col justify-between sticky top-[85px] max-h-[calc(100vh-120px)] overflow-hidden" style="border: none !important;">
            
            <div class="flex flex-col flex-grow overflow-hidden">
                <!-- Cart Header -->
                <h2 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Ringkasan Belanja</span>
                    <span class="px-2 py-0.5 text-xs bg-slate-100 text-slate-600 rounded-full font-bold">
                        {{ count($cart) }}
                    </span>
                </h2>

                <!-- Daftar Item Belanja (Scrollable) -->
                <div class="cart-scroll-container overflow-y-auto mt-4 space-y-3 pr-1 flex-grow" style="max-height: calc(100vh - 430px);">
                    @forelse($cart as $id => $item)
                        <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/40 hover:bg-slate-50/80 text-xs transition-all flex flex-col gap-2">
                            <div class="flex justify-between items-start gap-2">
                                <div class="flex-grow">
                                    <h4 class="font-semibold text-slate-800 leading-snug">{{ $item['nama_menu'] }}</h4>
                                    <span class="text-[10px] text-slate-400">Rp {{ number_format($item['harga'], 0, ',', '.') }} / porsi</span>
                                </div>
                                
                                <button 
                                    type="button" 
                                    wire:click="removeFromCart({{ $id }})" 
                                    class="remove-item-btn"
                                >
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex justify-between items-center gap-2 mt-1 pt-2 border-t border-slate-100/50">
                                <!-- Qty Changer - / + -->
                                <div class="flex items-center">
                                    <button 
                                        type="button" 
                                        wire:click="decrementQty({{ $id }})" 
                                        class="qty-btn"
                                    >
                                        -
                                    </button>
                                    <span class="w-8 text-center text-xs font-semibold text-slate-800">
                                        {{ $item['jumlah'] }}
                                    </span>
                                    <button 
                                        type="button" 
                                        wire:click="incrementQty({{ $id }})" 
                                        class="qty-btn"
                                    >
                                        +
                                    </button>
                                </div>

                                <!-- Subtotal -->
                                <div class="text-right font-bold text-slate-700 text-xs">
                                    Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Catatan Custom -->
                            <div class="mt-1">
                                <input 
                                    type="text" 
                                    wire:model.live="cart.{{ $id }}.catatan_custom" 
                                    placeholder="Tulis catatan (contoh: pedas, tanpa sayur)..." 
                                    class="w-full px-2 py-1 text-[10px] border border-slate-200 rounded focus:border-orange-500 focus:ring-1 focus:ring-orange-500 bg-white text-slate-700"
                                />
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16 text-slate-400 text-xs flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span>Belum ada pesanan masuk.<br>Silakan tambahkan menu dari katalog.</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ================= FORM METODE & TOMBOL CHECKOUT ================= -->
            <div class="border-t border-slate-100 pt-4 space-y-4 bg-white" style="padding-bottom: 4px;">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold text-slate-600">Nomor Meja</label>
                        <input 
                            type="text" 
                            wire:model="no_meja" 
                            placeholder="Cth: Meja 04" 
                            class="w-full mt-1 px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50/50 text-slate-700 focus:bg-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500" 
                        />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600">Metode Bayar</label>
                        <select 
                            wire:model="metode_bayar" 
                            class="w-full mt-1 px-3 py-1.5 text-xs rounded-lg border border-slate-200 bg-slate-50/50 text-slate-700 focus:bg-white focus:border-orange-500 focus:ring-1 focus:ring-orange-500"
                        >
                            <option value="Tunai">Uang Tunai / Cash</option>
                            <option value="QRIS">QRIS / E-Wallet</option>
                        </select>
                    </div>
                </div>

                <!-- Total Billing Separator & Card -->
                <div class="receipt-divider"></div>
                
                <div class="flex justify-between items-center p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <span class="font-extrabold text-slate-500 text-[10px] tracking-wider uppercase">Total Tagihan:</span>
                    <span class="text-lg font-black font-mono text-slate-900">
                        Rp {{ number_format($total_bayar, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Action Button Checkout -->
                <button 
                    type="button" 
                    wire:click="simpanTransaksi" 
                    class="w-full text-white font-bold py-3 px-4 text-xs tracking-wider uppercase shadow-sm active:scale-98 transition-all flex items-center justify-center gap-2 hover:bg-orange-700"
                    style="background-color: #ea580c; border: none; cursor: pointer; display: flex; border-radius: 8px;"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Selesaikan Transaksi & Cetak</span>
                </button>
            </div>
        </div>

    </div>

    <!-- JAVASCRIPT LIVE TIME ENGINE -->
    <script>
        function renderLiveClockWarmindo() {
            const clockNode = document.getElementById('live-clock-digital');
            if (clockNode) {
                const sekarang = new Date();
                clockNode.innerText = sekarang.toLocaleTimeString('id-ID');
            }
        }
        setInterval(renderLiveClockWarmindo, 1000);
        window.addEventListener('DOMContentLoaded', renderLiveClockWarmindo);
    </script>
</x-filament-panels::page>