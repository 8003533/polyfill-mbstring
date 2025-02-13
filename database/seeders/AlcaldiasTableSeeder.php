<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AlcaldiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Álvaro Obregón','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Azcapotzalco','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Benito Juárez','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Coyoacán','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Cuajimalpa','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Cuauhtémoc','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Gustavo A. Madero','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Iztacalco','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Iztapalapa','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Magdalena Contreras','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Miguel Hidalgo','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Milpa Alta','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Tláhuac','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Tlalpan','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Venustiano Carranza','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcalcaldias')->insert(['cnombre_alcaldia'=>'Xochimilco','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
