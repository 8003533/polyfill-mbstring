<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'tcareas';
    protected $primaryKey = 'id_areas';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
    ];
}
