<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_participacion_bloque7', function (Blueprint $table) {
            $table->string('tipo_documento', 3);
            $table->string('numero_documento', 32);
            $table->integer('p40_igualdad_oportunidades')->nullable(); // Única respuesta
            $table->integer('p41_valoracion_posturas')->nullable(); // Única respuesta
            $table->integer('p42_trabajos_cuidado')->nullable(); // Única respuesta
            // Pregunta 43: opción múltiple (cada campo 1/2)
            $table->tinyInteger('p43_subsidios_economicos')->default(2);
            $table->tinyInteger('p43_acceso_centros_cuidado')->default(2);
            $table->tinyInteger('p43_atencion_medica')->default(2);
            $table->tinyInteger('p43_capacitacion_cuidadores')->default(2);
            $table->tinyInteger('p43_paquetes_alimentarios')->default(2);
            $table->tinyInteger('p43_redes_apoyo_cuidadores')->default(2);
            $table->tinyInteger('p43_incentivos_economicos')->default(2);
            $table->tinyInteger('p43_ninguno')->default(2);
            $table->tinyInteger('p43_no_aplica')->default(2);
            $table->tinyInteger('estado')->default(0);
            $table->string('profesional_documento', 32)->nullable();
            $table->primary(['tipo_documento', 'numero_documento']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_participacion_bloque7');
    }
};
