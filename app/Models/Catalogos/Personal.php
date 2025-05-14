<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;
    protected $table = 'tcpersonal';
    protected $primaryKey = 'iid_personal';

    public function puesto(){
        return $this->hasOne('App\Models\Catalogos\Puesto','iid_puesto','iid_puesto');
    }

    public function adscripcion(){
        return $this->hasOne('App\Models\Catalogos\Adscripcion','iid_adscripcion','iid_adscripcion');
    }
}
