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
        Schema::create('vip_purchases', function (Blueprint $table) {
            $table->id();
            $table -> integer('user_id');
            $table -> integer('vip_id');
            $table -> timestamp('purchase_date')-> useCurrent();
            $table -> timestamp('available_untill') -> useCurrent();
            $table -> integer('price');
            $table -> integer('isDefault');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vip_purchases');
    }
};
