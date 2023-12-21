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
    Schema::create('review_story_list', function (Blueprint $table) {
      $table->foreignId('story_list_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
      $table->foreignId('review_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('review_story_list', function(Blueprint $table) {
      $table->dropUnique(['review_id', 'story_list_id']);
      $table->dropIfExists();
    });
  }
};
