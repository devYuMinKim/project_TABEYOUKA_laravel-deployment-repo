<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table
        ->unsignedBigInteger('reviews')
        ->after('bio')
        ->default(0);
    });

    DB::unprepared('
        CREATE TRIGGER update_user_reviews_after_insert AFTER INSERT ON reviews
        FOR EACH ROW
        BEGIN
            UPDATE users
            SET `reviews` = (
                SELECT COUNT(*) FROM reviews WHERE user_id = NEW.user_id
            )
            WHERE id = NEW.user_id;
        END
    ');
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    DB::unprepared('DROP TRIGGER IF EXISTS update_user_reviews_after_insert');
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('reviews');
    });
  }
};
