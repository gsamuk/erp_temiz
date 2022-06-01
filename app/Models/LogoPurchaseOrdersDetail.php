<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LogoPurchaseOrdersDetail extends Model
{
    protected $primaryKey = 'logicalref';
    protected $table = 'lv_purchase_order_detail_001'; // 1 nolu firmanın verileri gelir
}
