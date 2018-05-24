<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('polls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('poll_category_id')->unsigned();
            $table->foreign('poll_category_id')->references('id')->on('poll_categories');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('image');
            $table->text('poll_code');
            $table->boolean('is_multichoice');
            $table->boolean('is_approved');
            $table->boolean('is_active');
            $table->boolean('is_private');
            $table->string('visible_for');
            $table->timestamps();
            $table->dateTime('poll_start_date');
            $table->dateTime('poll_end_date');
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
        Schema::drop('polls');
    }
}
