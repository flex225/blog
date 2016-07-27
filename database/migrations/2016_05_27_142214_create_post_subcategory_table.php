Schema::create('post_category', function (Blueprint $table) {
    $table->increments('id');
    $table->string('category_name');
    $table->timestamps();
});<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostSubcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('post_subcategory', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('subcategory_name');
          $table->integer('category_id')->unsigned();
          $table->foreign('category_id')
          ->references('id')->on('post_category')
          ->onDelete('cascade');
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
      Schema::drop('post_subcategory');
    }
}
