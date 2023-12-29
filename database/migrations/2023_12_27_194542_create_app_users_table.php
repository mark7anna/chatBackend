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
        Schema::create('app_users', function (Blueprint $table) {
            $table->id();
            $table -> string('tag') -> unique();
            $table -> string('name');
            $table -> string('img') -> default("");
            $table -> integer('share_level_id') ;
            $table -> integer('karizma_level_id');
            $table -> integer('charging_level_id');
            $table -> string('phone') -> unique();
            $table -> string('email') -> unique();
            $table -> string('password');
            $table -> integer('isChargingAgent') -> default(0);
            $table -> integer('isHostingAgent')-> default(0);
            $table -> date('registered_at') ;
            $table -> timestamp('last_login');
            $table -> timestamp('birth_date') -> useCurrent();
            $table -> integer('enable') -> default(1);
            $table -> text('ipAddress');
            $table -> text('macAddress');
            $table -> text('deviceId');
            $table -> integer('isOnline') -> default(0);
            $table -> integer('isInRoom')  -> default(0);
            $table -> integer('country');
            $table -> string('register_with');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_users');
    }
};
