<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TalleresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Alfombras','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Carpintería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Cerrajería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Cortinas','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Electricidad','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Herrería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Intendencia','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Jardinería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Pintura','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Plomería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Telefonía','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Aparatos Electrodomésticos','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Relojes Checadores y Fechadores','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Cajas Fuertes','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Conmutadores','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Equipo contra Incendio','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Equipo de Fumigación','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Equipo Hidráulico','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Elevadores','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Equipo de Refrigeración y Ventilación','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Faxes','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Fotocopiadoras','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Limpieza exterior de Vidrios','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Máquinas de Escribir','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Plantas de Emergencia','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Pulidoras y Aspiradoras','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Seguridad y Vigilancia','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Ventiladores','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Tablarroca','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Pantalla de Rayos X','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tctalleres')->insert(['cdescripcion_taller'=>'Arcos Detectores de Metales','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
