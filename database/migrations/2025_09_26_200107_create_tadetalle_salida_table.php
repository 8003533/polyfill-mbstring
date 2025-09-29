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
        Schema::create('tadetalle_salida', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_salida');
            $table->integer('cantidad');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('id_salida')->references('id_salida')->on('tasalidas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tadetalle_salida');
    }
};
