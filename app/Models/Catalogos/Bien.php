<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';

    protected $fillable = [
        'codigo','nombre','id_unidad','id_categoria','stock_min','stock_max'
    ];
}
