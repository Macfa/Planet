<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('postID')->unsigned();
            $table->foreign('postID')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('group')->nullable();
            $table->longText('content')->nullable();
            $table->integer('memberID');
            $table->tinyInteger('hide')->default('0');
            $table->integer('depth')->default('0');
            $table->integer('order')->default('0');
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
        Schema::dropIfExists('comments');
    }
}
