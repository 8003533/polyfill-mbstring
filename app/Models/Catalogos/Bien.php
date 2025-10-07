<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\Unidad;
use App\Models\Catalogos\Categoria;
use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\DetalleEntrada;
use App\Models\Catalogos\DetalleSalida;

class Bien extends Model
{
    use HasFactory;

    protected $table = 'tcbienes';
    protected $primaryKey = 'id_bien';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'stock_minimo',
        'stock_maximo',
        'id_unidad',
        'id_categoria',
    ];

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad', 'id_unidad');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function entradas()
    {
        return $this->hasMany(Entrada::class, 'id_bien', 'id_bien');
    }

    public function detallesEntrada()
    {
        return $this->hasMany(DetalleEntrada::class, 'id_bien', 'id_bien');
    }

    public function detallesSalida()
    {
        return $this->hasMany(DetalleSalida::class, 'id_bien', 'id_bien');
    }
}
