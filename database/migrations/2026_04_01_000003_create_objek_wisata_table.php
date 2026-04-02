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
        Schema::create('objek_wisata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_wisata_id')->constrained('kategori_wisata')->onDelete('cascade');
            $table->string('nama_objek');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->decimal('harga_tiket', 10, 2);
            $table->string('jam_buka');
            $table->string('jam_tutup');
            $table->string('foto')->nullable();
            $table->integer('rating')->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objek_wisata');
    }
};
