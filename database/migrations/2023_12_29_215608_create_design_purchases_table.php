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
        Schema::create('design_purchases', function (Blueprint $table) {
            $table->id();
            $table -> integer('design_id');
            $table -> integer('user_id');
            $table -> integer('isAvailable');
            $table -> timestamp('purchase_date');
            $table -> timestamp('available_until') -> useCurrent();
            $table -> decimal('price');
            $table -> integer('count');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('design_purchases');
    }
};
