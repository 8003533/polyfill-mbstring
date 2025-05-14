<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $table = 'tcpuestos';
    protected $primaryKey = 'iid_puesto';

    public function personal(){
        return $this->belongsTo('App\Models\Catalogos\Personal');
    }

    public function empleado_taller(){
        return $this->belongsTo('App\Models\Catalogos\EmpladoTaller');
    }
}
