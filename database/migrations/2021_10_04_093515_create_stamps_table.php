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
            $table->bigInteger("category_group_id")->unsigned();
            $table->foreign("category_group_id")->references("id")->on("stamp_groups")->onDelete("cascade");
            $table->string("name", 30);
            $table->string("image")->nullable();
            $table->string("description")->nullable();
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
