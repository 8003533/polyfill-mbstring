<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EntidadesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Aguascalientes','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Baja California','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Baja California Sur','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Campeche','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Chiapas','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Chihuahua','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Coahuila','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Colima','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Ciudad de México','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Durango','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Estado de México','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Guanajuato','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Guerrero','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Hidalgo','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Jalisco','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Michoacán','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Morelos','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Nayarit','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Nuevo León','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Oaxaca','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Puebla','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Querétaro','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Quintana Roo','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'San Luis Potosí','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Sinaloa','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Sonora','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Tabasco','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Tamaulipas','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Tlaxcala','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Veracruz','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Yucatán','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcentidades')->insert(['cnombre_entidad'=>'Zacatecas','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
