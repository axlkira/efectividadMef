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
        Schema::table('t_proteccion_bloque5', function (Blueprint $table) {
            $table->tinyInteger('red_apoyo_estado')->default(0);
            $table->tinyInteger('red_apoyo_organizaciones_internacionales')->default(0);
            $table->tinyInteger('red_apoyo_organizaciones_no_gubernamentales')->default(0);
            $table->tinyInteger('red_apoyo_iglesia')->default(0);
            $table->tinyInteger('red_apoyo_amigos')->default(0);
            $table->tinyInteger('red_apoyo_vecinos')->default(0);
            $table->tinyInteger('red_apoyo_otros_familiares')->default(0);
            $table->tinyInteger('red_apoyo_otros')->default(0);
            $table->tinyInteger('red_apoyo_no_hemos_tenido')->default(0);
            $table->tinyInteger('red_apoyo_no_aplica')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_proteccion_bloque5', function (Blueprint $table) {
            $table->dropColumn([
                'red_apoyo_estado',
                'red_apoyo_organizaciones_internacionales',
                'red_apoyo_organizaciones_no_gubernamentales',
                'red_apoyo_iglesia',
                'red_apoyo_amigos',
                'red_apoyo_vecinos',
                'red_apoyo_otros_familiares',
                'red_apoyo_otros',
                'red_apoyo_no_hemos_tenido',
                'red_apoyo_no_aplica',
            ]);
        });
    }
};
