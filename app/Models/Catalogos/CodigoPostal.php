<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    use HasFactory;
    protected $table = 'tccodigos_postales';
    protected $primaryKey = 'cid_codigo_postal';

    public function edificio(){
        return $this->belongsTo('App\Models\Catalogos\Edificio');
    }
}
