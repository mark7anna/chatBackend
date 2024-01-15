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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table -> string('tag');
            $table -> text('name');
            $table -> string('img');
            $table -> integer('state');
            $table -> string('password');
            $table -> integer('userId');
            $table -> string('subject');
            $table -> integer('talkers_count');
            $table -> integer('starred');
            $table -> integer('isBlocked');
            $table -> timestamp('blockedDate');
            $table -> timestamp('blockedUntil') -> useCurrent();
            $table -> timestamp('createdDate') -> useCurrent();;
            $table -> integer('isTrend');
            $table -> text('details');
            $table -> integer('micCount');
            $table -> integer('enableMessages');
            $table -> integer('reportCount');
            $table -> integer('themeId');
            $table -> integer('country_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
