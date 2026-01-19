<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';
    public $timestamps = false;

    protected $fillable = ['codigo', 'unidad_de_medida', 'stock_min', 'stock_max'];

    public function detallesEntrada()
    {
        return $this->hasMany(DetalleEntrada::class, 'id_bien', 'id_bien');
    }
}
