<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('order_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("user_id");
            $table->index("user_id");
            $table->foreign("user_id")->references('id')->on('users');

            $table->boolean("opened");
            $table->dateTime("open_date");
            $table->dateTime("close_date");
            $table->char("tableHashId");
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId("order_session_id")->constrained("order_sessions");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn("order_session_id");
        });

        Schema::table('order_sessions', function (Blueprint $table) {
            //
            $table->dropIndex("user_id");
            $table->dropColumn("user_id");
        });

        Schema::dropIfExists('order_sessions');
    }
}
