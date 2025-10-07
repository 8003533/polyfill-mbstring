<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'luis.ibarra@tsjcdmx.gob.mx'], // condición única
            [
                'name'       => 'Luis Ibarra',
                'password'   => bcrypt('sistemas'),
                'iid_rol'    => 1,
                'iestatus'   => 1,
                'iid_usuario'=> 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
    }
}
