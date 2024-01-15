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
        Schema::create('gift_transactions', function (Blueprint $table) {
            $table->id();
            $table -> integer('gift_id');
            $table -> integer('sender_id');
            $table -> integer('receiver_id');
            $table -> integer('room_id');
            $table -> integer('count');
            $table -> decimal('price');
            $table -> decimal('total');
            $table -> timestamp('sendDate') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_transactions');
    }
};
