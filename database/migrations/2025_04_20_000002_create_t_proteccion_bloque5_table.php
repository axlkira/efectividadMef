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
        Schema::create('t_proteccion_bloque5', function (Blueprint $table) {
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->primary(['tipo_documento', 'numero_documento']);
            $table->unsignedTinyInteger('p30_vivienda'); // int: opciones de vivienda
            $table->string('p30_vivienda_otro')->nullable(); // texto si eligen otro
            $table->unsignedTinyInteger('p31_migracion'); // int: migración por seguridad/calidad de vida
            $table->integer('estado')->default(0);
            $table->string('profesional_documento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_proteccion_bloque5');
    }
};
