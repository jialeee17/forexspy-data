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
        Schema::create('open_trades', function (Blueprint $table) {
            $table->id();
            $table->uuid('telegram_user_uuid');
            $table->string('ticket');
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
            $table->decimal('open_price', 20, 5);
            $table->dateTime('open_at');
            $table->decimal('close_price', 20, 5)->nullable();
            $table->dateTime('close_at')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();

            $table->index('open_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_trades');
    }
};
