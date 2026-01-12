<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tcbienes', function (Blueprint $table) {
            $table->id('id_bien');
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_maximo')->default(0);
            $table->timestamps();

            $table->foreign('id_unidad')->references('id_unidad')->on('tcunidades');
            $table->foreign('id_categoria')->references('id_categoria')->on('tccategorias');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tcbienes');
    }
};
