Schema::create('posts', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('surname');
    $table->string('gender');
    $table->integer('post_type');
    $table->text('body');
    $table->string('image_src');
    $table->text('contacts');
    $table->integer('state_id');
    $table->integer('subcategory_id');
    $table->timestamps();
});<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('post_category', function (Blueprint $table) {
          $table->increments('id');
          $table->string('category_name');
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
        Schema::drop('post_category');
    }
}
