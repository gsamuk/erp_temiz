<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Authorizations;

class CreateAuthorizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->tinyInteger('purchase_view')->default(0);
            $table->tinyInteger('sale_view')->default(0);
            $table->tinyInteger('purchase_approve')->default(0);
            $table->tinyInteger('sale_approve')->default(0);
            $table->tinyInteger('is_admin')->default(0);
        });

        Authorizations::insert([
            'user_id' => 1,
            'purchase_view' => 1,
            'sale_view' => 1,
            'purchase_approve' => 1,
            'sale_approve' => 1,
            'is_admin' => 1,
        ]);


        Authorizations::insert([
            'user_id' => 2,
            'purchase_view' => 1,
            'sale_view' => 1,
            'purchase_approve' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('authorizations');
    }
}
