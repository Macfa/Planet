<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            // $table->increments('id');
            // $table->integer('postID');
            // $table->foreign('postID')->references('id')->on('channel');
            // $table->string('postTitle', 100);
            // $table->mediumText('postContent');
            // $table->integer('postMemberSeq');
            // $table->integer('postStampSeq')->nullable();
            // $table->integer('postLike');
            // $table->integer('postHate');
            // $table->integer('postPenalty');
            // $table->boolean('postHide');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
