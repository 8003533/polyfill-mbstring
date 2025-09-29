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
        Schema::create('tcpersonal', function (Blueprint $table) {
            $table->id('id_personal');
            $table->string('nombre');
            $table->string('puesto');
            $table->unsignedBigInteger('id_area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tcpersonal');
    }
};
