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
        Schema::create('room_blocks', function (Blueprint $table) {
            $table->id();
            $table -> integer('room_id');
            $table -> integer('user_id');
            $table -> timestamp('blocked_date') -> useCurrent();
            $table -> string('block_type');
            $table -> timestamp('block_until') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_blocks');
    }
};
