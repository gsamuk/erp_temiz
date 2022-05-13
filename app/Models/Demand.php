<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    protected $table = 'demand';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
