<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tadetalle_salida', function (Blueprint $table) {
            $table->id('id_detalle_salida');

            $table->unsignedBigInteger('id_salida');
            $table->unsignedBigInteger('id_bien');

            $table->decimal('cantidad_disponible', 15, 3);
            $table->decimal('cantidad_utilizada', 15, 3);

            $table->timestamps();

            // FK CORRECTA A tasalidas
            $table->foreign('id_salida')
                ->references('id_salida')
                ->on('tasalidas')
                ->onDelete('cascade');

            // FK CORRECTA A tcbienes
            $table->foreign('id_bien')
                ->references('id_bien')
                ->on('tcbienes')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tadetalle_salida');
    }
};
