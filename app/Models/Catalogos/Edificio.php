<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory;
    protected $table = 'tcedificios';
    protected $primaryKey = 'iid_edificio';

    public function administracion(){
        return $this->hasOne('App\Models\Catalogos\Administracion','iid_administracion','iid_administracion');
    }

    public function colonia(){
        return $this->hasOne('App\Models\Catalogos\Colonia','iid_colonia','iid_colonia');
    }
    
    public function alcaldia(){
        return $this->hasOne('App\Models\Catalogos\Alcaldia','iid_alcaldia','iid_alcaldia');
    }

    public function entidad(){
        return $this->hasOne('App\Models\Catalogos\Entidad','iid_entidad','iid_entidad');
    }

    public function codigo_postal(){
        return $this->hasOne('App\Models\Catalogos\CodigoPostal','cid_codigo_postal','cid_codigo_postal');
    }
}
