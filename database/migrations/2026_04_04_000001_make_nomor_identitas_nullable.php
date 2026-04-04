<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use direct statement to avoid requiring doctrine/dbal for this change
        DB::statement('ALTER TABLE `pelanggan` MODIFY `nomor_identitas` VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ensure no NULL values remain before making column NOT NULL
        DB::statement("UPDATE `pelanggan` SET `nomor_identitas` = '' WHERE `nomor_identitas` IS NULL");
        DB::statement('ALTER TABLE `pelanggan` MODIFY `nomor_identitas` VARCHAR(255) NOT NULL');
    }
};
