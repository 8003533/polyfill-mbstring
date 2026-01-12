<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tcentradas', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->date('fecha');
            $table->unsignedBigInteger('id_proveedor');
            $table->string('tipo');
            $table->string('folio')->nullable();   // ← CAMPO NECESARIO
            $table->timestamps();

            $table->foreign('id_proveedor')
                ->references('id_proveedor')
                ->on('tcproveedores');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tcentradas');
    }
};
