<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('t_vida_digna_bloque2', function (Blueprint $table) {
            // Pregunta 15: Violencias (múltiple)
            $table->tinyInteger('violencia_sexual')->default(2); // 1=Sí, 2=No
            $table->tinyInteger('violencia_genero')->default(2);
            $table->tinyInteger('violencia_psicologica')->default(2);
            $table->tinyInteger('violencia_fisica')->default(2);
            $table->tinyInteger('violencia_economica')->default(2);
            $table->tinyInteger('violencia_ninguna')->default(2);

            // Pregunta 16: Entorno seguro (única)
            $table->tinyInteger('entorno_seguro')->nullable(); // 1=Sí, 2=No, 92=No responde

            // Pregunta 17: Discriminación (múltiple)
            $table->tinyInteger('discriminacion_sexo')->default(2);
            $table->tinyInteger('discriminacion_genero')->default(2);
            $table->tinyInteger('discriminacion_etnia')->default(2);
            $table->tinyInteger('discriminacion_nacionalidad')->default(2);
            $table->tinyInteger('discriminacion_estrato')->default(2);
            $table->tinyInteger('discriminacion_edad')->default(2);
            $table->tinyInteger('discriminacion_religion')->default(2);
            $table->tinyInteger('discriminacion_discapacidad')->default(2);
            $table->tinyInteger('discriminacion_otros')->default(2);
            $table->tinyInteger('discriminacion_no_hemos')->default(2);

            // Pregunta 18: Frecuencia compartir (única)
            $table->tinyInteger('frecuencia_compartir')->nullable(); // 103,104,105,106

            // Pregunta 19: Instituciones violencia intrafamiliar (múltiple)
            $table->tinyInteger('institucion_cavif')->default(2);
            $table->tinyInteger('institucion_ips_eps')->default(2);
            $table->tinyInteger('institucion_fiscalia')->default(2);
            $table->tinyInteger('institucion_linea_155')->default(2);
            $table->tinyInteger('institucion_comisaria')->default(2);
            $table->tinyInteger('institucion_inspeccion')->default(2);
            $table->tinyInteger('institucion_icbf')->default(2);
            $table->tinyInteger('institucion_caivas')->default(2);
            $table->tinyInteger('institucion_personeria')->default(2);
            $table->tinyInteger('institucion_centros_integrales')->default(2);
            $table->tinyInteger('institucion_no_hemos_asistido')->default(2);
        });
    }
    public function down() {
        Schema::table('t_vida_digna_bloque2', function (Blueprint $table) {
            $table->dropColumn([
                'violencia_sexual','violencia_genero','violencia_psicologica','violencia_fisica','violencia_economica','violencia_ninguna',
                'entorno_seguro',
                'discriminacion_sexo','discriminacion_genero','discriminacion_etnia','discriminacion_nacionalidad','discriminacion_estrato','discriminacion_edad','discriminacion_religion','discriminacion_discapacidad','discriminacion_otros','discriminacion_no_hemos',
                'frecuencia_compartir',
                'institucion_cavif','institucion_ips_eps','institucion_fiscalia','institucion_linea_155','institucion_comisaria','institucion_inspeccion','institucion_icbf','institucion_caivas','institucion_personeria','institucion_centros_integrales','institucion_no_hemos_asistido',
            ]);
        });
    }
};
