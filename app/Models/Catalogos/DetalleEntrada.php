<?php

namespace App\Models;
namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entrada;

class DetalleEntrada extends Model
{
    use HasFactory;

    protected $table = 'tadetalle_entrada';
    protected $primaryKey = 'id_detalle';
    public $timestamps = true;

    protected $fillable = [
        'id_entrada',
        'cantidad',
        'descripcion',
    ];

    public function entrada()
    {
        return $this->belongsTo(Entrada::class, 'id_entrada');
    }
}
