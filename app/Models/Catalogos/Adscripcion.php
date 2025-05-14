<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adscripcion extends Model
{
    use HasFactory;
    protected $table = 'tcadscripciones';
    protected $primaryKey = 'iid_adscripcion';

    public function personal(){
        return $this->belongsTo('App\Models\Catalogos\Personal');
    }

    public function empleado_taller(){
        return $this->belongsTo('App\Models\Catalogos\EmpladoTaller');
    }

    public function tipoarea(){
        return $this->hasOne('App\Models\Catalogos\TipoArea','iid_tipo_area','iid_tipo_area');
    }
}
