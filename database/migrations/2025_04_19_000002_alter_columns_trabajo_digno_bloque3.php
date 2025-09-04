<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->integer('fuente_ingreso')->change();
            $table->integer('ingreso_fijo')->change();
            $table->integer('equilibrio_vida_laboral')->change();
            $table->integer('interfiere_cuidado')->change();
            $table->integer('trabajos_domesticos_impiden')->change();
            $table->integer('medio_obtencion_alimentos')->change();
            $table->integer('patrimonio')->change();
        });
    }
    public function down()
    {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->tinyInteger('fuente_ingreso')->change();
            $table->tinyInteger('ingreso_fijo')->change();
            $table->tinyInteger('equilibrio_vida_laboral')->change();
            $table->tinyInteger('interfiere_cuidado')->change();
            $table->tinyInteger('trabajos_domesticos_impiden')->change();
            $table->tinyInteger('medio_obtencion_alimentos')->change();
            $table->tinyInteger('patrimonio')->change();
        });
    }
};
