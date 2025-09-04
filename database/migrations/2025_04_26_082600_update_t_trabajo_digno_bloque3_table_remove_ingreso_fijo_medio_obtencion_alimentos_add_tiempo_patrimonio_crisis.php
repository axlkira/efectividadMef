<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->dropColumn(['ingreso_fijo', 'medio_obtencion_alimentos']);
        });
    }

    public function down()
    {
        Schema::table('t_trabajo_digno_bloque3', function (Blueprint $table) {
            $table->integer('ingreso_fijo')->nullable();
            $table->integer('medio_obtencion_alimentos')->nullable();
        });
    }
};
