<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administracion extends Model
{
    use HasFactory;
    protected $table = 'tcadministraciones';
    protected $primaryKey = 'iid_administracion';

    public function edificio(){
        return $this->belongsTo('App\Models\Catalogos\Edificio');
    }
}
