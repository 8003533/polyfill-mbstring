<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'tcproveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = ['nombre', 'contacto', 'telefono'];

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'id_proveedor', 'id_proveedor');
    }
}
