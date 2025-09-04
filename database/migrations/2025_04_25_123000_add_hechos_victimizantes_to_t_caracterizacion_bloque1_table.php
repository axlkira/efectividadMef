<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_homicidio')) $table->tinyInteger('hecho_homicidio')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_desaparicion')) $table->tinyInteger('hecho_desaparicion')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_confinamiento')) $table->tinyInteger('hecho_confinamiento')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_desplazamiento')) $table->tinyInteger('hecho_desplazamiento')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_tortura')) $table->tinyInteger('hecho_tortura')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_amenaza')) $table->tinyInteger('hecho_amenaza')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_despojo')) $table->tinyInteger('hecho_despojo')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_secuestro')) $table->tinyInteger('hecho_secuestro')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_vinculacion')) $table->tinyInteger('hecho_vinculacion')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_perdida_bienes')) $table->tinyInteger('hecho_perdida_bienes')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_minas')) $table->tinyInteger('hecho_minas')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_lesiones_psicologicas')) $table->tinyInteger('hecho_lesiones_psicologicas')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_lesiones_fisicas')) $table->tinyInteger('hecho_lesiones_fisicas')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_s4ecuestro')) $table->tinyInteger('hecho_s4ecuestro')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_terrorismo')) $table->tinyInteger('hecho_terrorismo')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_delitos_sexuales')) $table->tinyInteger('hecho_delitos_sexuales')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_otro')) $table->tinyInteger('hecho_otro')->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_otro_cual')) $table->string('hecho_otro_cual', 128)->nullable();
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'hecho_no_aplica')) $table->tinyInteger('hecho_no_aplica')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->dropColumn([
                'hecho_homicidio',
                'hecho_desaparicion',
                'hecho_confinamiento',
                'hecho_desplazamiento',
                'hecho_tortura',
                'hecho_amenaza',
                'hecho_despojo',
                'hecho_secuestro',
                'hecho_vinculacion',
                'hecho_perdida_bienes',
                'hecho_minas',
                'hecho_lesiones_psicologicas',
                'hecho_lesiones_fisicas',
                'hecho_s4ecuestro',
                'hecho_terrorismo',
                'hecho_delitos_sexuales',
                'hecho_otro',
                'hecho_otro_cual',
                'hecho_no_aplica',
            ]);
        });
    }
};
