<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->tinyInteger('tipo_documento');
            $table->string('numero_documento', 32);
            $table->string('profesional_documento', 32);
            $table->primary(['tipo_documento', 'numero_documento'], 'pk_tcb1');

            $table->tinyInteger('comuna_nucleo_familiar')->nullable();
            // Orientación sexual (múltiple)
            $table->tinyInteger('orientacion_lesbiana')->nullable();
            $table->tinyInteger('orientacion_gay')->nullable();
            $table->tinyInteger('orientacion_bisexual')->nullable();
            $table->tinyInteger('orientacion_pansexual')->nullable();
            $table->tinyInteger('orientacion_asexual')->nullable();
            $table->tinyInteger('orientacion_otra')->nullable();
            $table->string('orientacion_otra_cual', 128)->nullable();
            $table->tinyInteger('orientacion_prefiere_no_responder')->nullable();
            $table->tinyInteger('orientacion_no_aplica')->nullable();

            // Grupo etario (múltiple)
            $table->tinyInteger('grupo_primera_infancia')->nullable();
            $table->tinyInteger('grupo_jovenes')->nullable();
            $table->tinyInteger('grupo_adultos')->nullable();
            $table->tinyInteger('grupo_adultos_mayores')->nullable();

            $table->tinyInteger('familia_migrante')->nullable();
            $table->tinyInteger('grupo_etnico')->nullable();
            $table->tinyInteger('victima_conflicto')->nullable();

            // Hechos victimizantes (múltiple)
            $table->tinyInteger('hecho_homicidio')->nullable();
            $table->tinyInteger('hecho_desaparicion')->nullable();
            $table->tinyInteger('hecho_confinamiento')->nullable();
            $table->tinyInteger('hecho_desplazamiento')->nullable();
            $table->tinyInteger('hecho_tortura')->nullable();
            $table->tinyInteger('hecho_amenaza')->nullable();
            $table->tinyInteger('hecho_otro')->nullable();
            $table->string('hecho_otro_cual', 128)->nullable();
            $table->tinyInteger('hecho_no_aplica')->nullable();

            // Eliminar campo desplazado_conflicto
            $table->tinyInteger('nivel_educativo')->nullable();
            $table->tinyInteger('personas_nucleo')->nullable();
            $table->tinyInteger('config_familiar')->nullable();
            $table->tinyInteger('personas_aportan')->nullable();
            $table->tinyInteger('personas_cuidado')->nullable();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('t_caracterizacion_bloque1');
    }
};
