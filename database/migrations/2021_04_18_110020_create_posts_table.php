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
            $table->id();
            $table->bigInteger('channel_id')->unsigned();
            $table->foreign("channel_id")->references("id")->on("channels");
            $table->string('title', 200);
            $table->string('image', 100)->nullable();
            $table->longText('content');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();

            $table->index('id');
            $table->index('channel_id');
            $table->index('user_id');
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
