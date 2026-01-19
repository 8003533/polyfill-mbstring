<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'tcentradas';
    protected $primaryKey = 'id_entrada';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'id_proveedor',
        'tipo',
        'folio',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleEntrada::class, 'id_entrada', 'id_entrada');
    }
}
