<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    // follows 테이블에 새로운 행이 추가되면 user의 팔로우 수를 업데이트 한다.'
    DB::unprepared('
        CREATE TRIGGER update_user_follow_after_insert AFTER INSERT ON follows
        FOR EACH ROW
        BEGIN
            UPDATE users
            SET `follower` = (
                SELECT COUNT(*) FROM follows WHERE to_user = NEW.to_user
            )
            WHERE id = NEW.to_user;
            UPDATE users
            SET `following` = (
                SELECT COUNT(*) FROM follows WHERE from_user = NEW.from_user
            )
            WHERE id = NEW.from_user;
        END
    ');
    DB::unprepared('
        CREATE TRIGGER update_user_follow_after_delete AFTER DELETE ON follows
        FOR EACH ROW
        BEGIN
            UPDATE users
            SET `follower` = (
                SELECT COUNT(*) FROM follows WHERE to_user = OLD.to_user
            )
        WHERE id = OLD.to_user;
            UPDATE users
            SET `following` = (
                SELECT COUNT(*) FROM follows WHERE from_user = OLD.from_user
            )
            WHERE id = OLD.from_user;
        END
    ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::unprepared('DROP TRIGGER IF EXISTS update_user_follow_after_delete');
    DB::unprepared('DROP TRIGGER IF EXISTS update_user_follow_after_insert');
  }
};
