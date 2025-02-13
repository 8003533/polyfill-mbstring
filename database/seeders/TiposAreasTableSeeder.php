<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TiposAreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'JUZGADOS','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'SALAS','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'APOYO JUDICIAL','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'PRESIDENCIA','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'OFICIALÍA MAYOR','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'OTRA INSTITUCIÓN DE GOBIERNO','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'ORGANISMO NO GUBERNAMENTAL','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'EMPRESA PRIVADA','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctipos_areas')->insert(['cdescripcion_tipo_area'=>'NINGUNA','iestatus'=>'1','iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
