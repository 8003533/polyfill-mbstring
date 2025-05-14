<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArea extends Model
{
    use HasFactory;
    protected $table = 'tctipos_areas';
    protected $primaryKey = 'iid_tipo_area';

    public function adscripcion(){
        return $this->belongsTo('App\Models\Catalogos\Adscripcion');
    }
}
