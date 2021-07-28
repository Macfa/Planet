<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coinable_type', 50);
            $table->integer('coinable_id');
            $table->string('type', 50);
            $table->integer('coin');
            $table->integer('userID')->unsigned();
            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

//    public function up()
//    {
//        Schema::create('coins', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('coinable_type', 50);
//            $table->integer('coinable_id');
//            $table->string('action');
//            $table->integer('coin');
//            $table->integer('userID')->unsigned();
//            $table->foreign('userID')->references('id')->on('users')->onDelete('cascade');
//            $table->timestamps();
//        });
//    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coins');
    }
}
