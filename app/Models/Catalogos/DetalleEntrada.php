<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class DetalleEntrada extends Model
{
    protected $table = 'tadetalle_entrada';
    protected $primaryKey = 'id_detalle_entrada'; // si tu PK se llama distinto, cámbialo

    protected $fillable = [
        'id_entrada',
        'id_bien',
        'cantidad',
    ];

    // (Opcional)
    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'id_entrada', 'id_entrada');
    }

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}
