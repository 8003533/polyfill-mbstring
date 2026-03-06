<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'taservicios';
    protected $primaryKey = 'iid_servicio';
    public $timestamps = true;

    protected $fillable = [
        'anio',
        'consecutivo',
        'cfolio',
        'iid_administracion',
        'dfecha_solicitud',
        'dfecha_conclusion',
        'iid_personal_solicitante',
        'cdescripcion_servicio',
        'iid_taller',
        'cobservaciones',
    ];
}
