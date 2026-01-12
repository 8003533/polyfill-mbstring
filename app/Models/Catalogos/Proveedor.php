<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'tcproveedores';
    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'nombre',
        'contacto',
        'direccion',
        'telefono'
    ];
}
