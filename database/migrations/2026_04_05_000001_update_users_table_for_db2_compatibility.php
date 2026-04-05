<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ubah enum role dan tambah kolom akitf untuk DB2
     */
    public function up(): void
    {
        // Step 1: Update data terlebih dahulu (map old values to new)
        // admin → admin
        // manager → owner
        // staff → bendahara
        // customer → pelanggan
        DB::statement("
            UPDATE users 
            SET role = CASE 
                WHEN role = 'manager' THEN 'owner'
                WHEN role = 'staff' THEN 'bendahara'
                WHEN role = 'customer' THEN 'pelanggan'
                ELSE role
            END
            WHERE role IN ('manager', 'staff', 'customer')
        ");

        // Step 2: Ubah enum definition di MySQL
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin','owner','bendahara','pelanggan') NOT NULL DEFAULT 'pelanggan'
        ");

        // Step 3: Tambah kolom 'akitf' untuk DB2 (shorthand dari is_active)
        if (!Schema::hasColumn('users', 'akitf')) {
            Schema::table('users', function (Blueprint $table) {
                $table->tinyInteger('akitf')->default(1)->after('is_active')
                    ->comment('DB2 compatibility: user active status (1=active, 0=inactive)');
            });
        }

        // Step 4: Sync akitf dengan is_active
        DB::statement("UPDATE users SET akitf = IF(is_active = true, 1, 0)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Step 1: Drop akitf column
        if (Schema::hasColumn('users', 'akitf')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('akitf');
            });
        }

        // Step 2: Revert role values back to old names
        DB::statement("
            UPDATE users 
            SET role = CASE 
                WHEN role = 'owner' THEN 'manager'
                WHEN role = 'bendahara' THEN 'staff'
                WHEN role = 'pelanggan' THEN 'customer'
                ELSE role
            END
            WHERE role IN ('owner', 'bendahara', 'pelanggan')
        ");

        // Step 3: Ubah enum definition kembali ke nilai original
        DB::statement("
            ALTER TABLE users 
            MODIFY COLUMN role ENUM('admin','manager','staff','customer') NOT NULL DEFAULT 'customer'
        ");
    }
};
