<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoTransaction extends Model
{
    use HasFactory;
    protected $table = "logo_transaction"; // logo requeste ve response istekleri kayıt edilir.
    public $timestamps = false;
}
