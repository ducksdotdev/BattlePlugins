<?php

use Illuminate\Database\Migrations\Migration;

class Add2faSecretToUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            $table->string('google2fa_secret', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function ($table) {
            $table->dropColumn('google2fa_secret');
        });
    }
}
