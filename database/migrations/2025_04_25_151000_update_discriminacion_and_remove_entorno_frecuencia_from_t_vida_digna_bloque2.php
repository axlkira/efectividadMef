<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('t_vida_digna_bloque2', function (Blueprint $table) {
            $table->tinyInteger('discriminacion_no_sabe')->default(2)->after('discriminacion_no_hemos');
            $table->dropColumn(['entorno_seguro', 'frecuencia_compartir']);
        });
    }
    public function down() {
        Schema::table('t_vida_digna_bloque2', function (Blueprint $table) {
            $table->dropColumn('discriminacion_no_sabe');
            $table->tinyInteger('entorno_seguro')->nullable();
            $table->tinyInteger('frecuencia_compartir')->nullable();
        });
    }
};
