<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tcunidades', function (Blueprint $table) {
            $table->id('id_unidad');
            $table->string('nombre');
            $table->string('abreviatura')->nullable();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tcunidades');
    }
};
