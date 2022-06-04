<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{

    protected $primaryKey = 'id';
    protected $table = "user_company";
    public $timestamps = false;
}
