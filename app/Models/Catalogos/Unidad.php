<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $table = 'tcunidades';
    protected $primaryKey = 'id_unidad';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'abreviatura',
        'descripcion'
    ];
}
