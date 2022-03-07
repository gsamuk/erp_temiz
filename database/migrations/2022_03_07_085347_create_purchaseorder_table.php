<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PurchaseOrder;

class CreatePurchaseorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseOrder', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('users_id');
            $table->string('order_name');
            $table->integer('logo_logicalref');
            $table->integer('logo_ficheno');
            $table->date('due_date');
            $table->dateTime('remind_time');
            $table->tinyInteger('is_approve');
            $table->dateTime('insert_time')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchaseorder');
    }
}
