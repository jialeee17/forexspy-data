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
        Schema::table('accounts', function (Blueprint $table) {
            $table->after('commission_blocked', function ($table) {
                $table->decimal('highest_drawdown_amount', 20, 2)->default(0);
                $table->decimal('highest_drawdown_percentage', 8, 2)->default(0);
                $table->integer('active_pairs')->default(0);
                $table->integer('active_orders')->default(0);
                $table->decimal('profit_today')->default(0);
                $table->decimal('profit_all_time')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['highest_drawdown_amount', 'highest_drawdown_percentage', 'active_pairs', 'active_orders', 'profit_today', 'profit_all_time']);
        });
    }
};
