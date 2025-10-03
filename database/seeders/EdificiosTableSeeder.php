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
        DB::table('tcedificios')->insert(['iid_administracion'=>'1','cnombre_edificio'=>'Dr. Liceaga 113','ccalle'=>'Dr. Liceaga','cnumero_exterior'=>'113','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'2','cnombre_edificio'=>'Niños Héroes 119','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'119','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Niños Héroes 132','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'132','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Torre Norte','ccalle'=>'Dr. Claudio Bernard','cnumero_exterior'=>'82','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Torre Sur','ccalle'=>'Dr. Navarro','cnumero_exterior'=>'115','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Centro de Justicia Alternativa','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'133','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'4','cnombre_edificio'=>'Niños Héroes 150','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'150','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Dr. Claudio Bernard 60','ccalle'=>'Dr. Claudio Bernard','cnumero_exterior'=>'60','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'1','cnombre_edificio'=>'Instituto de Ciencias Forenses','ccalle'=>'Av. Niños Héroes','cnumero_exterior'=>'130','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8654,9,3,03800
        DB::table('tcedificios')->insert(['iid_administracion'=>'5','cnombre_edificio'=>'Patriotismo 230','ccalle'=>'Av. Patriotismo','cnumero_exterior'=>'230','iid_colonia'=>'8654','iid_alcaldia'=>'3','iid_entidad'=>'9','cid_codigo_postal'=>'03800','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'1','cnombre_edificio'=>'Dr. Lavista 114','ccalle'=>'Dr. Lavista','cnumero_exterior'=>'114','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8859,9,6,06010
        DB::table('tcedificios')->insert(['iid_administracion'=>'6','cnombre_edificio'=>'Clementina Gil de Léster','ccalle'=>'Av. Juárez','cnumero_exterior'=>'8','iid_colonia'=>'8859','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06010','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'6','cnombre_edificio'=>'Centro de Desarrollo Infantil "Gloría Ledúc de Agüero"','ccalle'=>'Av. Juárez','cnumero_exterior'=>'8','iid_colonia'=>'8859','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06010','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Centro de Desarrollo Infantil "José María Pino Suarez"','ccalle'=>'Dr. Navarro','cnumero_exterior'=>'100','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Centro de Desarrollo Infantil "Niños Héroes"','ccalle'=>'Dr. Navarro','cnumero_exterior'=>'202','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'6','cnombre_edificio'=>'Archivo - Delicias','ccalle'=>'Delicias','cnumero_exterior'=>'36','iid_colonia'=>'8859','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06000','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8895,9,6,06820
        DB::table('tcedificios')->insert(['iid_administracion'=>'6','cnombre_edificio'=>'Archivo - Fernando de Alva Ixtlilxochitl','ccalle'=>'Fernando de Alva Ixtlilxochitl','cnumero_exterior'=>'175','iid_colonia'=>'8895','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06820','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'3','cnombre_edificio'=>'Archivo - Dr. Navarro 180','ccalle'=>'Dr. Navarro','cnumero_exterior'=>'180','iid_colonia'=>'8889','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06720','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //10128,9,16,16800
        DB::table('tcedificios')->insert(['iid_administracion'=>'9','cnombre_edificio'=>'Reclusorio Preventivo Sur - Edificio Antiguo','ccalle'=>'Javier Piña y Palacios Esquina Martínez de Castro','cnumero_exterior'=>'S/N','iid_colonia'=>'10128','iid_alcaldia'=>'16','iid_entidad'=>'9','cid_codigo_postal'=>'16800','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'9','cnombre_edificio'=>'Reclusorio Preventivo Sur - Edificio Nuevo','ccalle'=>'Javier Piña y Palacios Esquina Martínez de Castro','cnumero_exterior'=>'S/N','iid_colonia'=>'10128','iid_alcaldia'=>'16','iid_entidad'=>'9','cid_codigo_postal'=>'16800','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8956,9,7,07210
        DB::table('tcedificios')->insert(['iid_administracion'=>'7','cnombre_edificio'=>'Reclusorio Preventivo Norte - Juzgados de Ejecución de Sanciones Penales','ccalle'=>'Jaime Nunó','cnumero_exterior'=>'175','iid_colonia'=>'8956','iid_alcaldia'=>'7','iid_entidad'=>'9','cid_codigo_postal'=>'07210','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //9350,9,9,09790
        DB::table('tcedificios')->insert(['iid_administracion'=>'8','cnombre_edificio'=>'Reclusorio Preventivo Oriente - Edificio Antiguo','ccalle'=>'Reforma','cnumero_exterior'=>'50','iid_colonia'=>'9350','iid_alcaldia'=>'9','iid_entidad'=>'9','cid_codigo_postal'=>'09790','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        DB::table('tcedificios')->insert(['iid_administracion'=>'8','cnombre_edificio'=>'Reclusorio Preventivo Oriente - Edificio Nuevo','ccalle'=>'Reforma','cnumero_exterior'=>'50','iid_colonia'=>'9350','iid_alcaldia'=>'9','iid_entidad'=>'9','cid_codigo_postal'=>'09790','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //9262,9,9,09510
        DB::table('tcedificios')->insert(['iid_administracion'=>'10','cnombre_edificio'=>'Reclusorio Preventivo Santa Martha Acatitla','ccalle'=>'Calzada Ermita Iztapalapa','cnumero_exterior'=>'S/N','iid_colonia'=>'9262','iid_alcaldia'=>'9','iid_entidad'=>'9','cid_codigo_postal'=>'09510','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8884,9,6,06470
        DB::table('tcedificios')->insert(['iid_administracion'=>'11','cnombre_edificio'=>'Sullivan 133','ccalle'=>'James Sullivan','cnumero_exterior'=>'133','iid_colonia'=>'8884','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06470','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        //8885,9,6,06500
        DB::table('tcedificios')->insert(['iid_administracion'=>'11','cnombre_edificio'=>'Río Lerma 62','ccalle'=>'Río Lerma','cnumero_exterior'=>'62','iid_colonia'=>'8885','iid_alcaldia'=>'6','iid_entidad'=>'9','cid_codigo_postal'=>'06500','iestatus'=>'1','created_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
