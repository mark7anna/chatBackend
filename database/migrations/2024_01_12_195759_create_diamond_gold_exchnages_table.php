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
        Schema::create('diamond_gold_exchnages', function (Blueprint $table) {
            $table->id();
            $table -> integer('user_id');
            $table -> integer('diamond');
            $table -> decimal('diamond_gold_ration');
            $table -> integer('gold');
            $table -> timestamp('exchange_date') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diamond_gold_exchnages');
    }
};
