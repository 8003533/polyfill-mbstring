<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class PuestosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');     
        }   

        $csvPath = database_path('seeders/csv/PuestosM4.csv'); // ruta absoluta
        $stream = fopen($csvPath, 'r');

        $reader = Reader::createFromStream($stream)->setHeaderOffset(0);

        foreach ($reader as $row) {
            DB::table('tcpuestos')->updateOrInsert(
                ['cdescripcion_puesto' => utf8_encode($row['cdescripcion_puesto'])], // condición única
                [
                    'iestatus'    => $row['iestatus'] ?? 1,
                    'iid_usuario' => $row['iid_usuario'] ?? 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now(),
                ]
            );
        }
    }
}
