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
        Schema::create('agency_members', function (Blueprint $table) {
            $table -> id();
            $table -> integer('agency_id');
            $table -> integer('user_id');
            $table -> integer('state');
            $table -> timestamp('joining_date') -> useCurrent();
            $table -> timestamp('approval_date')-> useCurrent();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_members');
    }
};
