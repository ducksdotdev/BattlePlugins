<?php

use Illuminate\Database\Migrations\Migration;

class CreateProductionBuildsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('production_builds', function ($table) {
            $table->string('id')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
