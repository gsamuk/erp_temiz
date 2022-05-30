<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoPurchaseOrders extends Model
{
    protected $primaryKey = 'logicalref';
    protected $table = 'lv_purchase_order_001'; // 1 nolu firmanın verileri gelir
}
