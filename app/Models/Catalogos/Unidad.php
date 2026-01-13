<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'tcunidades';
    protected $primaryKey = 'id_unidad';

    protected $fillable = [
        'nombre',
        'abreviatura',
        'descripción'
    ];

    public $timestamps = false; 
}
