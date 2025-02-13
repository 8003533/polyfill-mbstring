<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        Model::unguard();
        $this->call(AdministracionesTableSeeder::class);
        $this->call(AdscripcionesTableSeeder::class);
        $this->call(AlcaldiasTableSeeder::class);
        $this->call(CodigosPostalesTableSeeder::class);
        $this->call(ColoniasTableSeeder::class);
        $this->call(CuadrillasTableSeeder::class);
        $this->call(EdificiosTableSeeder::class);
        $this->call(EntidadesTableSeeder::class);
        $this->call(PersonalTableSeeder::class);
        $this->call(PuestosTableSeeder::class);
        $this->call(TalleresTableSeeder::class);
        $this->call(TiposAreasTableSeeder::class);
        $this->call(ParametrosTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        Model::reguard();
    }
}
