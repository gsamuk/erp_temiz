<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DemandNote extends Model
{
    protected $table = 'demand_note';
    protected $primaryKey = 'id';
    public $timestamps = false;
}