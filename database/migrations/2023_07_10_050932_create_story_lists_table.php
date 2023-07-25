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
    Schema::create('story_lists', function (Blueprint $table) {
      $table->id();
      $table->string('user_id', 255);
      $table
        ->foreign('user_id')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
      $table->string('story_name', 10);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('story_lists');
  }
};
