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
        Schema::create('tccategorias', function (Blueprint $table) {
            $table->id('id_categoria');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            //foranea

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tccategorias');
    }
};
