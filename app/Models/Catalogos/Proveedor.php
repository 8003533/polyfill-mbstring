<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'tcproveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = true;

    protected $fillable = [
        'id_proveedor',
        'nombre',
        'telefono',
        'direccion',

    ];

    public function entradas()
    {
        return $this->hasMany(\App\Models\Catalogos\Proveedor::class, 'id_proveedor');
    }
}
