<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('paket_wisata_id')->nullable()->constrained('paket_wisata')->onDelete('set null');
            $table->foreignId('penginapan_id')->nullable()->constrained('penginapan')->onDelete('set null');
            $table->date('tanggal_reservasi');
            $table->date('tanggal_kunjungan');
            $table->integer('jumlah_peserta');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
