<?php

namespace App\Models\Suministros;

use Illuminate\Database\Eloquent\Model;

class Suministro extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'iid_bien'; // cambia si tu PK es otra

    protected $fillable = [
        'cnombre_bien',
        'cdescripcion',
        'istock'
    ];
}
