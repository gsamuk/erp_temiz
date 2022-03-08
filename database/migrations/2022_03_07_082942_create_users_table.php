<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;

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
            $table->id();
            $table->string('email')->unique();
            $table->string('user_name');
            $table->string('password');

            $table->string('name')->nullable(true);
            $table->string('surname')->nullable(true);
            $table->string('logo_user')->nullable(true);
            $table->string('user_code')->nullable(true);
            $table->string('logo_password')->nullable(true);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });

        // Bir tane user kaydı oluşturuluyor
        Users::insert([
            'name' => 'Cemal',
            'surname' => 'Kurt',
            'email' => 'test@test.com',
            'user_name' => 'cemal',
            'logo_user' => 'LOGO',
            'user_code' => '1111',
            'logo_password' => 'dekatek',
            'password' => '123456',
            'created_at' => now(),
        ]);

        Users::insert([
            'name' => 'Gültekin',
            'surname' => 'Samuk',
            'email' => 'gsamuk@gmail.com',
            'user_name' => 'gsamuk',
            'password' => '123456',
            'created_at' => now(),
        ]);
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
