<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasalidas', function (Blueprint $table) {
            $table->id('id_salida');
            $table->unsignedBigInteger('id_bien');
            $table->unsignedBigInteger('id_personal')->nullable();
            $table->integer('cantidad');
            $table->date('fecha')->nullable();
            $table->timestamps();


            //Llaves foraneas

            $table->foreign('id_bien')->references('id_bien')->on('tcbienes')->onDelete('cascade');
            $table->foreign('id_personal')->references('id_personal')->on('tcpersonal')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tasalidas');
    }
};
