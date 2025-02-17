<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;
    protected $table = 'tcentidades';
    protected $primaryKey = 'iid_entidad';

    public function edificio(){
        return $this->belongsTo('App\Models\Catalogos\Edificio');
    }
}
