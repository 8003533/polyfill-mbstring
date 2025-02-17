<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alcaldia extends Model
{
    use HasFactory;
    protected $table = 'tcalcaldias';
    protected $primaryKey = 'iid_alcaldia';

    public function edificio(){
        return $this->belongsTo('App\Models\Catalogos\Edificio');
    }
}
