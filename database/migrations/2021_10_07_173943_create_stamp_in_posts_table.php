<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampInPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamp_in_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("postID")->unsigned();
            $table->foreign("postID")->references("id")->on("posts")->onDelete("cascade");
            $table->bigInteger("stampID")->unsigned();
            $table->foreign("stampID")->references("id")->on("stamps")->onDelete("cascade");
            $table->integer("count");
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
        Schema::dropIfExists('stamp_in_posts');
    }
}
