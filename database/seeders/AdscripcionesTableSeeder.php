<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class AdscripcionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Detectar correctamente finales de línea en CSV
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');     
        }   

        $csvPath = database_path('seeders/csv/AreasM4.csv'); // ruta absoluta recomendada
        $stream = fopen($csvPath, 'r');

        $reader = Reader::createFromStream($stream)->setHeaderOffset(0);

        foreach ($reader as $row) {
            // Usamos updateOrInsert para evitar duplicados
            DB::table('tcadscripciones')->updateOrInsert(
                ['cdescripcion_adscripcion' => utf8_encode($row['cdescripcion_adscripcion'])], // condición única
                [
                    'csiglas' => isset($row['csiglas']) ? $row['csiglas'] : null,
                    'iid_tipo_area' => isset($row['iid_tipo_area']) ? $row['iid_tipo_area'] : 9,
                    'iestatus' => $row['iestatus'] ?? 1,
                    'iid_usuario' => $row['iid_usuario'] ?? 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
