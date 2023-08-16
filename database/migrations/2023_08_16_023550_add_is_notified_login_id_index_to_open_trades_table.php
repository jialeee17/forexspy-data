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
        Schema::table('open_trades', function (Blueprint $table) {
            $table->index(['is_notified', 'login_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('open_trades', function (Blueprint $table) {
            $table->dropIndex(['is_notified', 'login_id']);
        });
    }
};
