<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DropShortUrlTable extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::drop('shorturls');
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::create('shorturls', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->timestamp('last_used');
      $table->string('url')->unique();

      $table->string('slug', 6)->unique();
    });
  }
}
