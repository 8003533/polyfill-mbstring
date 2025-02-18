<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadrilla extends Model
{
    use HasFactory;
    protected $table = 'tccuadrillas';
    protected $primaryKey = 'iid_cuadrilla';
}
