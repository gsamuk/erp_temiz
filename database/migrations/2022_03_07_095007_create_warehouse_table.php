<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Warehouse;


class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->string('warehouse_name', 100);
            $table->string('logo_warehouse_id');
        });

        Warehouse::insert(["company_id" => 1, "warehouse_name" => "Merkez Ana Depo", "logo_warehouse_id" => "000",]);
        Warehouse::insert(["company_id" => 1, "warehouse_name" => "Merkez Mazot Deposu", "logo_warehouse_id" => "001",]);
        Warehouse::insert(["company_id" => 1, "warehouse_name" => "PVC Dograma H.Madde Malz. Deposu", "logo_warehouse_id" => "002",]);
        Warehouse::insert(["company_id" => 1, "warehouse_name" => "Asfalt H.Madde Deposu", "logo_warehouse_id" => "003",]);
        Warehouse::insert(["company_id" => 1, "warehouse_name" => "Patlama Malzeme Deposu", "logo_warehouse_id" => "004",]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse');
    }
}
