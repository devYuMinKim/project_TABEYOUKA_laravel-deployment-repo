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
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 255)->primary();
            $table->string('nickname', 20)->unique();
            $table->string('profile_image')->nullable();
            $table->string('bio')->nullable();
            $table->unsignedBigInteger('reviews')->default(0);
            $table->unsignedBigInteger('follower')->default(0);
            $table->unsignedBigInteger('following')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('users', function(Blueprint $table) {
        $table->dropUnique('nickname');
        $table->dropIfExists();
      });
    }
};
