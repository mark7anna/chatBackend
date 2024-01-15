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
        Schema::create('festival_banners', function (Blueprint $table) {
            $table->id();
            $table -> string('title');
            $table -> integer('type');
            $table -> text('description');
            $table -> string('img');
            $table -> integer('room_id');
            $table -> timestamp('start_date');
            $table -> decimal('duration_in_hour');
            $table -> integer('enable');
            $table -> integer('accepted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_banners');
    }
};
