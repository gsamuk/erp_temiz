<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LogoItemsPhoto extends Model
{
    protected $table = 'item_foto_path'; // bizim taraf
    protected $primaryKey = 'id';
    public $timestamps = false;
}
