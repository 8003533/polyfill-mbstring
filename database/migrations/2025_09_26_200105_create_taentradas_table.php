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
        Schema::create('taentradas', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->unsignedBigInteger('id_bien');
            $table->integer('cantidad');
            $table->date('fecha')->nullable();
            $table->timestamps();

            $table->foreign('id_bien')->references('id_bien')->on('tcbienes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('taentradas');
    }
};
