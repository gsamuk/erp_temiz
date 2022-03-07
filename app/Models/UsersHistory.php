<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersHistory extends Model
{
    use HasFactory;
    protected $table = "usersHistory";
    public $timestamps = false;
}
