<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogoConsumpFicheDetail extends Model
{
    protected $primaryKey = 'logicalref';
    protected $table = 'lv_consump_fiche_detail'; // 1 nolu firmanın verileri gelir
}
