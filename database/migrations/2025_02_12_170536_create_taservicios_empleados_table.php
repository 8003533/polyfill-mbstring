<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('taservicio_empleados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('iid_servicio');
            $table->unsignedBigInteger('iid_personal');
            $table->timestamps();

            $table->foreign('iid_servicio')->references('iid_servicio')->on('taservicios')->onDelete('cascade');
            $table->foreign('iid_personal')->references('iid_personal')->on('tcpersonal')->onDelete('cascade');

            $table->unique(['iid_servicio', 'iid_personal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taservicio_empleados');
    }
};
