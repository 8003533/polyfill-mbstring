<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('detalle_entrada', function (Blueprint $table) {
            $table->id('id_detalle_entrada');
            $table->unsignedBigInteger('id_entrada');
            $table->unsignedBigInteger('id_bien');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('id_entrada')
                ->references('id_entrada')
                ->on('tcentradas')
                ->onDelete('cascade');

            $table->foreign('id_bien')
                ->references('id_bien')
                ->on('tcbienes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalle_entrada');
    }
};
