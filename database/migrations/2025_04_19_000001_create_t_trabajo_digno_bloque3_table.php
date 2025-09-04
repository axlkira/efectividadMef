<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 50);
            // Pregunta 20
            $table->tinyInteger('fuente_ingreso')->nullable();
            // Pregunta 21
            $table->tinyInteger('ingreso_fijo')->nullable();
            // Pregunta 22
            $table->tinyInteger('equilibrio_vida_laboral')->nullable();
            // Pregunta 23
            $table->tinyInteger('interfiere_cuidado')->nullable();
            // Pregunta 24
            $table->tinyInteger('trabajos_domesticos_impiden')->nullable();
            // Pregunta 25
            $table->tinyInteger('medio_obtencion_alimentos')->nullable();
            // Pregunta 26
            $table->tinyInteger('patrimonio')->nullable();
            $table->tinyInteger('estado')->default(0);
            $table->timestamps();
            $table->unique(['tipo_documento', 'numero_documento']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_trabajo_digno_bloque3');
    }
};
