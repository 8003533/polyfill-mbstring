<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taservicios_empleados', function (Blueprint $table) {

            $table->increments('iid_servicio');

            // Folio (Ej: 2026/0052)
            $table->string('folio', 20)->unique();
            $table->integer('anio_folio');
            $table->integer('consecutivo_folio');

            // Fechas
            $table->dateTime('fecha_solicitud');
            $table->dateTime('conclusion')->nullable();

            // Datos del servicio
            $table->integer('iid_area');
            $table->integer('iid_solicitante');
            $table->integer('iid_taller');

            $table->text('descripcion_servicio');
            $table->text('observaciones')->nullable();

            // Asignación
            $table->enum('tipo_asignacion', ['personal','cuadrilla'])->default('personal');
            $table->integer('iid_cuadrilla')->nullable();

            // Empleado que atendió (si es personal)
            $table->integer('iid_empleado_taller')->nullable();

            $table->integer('iestatus')->default(1);
            $table->integer('iid_usuario')->nullable();

            $table->timestamps();

            $table->index('folio');
            $table->index('iid_area');
            $table->index('iid_solicitante');
            $table->index('iid_taller');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taservicios_empleados');
    }
};
