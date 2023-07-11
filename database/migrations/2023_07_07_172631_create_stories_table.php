<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('stories', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('user_id', 255);
      $table->unsignedBigInteger('review_id');
      $table->timestamps();

      $table
        ->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
      $table
        ->foreign('review_id')
        ->references('id')
        ->on('reviews')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropForeign(['user_id']);
    Schema::dropForeign(['review_id']);
    Schema::dropIfExists('stories');
  }
};
