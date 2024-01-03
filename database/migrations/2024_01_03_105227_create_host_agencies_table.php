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
        Schema::create('host_agencies', function (Blueprint $table) {
            $table->id();
            $table ->string('name');
            $table ->string('tag');
            $table ->integer('user_id');
            $table ->decimal('monthly_gold_target');
            $table ->text('details');
            $table ->integer('active');
            $table ->integer('allow_new_joiners');
            $table ->integer('automatic_accept_joiners');
            $table ->integer('automatic_accept_exit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('host_agencies');
    }
};
