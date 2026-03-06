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
        Schema::create('taservicios', function (Blueprint $table) {

        //$table->bigIncrements('iid_servicio');
        $table->bigIncrements('iid_servicio');

            $table->integer('anio');
            $table->integer('consecutivo');
            $table->string('cfolio')->nullable();
            $table->unsignedBigInteger('iid_administracion')->nullable();
            $table->date('dfecha_solicitud')->nullable();
            $table->date('dfecha_conclusion')->nullable();
            $table->unsignedBigInteger('iid_personal_solicitante')->nullable();
            $table->text('cdescripcion_servicio')->nullable();
            $table->unsignedBigInteger('iid_taller')->nullable();
            $table->text('cobservaciones')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taservicios');

    }
};
