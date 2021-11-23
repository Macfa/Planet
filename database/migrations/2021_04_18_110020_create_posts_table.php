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
//            $table->foreignId('channel_id')->nullable()->constrained("channels")->cascadeOnUpdate()->nullOnDelete();

            $table->bigInteger('channel_id')->unsigned();
            $table->foreign("channel_id")->references("id")->on("channels")->onDelete('cascade');
            $table->string('title', 200);
            $table->string('image', 100)->nullable();
            $table->longText('content');
//            $table->foreignId('user_id')->nullable()->constrained("users")->cascadeOnUpdate()->nullOnDelete();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
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
