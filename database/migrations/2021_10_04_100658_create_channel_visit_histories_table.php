<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelVisitHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_visit_histories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('channel_id')->unsigned();
            $table->foreign("channel_id")->references("id")->on("channels")->onDelete("cascade");
//            $table->foreignId('channel_id')->nullable()->constrained("channels")->cascadeOnUpdate()->nullOnDelete();
            $table->bigInteger("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete('cascade');
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
        Schema::dropIfExists('channel_visit_histories');
    }
}
