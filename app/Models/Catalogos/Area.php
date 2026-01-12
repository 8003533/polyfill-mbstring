<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'tcareas'; // tabla
    protected $primaryKey = 'id'; // ID 
    public $timestamps = true;

    protected $fillable = [
        'nombre'
    ];
}
