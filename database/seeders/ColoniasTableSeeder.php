<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        if (!ini_get("auto_detect_line_endings")) 
        {
            ini_set("auto_detect_line_endings", '1');     
        }   

        $readDirectory = 'database/seeders/csv/cat_colonias.csv';
        $stream = fopen($readDirectory, 'r');

        $reader = Reader::createFromStream($stream, 'r')->setHeaderOffset(0);
        // Indicamos el índice de la fila de nombres de columnas
        foreach ($reader as $r) {
            DB::table('tccolonias')->insert([
                'iid_colonia'       => $r['iidcolonia'],
                'iid_entidad'       => $r['iidentidad'],
                'iid_alcaldia'      => $r['iidalcaldia'],
                'cid_codigo_postal' => $r['iidcodigop'],
                'cnombre_colonia'   => utf8_decode(utf8_encode($r['cdescripcion'])),
                'iestatus'          => $r['iestatus'],         
                'created_at'        => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'        => Carbon::now()->format('Y-m-d H:i:s')
            ]);
          
        }
    }
}
