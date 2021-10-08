<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("groupID")->unsigned();
            $table->foreign("groupID")->references("id")->on("stamp_groups")->onDelete("cascade");
            $table->string("name", 10);
            $table->string("image");
            $table->integer("coin");
            $table->string("abbr", 20); // 약어
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
        Schema::dropIfExists('stamps');
    }
}
