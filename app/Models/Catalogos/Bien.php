<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';
    public $timestamps = false;

    // ajusta fillable si quieres
    protected $fillable = [
        'codigo',
        'stok_min',
        'stok_max',
    ];
}
