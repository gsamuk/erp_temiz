<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoDb extends Model
{
    protected $connection = 'logo_sqlsrv';
    protected $table = 'LNX_STD_1_001_01_ITEMS';
}
