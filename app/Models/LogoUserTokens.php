<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogoUserTokens extends Model
{
    protected $table = 'logo_user_tokens';
    protected $primaryKey = 'id';

    protected $fillable = ['access_token', 'user_id', 'firma_id', 'refresh_token', 'expires_in'];
}
