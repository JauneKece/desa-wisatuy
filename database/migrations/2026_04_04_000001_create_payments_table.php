<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reservasi_id')->nullable()->constrained('reservasi')->onDelete('cascade');
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('method')->nullable();
                $table->string('transaction_id')->nullable();
                $table->text('proof_path')->nullable();
                $table->enum('status', ['pending','paid','failed','refunded'])->default('pending');
                $table->timestamp('paid_at')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
