<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EdificiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //8889,9,6,06720
        DB::table('tcedificios')->insert(['iid_administracion'=>'1','cnombre_edificio'=>'Edificio Niños Héroes 119','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'119','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'2','cnombre_edificio'=>'Edificio Niños Héroes 132','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'132','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'2','cnombre_edificio'=>'Edificio Niños Héroes 133','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'133','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Edificio Niños Héroes 150','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'150','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'2','cnombre_edificio'=>'Edificio Claudio Bernard','ccalle'=>'Dr. Claudio Bernard','cnumero_exterior'=>'60','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
