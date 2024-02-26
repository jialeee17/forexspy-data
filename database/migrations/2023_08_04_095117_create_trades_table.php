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
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_login_id')->references('login_id')->on('accounts');
            $table->string('ticket')->unique();
            $table->string('symbol');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('lots', 8, 2)->default(0);
            $table->decimal('commission', 20, 2)->default(0);
            $table->decimal('profit', 20, 2)->default(0);
            $table->decimal('stop_loss', 20, 2)->default(0);
            $table->decimal('swap', 20, 2)->default(0);
            $table->decimal('take_profit', 20, 2)->default(0);
            $table->string('magic_number')->nullable();
            $table->string('comment')->nullable();
            $table->enum('status', ['open', 'closed']);
            $table->decimal('open_price', 20, 5);
            $table->dateTime('open_at');
            $table->decimal('close_price', 20, 5)->nullable();
            $table->dateTime('close_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->boolean('open_notif_sent')->default(false);
            $table->boolean('closed_notif_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
