<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_admins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("channelID")->unsigned();
            $table->foreign("channelID")->references("id")->on("channels");
            $table->bigInteger("userID")->unsigned();
            $table->foreign("userID")->references("id")->on("users");
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
        Schema::dropIfExists('channel_admins');
    }
}
