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
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table -> integer('is_store');
            $table -> string('name');
            $table -> string('tag');
            $table -> integer('order');
            $table -> integer('category_id');
            $table -> integer('gift_category_id');
            $table -> decimal('price');
            $table -> integer('days');
            $table -> integer('behaviour');
            $table -> string('icon');
            $table -> string('motion_icon');
            $table -> string('dark_icon');
            $table -> integer('subject');
            $table -> integer('vip_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designs');
    }
};
