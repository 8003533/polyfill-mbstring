<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
    protected $table = 'tadetalle_salidas'; 
    protected $primaryKey = 'id_detalle_salida';
    public $timestamps = false;

    protected $fillable = [
        'id_salida',
        'id_bien',
        'cantidad_disponible',
        'cantidad_utilizada',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}
