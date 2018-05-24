<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('role', ['admin', 'company', 'user']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('slug');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('gender', ['M', 'F']);
            $table->date('born');
            $table->longText('address');
            $table->string('city');
            $table->string('country');
            $table->string('confirmation_code');
            $table->boolean('is_confirmed');
            $table->boolean('is_blocked');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
