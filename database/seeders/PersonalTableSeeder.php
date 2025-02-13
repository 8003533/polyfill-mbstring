<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class PersonalTableSeeder extends Seeder
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

        $readDirectory = 'database/seeders/PersonalM4.csv';
        $stream = fopen($readDirectory, 'r');

        $reader = Reader::createFromStream($stream, 'r')->setHeaderOffset(0);
        // Indicamos el índice de la fila de nombres de columnas
        foreach ($reader as $r) {
            DB::table('tcpersonal')->insert([
                'iid_personal'              => $r['iid_personal'],
                'cnombre_personal'          => utf8_encode($r['cnombre_personal']),
                'cpaterno_personal'         => utf8_encode($r['cpaterno_personal']),
                'cmaterno_personal'         => utf8_encode($r['cmaterno_personal']),
                'iid_puesto'                => $r['iid_puesto'],
                'iid_adscripcion'           => $r['iid_adscripcion'],
                'ccorreo_electronico'       => $r['ccorreo_electronico'],
                'iestatus'                  => $r['iestatus'],
                'iid_usuario'               => $r['iid_usuario'],
                'created_at'                => Carbon::now()->format('Y-m-d H:i:s')
            ]);
          
        }
    }
}
