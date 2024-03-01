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
        Schema::create('lucky_cases', function (Blueprint $table) {
            $table->id();
            $table -> integer('type');
            $table -> integer('value');
            $table -> integer('user_id');
            $table -> integer('room_id');
            $table -> integer('out_value');
            $table -> timestamp('created_date') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lucky_cases');
    }
};
