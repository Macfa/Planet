<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostReadHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_read_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('postID')->unsigned();
            $table->foreign("postID")->references("id")->on("posts")->onDelete("cascade");
            $table->bigInteger('userID')->unsigned();
            $table->foreign("userID")->references("id")->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('post_read_histories');
    }
}
