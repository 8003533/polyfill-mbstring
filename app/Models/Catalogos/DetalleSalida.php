<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
    protected $table = 'detalle_salida';
    protected $primaryKey = 'id_detalle_salida';

    protected $fillable = [
        'id_salida',
        'id_bien',
        'cantidad_disponible',
        'cantidad_utilizada'
    ];

    public function salida()
    {
        return $this->belongsTo(Salida::class, 'id_salida');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }
}
