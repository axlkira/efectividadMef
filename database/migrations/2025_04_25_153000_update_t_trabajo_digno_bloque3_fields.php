<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            // Pregunta 20: fuentes de ingreso
            $table->tinyInteger('fuente_empleo_formal')->default(2)->after('numero_documento');
            $table->tinyInteger('fuente_empleo_informal')->default(2)->after('fuente_empleo_formal');
            $table->tinyInteger('fuente_independiente')->default(2)->after('fuente_empleo_informal');
            $table->tinyInteger('fuente_apoyo_familia_amigos')->default(2)->after('fuente_independiente');
            $table->tinyInteger('fuente_pension')->default(2)->after('fuente_apoyo_familia_amigos');
            $table->tinyInteger('fuente_subsidios_gobierno')->default(2)->after('fuente_pension');
            $table->tinyInteger('fuente_ninguna')->default(2)->after('fuente_subsidios_gobierno');
            // Pregunta 26: tiempo patrimonio crisis
            $table->tinyInteger('tiempo_patrimonio_crisis')->nullable()->after('patrimonio');
            // Eliminar campo antiguo
            if (Schema::hasColumn('t_trabajo_digno_bloque3', 'fuente_ingreso')) {
                $table->dropColumn('fuente_ingreso');
            }
        });
    }
    public function down() {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->dropColumn([
                'fuente_empleo_formal',
                'fuente_empleo_informal',
                'fuente_independiente',
                'fuente_apoyo_familia_amigos',
                'fuente_pension',
                'fuente_subsidios_gobierno',
                'fuente_ninguna',
                'tiempo_patrimonio_crisis'
            ]);
            $table->tinyInteger('fuente_ingreso')->nullable();
        });
    }
};
