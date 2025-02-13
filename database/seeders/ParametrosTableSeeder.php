<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParametrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('parametros')->insert(['ianio'=>'2024','iultimo_folio'=>'0','cleyenda_anual_oficios'=>'"2024 Año de Felipe Carrillo Puerto, Benemérito del Proletariado, Revolucionario y Defensor del Mayab"','iestatus'=>1,'iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('parametros')->insert(['ianio'=>'2025','iultimo_folio'=>'0','cleyenda_anual_oficios'=>'"2024 Año de la Mujer Indígena"','iestatus'=>1,'iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
