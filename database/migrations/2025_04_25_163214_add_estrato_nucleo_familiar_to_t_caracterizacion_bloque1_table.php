<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstratoNucleoFamiliarToTCaracterizacionBloque1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->integer('estrato_nucleo_familiar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->dropColumn('estrato_nucleo_familiar');
        });
    }
}
