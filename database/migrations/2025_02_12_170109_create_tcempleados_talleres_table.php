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
        Schema::create('tcempleados_talleres', function (Blueprint $table) {
            $table->increments('iid_empleado_taller');
            $table->string('cnombre_empleado_taller',50)->nullable();
            $table->string('cpaterno_empleado_taller',50)->nullable();
            $table->string('cmaterno_empleado_taller',50)->nullable();
            $table->integer('iid_adscripcion')->unsigned()->nullable();
            $table->integer('iid_puesto')->unsigned()->nullable();
            $table->integer('iid_taller')->unsigned()->nullable();
            $table->integer('iid_cuadrilla')->unsigned()->nullable();
            $table->string('ccorreo_electronico',150)->nullable();
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
        Schema::dropIfExists('tcempleados_talleres');
    }
};
