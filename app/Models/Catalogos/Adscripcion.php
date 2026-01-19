<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Model;

class Adscripcion extends Model
{
    protected $table = 'tcadscripciones';
    protected $primaryKey = 'iid_adscripcion';
    public $timestamps = false;

    public function tipoarea()
    {
        return $this->belongsTo(TipoArea::class, 'iid_tipo_area', 'iid_tipo_area');
    }
}
