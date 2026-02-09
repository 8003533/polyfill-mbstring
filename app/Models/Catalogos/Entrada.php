<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'tcentradas';
    protected $primaryKey = 'id_entrada';

    protected $fillable = [
        'id_proveedor',
        'folio',
        'tipo',
        'fecha',
    ];
}
