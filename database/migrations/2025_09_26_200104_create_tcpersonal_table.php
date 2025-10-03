<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tcpersonal', function (Blueprint $table) {
            $table->id('id_personal');
            $table->string('cnombre_personal');
            $table->string('cpaterno_personal');
            $table->string('cmaterno_personal')->nullable();
            $table->unsignedBigInteger('iid_puesto');
            $table->unsignedBigInteger('iid_adscripcion');
            $table->string('ccorreo_electronico')->nullable();
            $table->boolean('iestatus')->default(1);
            $table->unsignedBigInteger('iid_usuario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tcpersonal');
    }
};
