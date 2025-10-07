<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    protected $table = 'tasalidas';
    protected $primaryKey = 'id_salida';
    public $timestamps = true;

    protected $fillable = [
        'fecha',
        'folio',
        'motivo',
    ];
}
