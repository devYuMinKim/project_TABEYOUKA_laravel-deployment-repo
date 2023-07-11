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
      $table->unsignedBigInteger('story_list_id');
      $table->unsignedBigInteger('review_id');
      $table
        ->unique('story_list_id')
        ->references('id')
        ->on('stort_lists')
        ->onDelete('cascade');
      $table
        ->unique('review_id')
        ->references('id')
        ->on('reviews')
        ->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('stories');
  }
};
