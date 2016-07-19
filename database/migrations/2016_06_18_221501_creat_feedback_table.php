<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { Schema::create('feedbacks', function (Blueprint $table) {
      //columns
        $table->increments('id')->unsigned();
        $table->integer('from_user')->unsigned();
        $table->integer('to_user')->unsigned();
        $table->string('feedback');
        //foreign kyes
        $table->foreign('from_user')
            ->references('id')->on('users')
            ->onDelete('cascade');
        $table->foreign('to_user')
            ->references('id')->on('users')
            ->onDelete('cascade');

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feedbacks');
        Schema::dropForeign('user_id');
    }
}
