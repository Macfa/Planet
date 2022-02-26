<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampInCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamp_in_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("comment_id")->unsigned();
            $table->foreign("comment_id")->references("id")->on("comments")->onDelete('cascade');
            $table->bigInteger("stamp_id")->unsigned();
            $table->foreign("stamp_id")->references("id")->on("stamps")->onDelete('cascade');
            $table->integer("count");
            $table->bigInteger("user_id")->unsigned();
            $table->softDeletes();
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
        Schema::dropIfExists('stamp_in_comments');
    }
}
