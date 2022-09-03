<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsitW1 extends Model
{
    protected $table = 'EsitW1';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Scale',
        'seq',
        'rec_type',
        'Plate',
        'TicketNo',
        'WeighTime1',
        'Weight1',
        'FirmCode',
        'FirmName',
        'MaterialCode',
        'MaterialName',
    ];

    public $timestamps = false;
}