<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'tcusuarios';
    protected $primaryKey = 'iid_usuario';
    public $timestamps = false;
    //
}
