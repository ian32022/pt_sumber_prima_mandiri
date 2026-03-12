<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesMfg extends Model
{
       protected $table = 'proses_mfg';

    protected $primaryKey = 'proses_id';

    protected $fillable = [
        'partlist_id',
        'mesin_id',
        'operator_id',
        'status',
        'waktu_mulai',
        'waktu_selesai'
    ];
}
