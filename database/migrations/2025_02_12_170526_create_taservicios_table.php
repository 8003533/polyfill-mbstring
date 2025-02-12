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
            $table->increments('iid_servicio');
            $table->string('cfolio',10);
            $table->integer('iid_administracion');
            $table->dateTime('dfecha_solicitud', precision: 0);
            $table->dateTime('dfecha_conclusion', precision: 0);
            $table->integer('iid_personal_solicitante');
            $table->string('cdescripcion_servicio',500);
            $table->integer('iid_taller');
            $table->integer('iid_cuadrilla')->unsigned()->nullable();
            $table->string('cobservaciones',500);
            $table->integer('iestatus')->default(1);
            $table->integer('iid_usuario')->nullable();
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
