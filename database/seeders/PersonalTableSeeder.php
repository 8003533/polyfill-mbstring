<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use League\Csv\Reader;

class PersonalTableSeeder extends Seeder
{
    public function run(): void
    {
        if (!ini_get("auto_detect_line_endings")) {
            ini_set("auto_detect_line_endings", '1');     
        }

        $file = database_path('seeders/csv/PersonalM4.csv');
        $stream = fopen($file, 'r');

        $reader = Reader::createFromStream($stream)->setHeaderOffset(0);

        foreach ($reader as $row) {
            DB::table('tcpersonal')->insert([
                'cnombre_personal'     => utf8_encode($row['cnombre_personal']),
                'cpaterno_personal'    => utf8_encode($row['cpaterno_personal']),
                'cmaterno_personal'    => utf8_encode($row['cmaterno_personal']),
                'iid_puesto'           => $row['iid_puesto'],
                'iid_adscripcion'      => $row['iid_adscripcion'],
                'ccorreo_electronico'  => $row['ccorreo_electronico'],
                'iestatus'             => $row['iestatus'],
                'iid_usuario'          => $row['iid_usuario'],
                'created_at'           => Carbon::now(),
                'updated_at'           => Carbon::now(),
            ]);
        }
    }
}
