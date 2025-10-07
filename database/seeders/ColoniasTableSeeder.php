<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class ColoniasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Detectar finales de línea correctamente en CSV
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');     
        }   

        // Ruta absoluta del CSV
        $csvPath = database_path('seeders/csv/cat_colonias.csv');
        $stream = fopen($csvPath, 'r');

        // Crear lector CSV
        $reader = Reader::createFromStream($stream)->setHeaderOffset(0);

        foreach ($reader as $row) {
            // Insertar o actualizar sin duplicar PRIMARY KEY
            DB::table('tccolonias')->updateOrInsert(
                ['cnombre_colonia' => utf8_encode($row['cdescripcion'])], // Condición única
                [
                    'iid_entidad'       => $row['iidentidad'] ?? null,
                    'iid_alcaldia'      => $row['iidalcaldia'] ?? null,
                    'cid_codigo_postal' => $row['iidcodigop'] ?? null,
                    'iestatus'          => $row['iestatus'] ?? 1,
                    'created_at'        => Carbon::now(),
                    'updated_at'        => Carbon::now()
                ]
            );
        }
    }
}

