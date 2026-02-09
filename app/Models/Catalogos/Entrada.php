<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'tcentradas';
    protected $primaryKey = 'id_entrada';

    protected $fillable = [
        'id_proveedor',
        'folio',
        'tipo',
        'fecha',
    ];

    // (Opcional) relación si después la ocupas
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleEntrada::class, 'id_entrada', 'id_entrada');
    }
}
