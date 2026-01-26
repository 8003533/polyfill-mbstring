<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleEntrada extends Model
{
    protected $table = 'detalle_entrada';
    public $timestamps = false;

    // si NO tienes id autoincrement, NO pongas primaryKey
    // si sí tienes uno, ponlo aquí.
    // protected $primaryKey = 'id_detalle_entrada';

    protected $fillable = [
        'id_entrada',
        'anio',
        'id_bien',
        'cantidad',
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'id_entrada', 'id_entrada');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}
