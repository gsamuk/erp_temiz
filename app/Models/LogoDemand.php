<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoDemand extends Model
{
    protected $primaryKey = 'logicalref';
    protected $table = 'lv_demand_001'; // 1 nolu firmanın verileri gelir
}
