<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'tcunidades';
    protected $primaryKey = 'id_unidad';
    public $timestamps = false;

    protected $fillable = ['nombre','descripcion'];
}
