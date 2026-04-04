<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `payments` MODIFY `method` VARCHAR(50) NULL");
    }

    public function down(): void
    {
        // revert to typical enum used previously (bank_transfer,qris,midtrans,cash)
        DB::statement("ALTER TABLE `payments` MODIFY `method` ENUM('bank_transfer','qris','midtrans','cash') NULL");
    }
};
