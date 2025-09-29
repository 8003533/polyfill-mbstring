<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tcbienes', function (Blueprint $table) {
            $table->id('id_bien');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->integer('stock_minimo')->default();
            $table->integer('stock_maximo')->default();
            $table->unsignedBigInteger('id_unidad');
            $table->unsignedBigInteger('id_categoria');
            $table->timestamps();

            //Llave foranea

            $table->foreign('id_unidad')->references('id_unidad')->on('tcunidades')->onDelete('cascade');
            $table->foreign('id_categoria')->references('id_categoria')->on('tccategorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tcbienes');
    }
};
