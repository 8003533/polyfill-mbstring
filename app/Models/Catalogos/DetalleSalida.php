<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\Bien;
use App\Models\Catalogos\Salida;

class DetalleSalida extends Model
{
    use HasFactory;

    protected $table = 'tadetalle_salida';
    protected $primaryKey = 'id_detalle_salida';
    public $timestamps = true;

    protected $fillable = [
        'id_salida',
        'id_bien',
        'cantidad',
    ];

    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }

    public function salida()
    {
        return $this->belongsTo(Salida::class, 'id_salida', 'id_salida');
    }
}
