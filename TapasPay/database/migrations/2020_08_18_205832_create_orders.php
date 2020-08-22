<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("order_status", function (Blueprint $table){
            $table->id();
            $table->timestamps();
            $table->char("name");
        });

        DB::table("order_status")->insert(["name" => "pending"]);
        DB::table("order_status")->insert(["name" => "in_progress"]);
        DB::table("order_status")->insert(["name" => "ready"]);
        DB::table("order_status")->insert(["name" => "delivered"]);

        Schema::create("order_lines", function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char("product_name");
            $table->text("note");
            $table->float("price_unit");
            $table->integer("quantity");
            $table->foreignId("res_id");
            $table->foreignId("order_id");
            $table->foreignId("order_status_id");
            $table->char("res_table");
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->dateTime("date");
            $table->foreignId("establishment_id");
            $table->integer("number_of_table");
            $table->foreignId("order_status_id");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_status');
        Schema::dropIfExists('order_lines');
        Schema::dropIfExists('orders');
    }
}
