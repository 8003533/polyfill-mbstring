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
        Schema::create('tcedificios', function (Blueprint $table) {
            $table->increments('iid_edificio');
            $table->integer('iid_administracion')->unsigned()->nullable();
            $table->string('cnombre_edificio',100);
            $table->string('ccalle',100);
            $table->string('cnumero_exterior',50);
            $table->string('cnumero_interior',50)->nullable();
            $table->integer('iid_colonia');
            $table->integer('iid_alcaldia');
            $table->integer('iid_entidad');
            $table->string('cid_codigo_postal',5);
            $table->decimal('ilatitud',7,5)->nullable();
            $table->decimal('ilongitud',7,5)->nullable();
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
        Schema::dropIfExists('tcedificios');
    }
};
