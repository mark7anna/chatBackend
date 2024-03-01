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
        Schema::create('rollets', function (Blueprint $table) {
            $table->id();
            $table -> integer('type');
            $table -> integer('value');
            $table -> integer('member_count');
            $table -> integer('adminShare');
            $table -> integer('state');
            $table -> integer('room_id');
            $table -> integer('winner_id');
            $table -> integer('actual_member_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rollets');
    }
};
