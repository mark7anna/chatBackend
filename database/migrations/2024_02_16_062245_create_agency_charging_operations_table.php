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
        Schema::create('agency_charging_operations', function (Blueprint $table) {
            $table->id();
            $table ->integer('agency_id');
            $table ->integer('user_id');
            $table ->string('type');
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
        Schema::dropIfExists('agency_charging_operations');
    }
};
