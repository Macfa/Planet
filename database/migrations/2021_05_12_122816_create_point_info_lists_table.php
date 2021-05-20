<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointInfoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_info_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('point')->nullable();
            $table->string('route', 50);
            $table->string('action', 50);
            $table->string('msg', 255);
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
        Schema::dropIfExists('point_info_lists');
    }
}
