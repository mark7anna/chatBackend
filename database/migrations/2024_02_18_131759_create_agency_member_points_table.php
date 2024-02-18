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
        Schema::create('agency_member_points', function (Blueprint $table) {
            $table->id();
            $table -> integer('user_id');
            $table -> integer('agency_id');
            $table -> integer('gift_id');
            $table -> integer('points');
            $table -> timestamp('send_date') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_member_points');
    }
};
