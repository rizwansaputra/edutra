<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscribe_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->date('subscription_start_date')->nullable();
            $table->string('proof')->nullable(); // path bukti pembayaran
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'is_paid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscribe_transactions');
    }
};
