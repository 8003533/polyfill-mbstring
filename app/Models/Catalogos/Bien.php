<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'id_unidad',
        'id_categoria',
        'stock_min',
        'stock_max'
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
