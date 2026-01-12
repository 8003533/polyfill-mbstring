<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';
    protected $fillable = [
        'codigo', 'nombre', 'id_unidad', 'id_categoria', 'stock_minimo', 'stock_maximo'
    ];

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }
}

