<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BienesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tcbienes')->insert([
            [
                'codigo' => 'SUM001',
                'descripcion' => 'Papel Bond Carta',
                'id_unidad' => 1,
                'id_categoria' => 1,
                'stock_minimo' => 10,
                'stock_maximo' => 200,
                'existencia_local' => 100,
                'ultima_entrada' => now(),
                'ultima_salida' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'SUM002',
                'descripcion' => 'Tóner HP 12A',
                'id_unidad' => 2,
                'id_categoria' => 2,
                'stock_minimo' => 5,
                'stock_maximo' => 50,
                'existencia_local' => 20,
                'ultima_entrada' => now(),
                'ultima_salida' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'codigo' => 'SUM003',
                'descripcion' => 'Foco',
                'id_unidad' => 3,
                'id_categoria' => 3,
                'stock_minimo' => 5,
                'stock_maximo' => 50,
                'existencia_local' => 20,
                'ultima_entrada' => now(),
                'ultima_salida' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
