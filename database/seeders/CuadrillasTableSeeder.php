<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CuadrillasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Albañilería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Carpintería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Cerrajería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Herrería','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Pintura','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tccuadrillas')->insert(['cnombre_cuadrilla'=>'Cuadrilla de Tablarroca','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
