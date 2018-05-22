<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTable extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('coupon_name', 100)->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('vaild_from_datetime')->nullable();
            $table->dateTime('vaild_until_datetime')->nullable();
            $table->string('coupon_amount', 255)->nullable();
            $table->string('max_redeem', 255)->nullable();
            $table->string('max_redeem_per_user', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon');
    }
}
