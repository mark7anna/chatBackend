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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table -> integer('chat_id');
            $table -> integer('sender_id');
            $table -> integer('reciver_id');
            $table -> timestamp('message_date') -> useCurrent();
            $table -> text('message');
            $table -> string('img');
            $table -> integer('type');
            $table -> integer('isSeen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
