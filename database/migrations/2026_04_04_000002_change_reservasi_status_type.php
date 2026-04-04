<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change status column to VARCHAR to avoid enum mismatch warnings
        DB::statement("ALTER TABLE `reservasi` MODIFY `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        // revert to original enum set (if needed)
        DB::statement("ALTER TABLE `reservasi` MODIFY `status` ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
