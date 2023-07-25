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
    // 팔로워, 팔로잉 컬럼 추가
    Schema::table('users', function (Blueprint $table) {
      $table
        ->unsignedBigInteger('follower')
        ->after('bio')
        ->default(0);
      $table
        ->unsignedBigInteger('following')
        ->after('follower')
        ->default(0);
    });
  }
  // 리뷰 테이블 숫자 조회하는 컬럼 만들고 마이그레이션 파일 롤백 왜 안되는지 확인해보기
  // DB는 이미 빠졌을수도
  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn('follower');
      $table->dropColumn('following');
    });
  }
};
