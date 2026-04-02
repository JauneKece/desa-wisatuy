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
        Schema::create('penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penginapan');
            $table->text('deskripsi');
            $table->string('alamat');
            $table->string('telepon');
            $table->decimal('harga_penginapan', 10, 2);
            $table->integer('jumlah_kamar');
            $table->string('tipe_kamar');
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
        Schema::dropIfExists('penginapan');
    }
};
