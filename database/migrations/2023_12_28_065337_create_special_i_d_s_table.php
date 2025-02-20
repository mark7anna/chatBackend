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
        Schema::create('special_i_d_s', function (Blueprint $table) {
            $table->id();
            $table -> string('uid');
            $table -> string('img');
            $table -> decimal('price');
            $table -> integer('isAvailable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_i_d_s');
    }
};
