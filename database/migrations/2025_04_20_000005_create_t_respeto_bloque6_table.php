<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_respeto_bloque6', function (Blueprint $table) {
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->primary(['tipo_documento', 'numero_documento']);
            $table->unsignedTinyInteger('p33_acceso_metodos_anticonceptivos'); // Pregunta 33
            // Pregunta 34 (opción múltiple, cada campo 1/2)
            $table->unsignedTinyInteger('p34_ninos_adolescentes_adultos')->default(2);
            $table->unsignedTinyInteger('p34_ninos_adolescentes_adultos_mayores')->default(2);
            $table->unsignedTinyInteger('p34_jovenes_adultos')->default(2);
            $table->unsignedTinyInteger('p34_jovenes_adultos_mayores')->default(2);
            $table->unsignedTinyInteger('p34_adultos_adultos_mayores')->default(2);
            $table->unsignedTinyInteger('p34_nunca')->default(2);
            $table->unsignedTinyInteger('p34_no_sabe')->default(2);
            $table->unsignedTinyInteger('p34_no_aplica')->default(2);
            // Pregunta 35 (única respuesta)
            $table->unsignedTinyInteger('p35_orientacion_asesoria')->nullable();
            // Pregunta 36 (única respuesta)
            $table->unsignedTinyInteger('p36_calidad_comunicacion')->nullable();
            // Pregunta 37 (única respuesta)
            $table->unsignedTinyInteger('p37_medio_comunicacion')->nullable();
            // Pregunta 38 (única respuesta)
            $table->unsignedTinyInteger('p38_impacto_tecnologia')->nullable();
            // Pregunta 39 (única respuesta)
            $table->unsignedTinyInteger('p39_frecuencia_comidas')->nullable();
            $table->integer('estado')->default(0);
            $table->string('profesional_documento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_respeto_bloque6');
    }
};
