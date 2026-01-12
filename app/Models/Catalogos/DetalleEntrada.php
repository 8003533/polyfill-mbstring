<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleEntrada extends Model
{
    protected $table = 'tcdetalle_entrada';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_entrada',
        'id_bien',
        'cantidad'
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien');
    }
}
