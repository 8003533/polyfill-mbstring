<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpleadoTaller extends Model
{
    use HasFactory;
    protected $table = 'tcempleados_talleres';
    protected $primaryKey = 'iid_empleado_taller';

    public function puesto(){
        return $this->hasOne('App\Models\Catalogos\Puesto','iid_puesto','iid_puesto');
    }

    public function adscripcion(){
        return $this->hasOne('App\Models\Catalogos\Adscripcion','iid_adscripcion','iid_adscripcion');
    }
    
    public function taller(){
        return $this->hasOne('App\Models\Catalogos\Taller','iid_taller','iid_taller');
    }

    public function cuadrilla(){
        return $this->hasOne('App\Models\Catalogos\Cuadrilla','iid_cuadrilla','iid_cuadrilla');
    }
}
