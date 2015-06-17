<?php

use Illuminate\Database\Migrations\Migration;

class MakePastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('pastes', function ($table) {
            $table->increments('id');
            $table->binary('slug', 6)->unique();
            $table->integer('creator')->index()->foreign();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
