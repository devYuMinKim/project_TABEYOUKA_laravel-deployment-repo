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
    DB::unprepared('
      CREATE TRIGGER update_review_like_count_after_insert AFTER INSERT ON likes
      FOR EACH ROW
      BEGIN
        UPDATE reviews
        SET `like` = (
          SELECT COUNT(*) FROM likes WHERE review_id = NEW.review_id
        )
        WHERE id = NEW.review_id;
      END
    ');
    DB::unprepared('
      CREATE TRIGGER update_review_like_count_after_delete AFTER DELETE ON likes
      FOR EACH ROW
      BEGIN
        UPDATE reviews
        SET `like` = (
          SELECT COUNT(*) FROM likes WHERE review_id = OLD.review_id
        )
        WHERE id = OLD.review_id;
      END
    ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::unprepared(
      'DROP TRIGGER IF EXISTS update_review_like_count_after_insert'
    );
    DB::unprepared(
      'DROP TRIGGER IF EXISTS update_review_like_count_after_delete'
    );
  }
};
