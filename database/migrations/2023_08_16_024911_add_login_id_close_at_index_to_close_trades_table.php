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
        Schema::table('close_trades', function (Blueprint $table) {
            $table->index(['login_id', 'close_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('close_trades', function (Blueprint $table) {
            $table->dropIndex(['login_id', 'close_at']);
        });
    }
};
