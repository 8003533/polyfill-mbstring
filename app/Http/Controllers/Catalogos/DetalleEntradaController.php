<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleEntrada extends Model
{
    protected $table = 'detalle_entrada';
    public $timestamps = false;

    // No hay id autoincremental (según el diagrama)
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = ['id_entrada', 'anio', 'id_bien', 'cantidad'];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'id_entrada', 'id_entrada');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}
