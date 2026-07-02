<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal');
            $table->string('no_meja')->nullable(); // Nullable jika pelanggan pilih Takeaway
            $table->integer('total_bayar')->default(0);
            $table->string('metode_bayar'); // Tunai, QRIS
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};