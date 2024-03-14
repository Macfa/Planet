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
            $table->foreign("channel_id")->references("id")->on("channels")->onDelete('cascade');
            $table->string('title', 100);
            $table->string('image', 100)->nullable();
            $table->longText('content');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->integer('is_main_notice')->nullable()->default(0);
            $table->integer('is_channel_notice')->nullable()->default(0);
            $table->softDeletes();
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
