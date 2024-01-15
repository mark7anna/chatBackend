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
        Schema::create('user_notifications', function (Blueprint $table) {
            $table ->id();
            $table ->string('type');
            $table ->integer('notified_user');
            $table ->integer('action_user');
            $table ->string('title');
            $table ->text('content');
            $table ->string('title_ar');
            $table ->text('content_ar');
            $table ->integer('isRead');
            $table ->integer('post_id');
            $table ->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
    }
};
