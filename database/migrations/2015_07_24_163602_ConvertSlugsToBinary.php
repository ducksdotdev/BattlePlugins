<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ConvertSlugsToBinary extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::statement('ALTER TABLE battleplugins.shorturls CHANGE slug slug BINARY(6);');
        DB::statement('ALTER TABLE battleplugins.pastes CHANGE slug slug BINARY(6);');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement('ALTER TABLE battleplugins.shorturls CHANGE slug slug VARCHAR (6);');
        DB::statement('ALTER TABLE battleplugins.pastes CHANGE slug slug VARCHAR (6);');
    }
}
