<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesServicio extends Model
{
    use HasFactory;
    protected $table = 'taservicios';
    protected $primaryKey = 'iid_servicio';

    public function administracion(){
        return $this->hasOne('App\Models\Catalogos\Administracion','iid_administracion','iid_administracion');
    }

    public function personal_solicitante(){
        return $this->hasOne('App\Models\Catalogos\Personal','iid_personal','iid_personal_solicitante');
    }
    
    public function taller(){
        return $this->hasOne('App\Models\Catalogos\Taller','iid_taller','iid_taller');
    }

    public function cuadrilla(){
        return $this->hasOne('App\Models\Catalogos\Cuadrilla','iid_cuadrilla','iid_cuadrilla');
    }


}
