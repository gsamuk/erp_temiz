<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EsitW2 extends Model
{
    protected $table = 'EsitW2';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Scale',
        'seq',
        'seqnum1',
        'rec_type',
        'Plate',
        'TicketNo',
        'WeighTime1',
        'WeighTime2',
        'Weight1',
        'Weight2',
        'Net',
        'ManualTare',
        'FirmCode',
        'FirmName',
        'MaterialCode',
        'MaterialName',
    ];

    public $timestamps = false;
}