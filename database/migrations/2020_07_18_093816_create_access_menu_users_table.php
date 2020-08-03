<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessMenuUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_menu_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submenu_id');
            $table->unsignedBigInteger('role_id');
            $table->integer('access');
            $table->timestamps();

            $table->foreign('submenu_id')->references('id')->on('sub_menus')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_menu_users');
    }
}
