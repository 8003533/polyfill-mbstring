<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogos\Bien;

class Entrada extends Model
{
    use HasFactory;

    // 👇 Debe coincidir exactamente con el nombre de la tabla
    protected $table = 'taentradas';
    protected $primaryKey = 'id_entrada';
    public $timestamps = true;

    protected $fillable = [
        'id_bien',
        'cantidad',
        'fecha',
    ];

    /**
     * Relación con Bien
     * Una entrada pertenece a un bien
     */
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'id_bien', 'id_bien');
    }
}
