<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PersonalTableSeeder::class,
            AdministracionesTableSeeder::class,
            AdscripcionesTableSeeder::class,
            AlcaldiasTableSeeder::class,
            CodigosPostalesTableSeeder::class,
            ColoniasTableSeeder::class,
            CuadrillasTableSeeder::class,
            EdificiosTableSeeder::class,
            EntidadesTableSeeder::class,
            PuestosTableSeeder::class,
            TalleresTableSeeder::class,
            TiposAreasTableSeeder::class,
            ParametrosTableSeeder::class,
            UsersTableSeeder::class,
        ]);

        Model::reguard(); // Este va afuera del array
    }
}

