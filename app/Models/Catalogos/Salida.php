<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table = 'tasalidas';
    protected $primaryKey = 'id_salida';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'folio',
        'motivo',
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleSalida::class, 'id_salida', 'id_salida');
    }
}
