<?php

use App\API\GenerateApiKey;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;

class CreateUserTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('email')->unique();
            $table->string('password');

            $table->string('displayname', 16)->unique();
            $table->string('remember_token', 100);
            $table->boolean('admin');

            $table->string('api_key', 32)->unique();
        });

        User::create([
            'email' => 'justin@battleplugins.com',
            'password' => Hash::make('changeme'),
            'displayname' => 'lDucks',
            'admin' => true,
            'api_key' => GenerateApiKey::generateKey()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }
}
