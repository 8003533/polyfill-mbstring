<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;
    protected $table = 'tccolonias';
    protected $primaryKey = 'iid_colonia';

    public function edificio(){
        return $this->belongsTo('App\Models\Catalogos\Edificio');
    }
}
