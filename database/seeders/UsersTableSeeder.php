<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert(['name'=>'Luis Ibarra','email'=>'luis.ibarra@tsjcdmx.gob.mx','password'=>bcrypt('sistemas'),'iid_rol'=>1,'iestatus'=>1,'iid_usuario'=>1,'created_at'=>Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
