<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_derechos_bloque9', function (Blueprint $table) {
            $table->string('tipo_documento', 3);
            $table->string('numero_documento', 32);
            // Pregunta 46: opción múltiple (cada campo 1/2, máximo 5)
            $table->tinyInteger('p46_vida_libre_violencia')->default(2);
            $table->tinyInteger('p46_participacion_representacion')->default(2);
            $table->tinyInteger('p46_trabajo_digno')->default(2);
            $table->tinyInteger('p46_salud_seguridad')->default(2);
            $table->tinyInteger('p46_educacion_igualdad')->default(2);
            $table->tinyInteger('p46_recreacion_cultura')->default(2);
            $table->tinyInteger('p46_honra_dignidad')->default(2);
            $table->tinyInteger('p46_igualdad')->default(2);
            $table->tinyInteger('p46_armonia_unidad')->default(2);
            $table->tinyInteger('p46_proteccion_asistencia')->default(2);
            $table->tinyInteger('p46_entornos_seguros')->default(2);
            $table->tinyInteger('p46_decidir_hijos')->default(2);
            $table->tinyInteger('p46_orientacion_asesoria')->default(2);
            $table->tinyInteger('p46_respetar_formacion_hijos')->default(2);
            $table->tinyInteger('p46_respeto_reciproco')->default(2);
            $table->tinyInteger('p46_proteccion_patrimonio')->default(2);
            $table->tinyInteger('p46_alimentacion_necesidades')->default(2);
            $table->tinyInteger('p46_bienestar')->default(2);
            $table->tinyInteger('p46_apoyo_estado_mayores')->default(2);
            $table->tinyInteger('p46_ninguno_anteriores')->default(2);
            $table->tinyInteger('estado')->default(0);
            $table->string('profesional_documento', 32)->nullable();
            $table->primary(['tipo_documento', 'numero_documento']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_derechos_bloque9');
    }
};
