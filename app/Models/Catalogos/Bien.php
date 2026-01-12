<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';

    protected $fillable = [
        'id_categoria',
        'codigo',
        'nombre',
        'id_unidad',
        'stock_min',
        'stock_max'
    ];
}
