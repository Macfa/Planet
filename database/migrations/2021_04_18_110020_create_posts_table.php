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
            $table->increments('id');
            $table->integer('channelID')->unsigned();
            $table->foreign('channelID')->references('id')->on('channels')->onDelete('cascade');
            $table->string('title', 200);
            $table->mediumText('content');
            $table->integer('memberID');
            // $table->foreign('memberID')->references('id')->on('member');
            // $table->integer('postStampSeq')->nullable();
            // $table->integer('like')->default('0');
            // $table->integer('hate')->default('0');
            // $table->integer('penalty')->default('0');
            $table->boolean('hide')->default('0');
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
        Schema::dropIfExists('posts');
    }
}
