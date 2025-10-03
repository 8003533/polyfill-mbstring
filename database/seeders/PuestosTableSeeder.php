<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        if (!ini_get("auto_detect_line_endings")) 
        {
            ini_set("auto_detect_line_endings", '1');     
        }   

        $readDirectory = 'database/seeders/csv/PuestosM4.csv';
        $stream = fopen($readDirectory, 'r');

        $reader = Reader::createFromStream($stream, 'r')->setHeaderOffset(0);
        // Indicamos el índice de la fila de nombres de columnas
        foreach ($reader as $r) {
            DB::table('tcpuestos')->insert([
                'iid_puesto'            => $r['iid_puesto'],
                'cdescripcion_puesto'   => utf8_encode($r['cdescripcion_puesto']),
                'iestatus'              => $r['iestatus'],
                'iid_usuario'           => $r['iid_usuario'],
                'created_at'            => Carbon::now()->format('Y-m-d H:i:s')
            ]);
          
        }
    }
}
