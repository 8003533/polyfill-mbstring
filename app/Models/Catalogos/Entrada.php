<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $table = 'tcentradas';
    protected $primaryKey = 'id_entrada';
    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'fecha_entrada'
    ];

    protected $casts = [
        'fecha_entrada' => 'date'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleEntrada::class, 'id_entrada');
    }
}
