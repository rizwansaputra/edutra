<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->enum('status', ['pending', 'paid', 'failed'])
                  ->default('pending')
                  ->after('course_id');
        });
    }

    public function down(): void
    {
        Schema::table('subscribe_transactions', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};