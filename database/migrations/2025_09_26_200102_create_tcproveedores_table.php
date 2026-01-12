<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tcproveedores', function (Blueprint $table) {
            $table->id('id_proveedor'); // id por defecto con nombre específico
            $table->string('nombre');
            $table->string('contacto')->nullable(); // correo o nombre contacto
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tcproveedores');
    }
};