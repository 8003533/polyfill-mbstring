<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\Adscripcion;
use App\Models\Catalogos\Usuario;
use App\Models\User;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'tcpersonal';
    protected $primaryKey = 'id_personal';
    public $timestamps = true;

    protected $fillable = [
        'cnombre_personal',
        'cpaterno_personal',
        'cmaterno_personal',
        'iid_puesto',
        'iid_adscripcion',
        'ccorreo_electronico',
        'iestatus',
        'iid_usuario',
    ];

    // Relación con Adscripción
    public function adscripcion()
    {
        return $this->belongsTo(Adscripcion::class, 'iid_adscripcion');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'iid_usuario');
    }

    // Relación con Salidas
    public function salidas()
    {
        return $this->hasMany(\App\Models\Catalogos\Salida::class, 'id_personal');
    }
}
