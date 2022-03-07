<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsershistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersHistory', function (Blueprint $table) {
            $table->id();
            $table->string('actions');
            $table->integer('users_id');
            $table->dateTime('insert_time');
            $table->string('user_name');
            $table->string('password');
            $table->string('logo_user');
            $table->string('user_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usershistory');
    }
}
