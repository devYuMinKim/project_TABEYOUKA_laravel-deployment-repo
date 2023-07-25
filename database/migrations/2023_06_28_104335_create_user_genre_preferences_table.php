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
        Schema::create('user_genre_preferences', function (Blueprint $table) {
            $table->string('user_id', 255)->primary();
            for ($i = 1 ; $i <= 17 ; $i++) {
                $table->integer('G' . str_pad($i, 3, '0', STR_PAD_LEFT))->default(0);
            }
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_genre_preferences');
    }
};
