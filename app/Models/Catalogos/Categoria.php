<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'tccategorias';
    protected $primaryKey = 'id_categoria';
    protected $fillable = ['nombre'];
}
