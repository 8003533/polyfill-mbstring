<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;
    protected $table = 'tctalleres';
    protected $primaryKey = 'iid_taller';

}
