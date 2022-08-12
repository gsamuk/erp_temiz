<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoAccountsAll extends Model
{
    protected $table = 'lv_accounts_001'; // 1 nolu firmanın verileri gelir
    protected $primaryKey = 'ref_id';
}