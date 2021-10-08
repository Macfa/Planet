<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStampGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamp_groups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("categoryID")->unsigned();
            $table->foreign("categoryID")->references("id")->on("stamp_categories")->onDelete("cascade");
            $table->string("name", 10);
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
        Schema::dropIfExists('stamp_groups');
    }
}
