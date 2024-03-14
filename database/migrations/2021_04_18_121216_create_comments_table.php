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
            $table->id();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign("post_id")->references("id")->on("posts")->onDelete('cascade');
            $table->bigInteger('target_id')->unsigned()->nullable();
            $table->foreign("target_id")->references("id")->on("users")->onDelete('cascade');
            $table->integer('group');
            $table->integer('score')->default(0);
            $table->mediumText('content');
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
            $table->integer('depth')->default('0');
            $table->integer('order')->default('0');
            $table->softDeletes();
            $table->timestamps();
            $table->index('id');
            $table->index('post_id');
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
        Schema::dropIfExists('comments');
    }
}
