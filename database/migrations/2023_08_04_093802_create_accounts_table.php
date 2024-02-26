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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login_id')->unique();
            $table->foreignUuid('forexspy_user_uuid');
            $table->enum('trade_mode', ['demo', 'contest', 'real']);
            $table->bigInteger('leverage')->default(0);
            $table->integer('limit_orders')->default(0);
            $table->enum('margin_so_mode', ['percent', 'money']);
            $table->boolean('is_trade_allowed')->default(false);
            $table->boolean('is_trade_expert')->default(false);
            $table->decimal('balance', 20, 2)->default(0);
            $table->decimal('credit', 20, 2)->default(0);
            $table->decimal('profit', 20, 2)->default(0);
            $table->decimal('equity', 20, 2)->default(0);
            $table->decimal('margin', 20, 2)->default(0);
            $table->decimal('margin_free', 20, 2)->default(0);
            $table->decimal('margin_level', 20, 2)->default(0);
            $table->decimal('margin_so_call', 20, 2)->default(0);
            $table->decimal('margin_so_so', 20, 2)->default(0);
            $table->decimal('margin_initial', 20, 2)->default(0);
            $table->decimal('margin_maintenance', 20, 2)->default(0);
            $table->decimal('assets', 20, 2)->default(0);
            $table->decimal('liabilities', 20, 2)->default(0);
            $table->decimal('commission_blocked', 20, 2)->default(0);
            $table->decimal('highest_drawdown_amount', 20, 2)->default(0);
            $table->decimal('highest_drawdown_percentage', 8, 2)->default(0);
            $table->integer('active_pairs')->default(0);
            $table->integer('active_orders')->default(0);
            $table->decimal('profit_today')->default(0);
            $table->decimal('profit_all_time')->default(0);
            $table->string('name');
            $table->string('server');
            $table->string('currency');
            $table->string('company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
