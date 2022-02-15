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
            $table->bigInteger("post_id")->unsigned();
            $table->foreign("post_id")->references("id")->on("posts")->onDelete('cascade');
            $table->bigInteger("stamp_id")->unsigned();
            $table->foreign("stamp_id")->references("id")->on("stamps")->onDelete('cascade');
            $table->integer("count");
            $table->bigInteger("user_id")->unsigned();
//            $table->foreign("user_id")->references("id")->on("users");
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
