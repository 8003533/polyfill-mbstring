<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTccategoriasTable extends Migration
{
    public function up()
    {
        Schema::create('tccategorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre', 50);
            $table->timestamps();
        });

        DB::table('tccategorias')->insert([
            ['nombre'=>'Cable'],
            ['nombre'=>'Computo'],
            ['nombre'=>'Muebles'],
            ['nombre'=>'Papelería'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('tccategorias');
    }
}
