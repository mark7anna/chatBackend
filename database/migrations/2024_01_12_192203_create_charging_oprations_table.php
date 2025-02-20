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
        Schema::create('charging_oprations', function (Blueprint $table) {
            $table->id();
            $table ->integer('user_id');
            $table ->integer('gold');
            $table ->string('source');
            $table ->integer('state');
            $table ->timestamp('charging_date') -> useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charging_oprations');
    }
};
