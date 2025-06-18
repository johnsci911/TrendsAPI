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
        schema::create('follows', function (blueprint $table) {
            $table->primary(['user_id', 'following_user_id']);
            $table->foreignid('user_id')->constrained('users')->ondelete('cascade');
            $table->foreignid('following_user_id')->constrained('users')->ondelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
