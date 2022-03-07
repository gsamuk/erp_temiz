<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseorderhistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseOrderHistory', function (Blueprint $table) {
            $table->id();
            $table->string('actions');
            $table->integer('purchase_order_id');
            $table->integer('company_id');
            $table->integer('user_id');
            $table->string('order_name');
            $table->integer('logo_logicalref');
            $table->integer('logo_ficheno');
            $table->date('due_date');
            $table->dateTime('remind_time');
            $table->tinyInteger('is_approve')->default(0);
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
        Schema::dropIfExists('purchaseorderhistory');
    }
}
