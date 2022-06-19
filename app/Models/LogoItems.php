<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class LogoItems extends Model
{
    use Searchable;
    protected $table = 'lv_items_wh_001';
    protected $primaryKey = 'logicalref';
}
