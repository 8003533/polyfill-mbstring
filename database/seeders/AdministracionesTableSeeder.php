<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdministracionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Niños Héroes 119','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Niños Héroes 132','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Niños Héroes 150','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Plaza Juárez','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Sullivan 133','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Patriotismo','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Reclusorio Norte','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Reclusorio Oriente','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Reclusorio Sur','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcadministraciones')->insert(['cdescripcion_administracion'=>'Administración de Reclusorio Femenil Santa Martha','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
