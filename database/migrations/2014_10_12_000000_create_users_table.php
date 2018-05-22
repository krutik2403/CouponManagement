<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('is_admin')->default(2)->comment('1 - Super Admin, 2 - Other Users');
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('password');
            $table->string('user_image', 255)->nullable();
            $table->tinyInteger('gender')->default(0)->comment('1 - Male, 2 - Female, 3 - Other');
            $table->string('phone', 15)->unique()->nullable();
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
        Schema::dropIfExists('users');
    }
}
