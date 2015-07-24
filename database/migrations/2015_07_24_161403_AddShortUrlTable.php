<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddShortUrlTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('shorturls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->timestamp('last_used');
            $table->string('url')->unique();

            $table->string('slug', 6)->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('shorturls');
    }
}
