<?php

use Illuminate\Database\Migrations\Migration;

class Drop2FAColumnFromUsers extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::table('users', function ($table) {
      $table->dropColumn('google2fa_secret');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('users', function ($table) {
      $table->string('google2fa_secret', 32)->nullable();
    });
  }
}
