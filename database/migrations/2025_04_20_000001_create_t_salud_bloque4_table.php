<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_salud_bloque4', function (Blueprint $table) {
            $table->string('tipo_documento', 50);
            $table->string('numero_documento', 50);
            // Pregunta 27: Sistema de salud
            $table->integer('sistema_salud')->nullable();
            // Pregunta 28: Enfermedad mental diagnosticada
            $table->integer('enfermedad_mental')->nullable();
            // Pregunta 29: Acceso a espacios recreativos/deportivos
            $table->integer('acceso_espacios_recreativos')->nullable();
            $table->integer('estado')->default(0);
            $table->timestamps();
            $table->primary(['tipo_documento', 'numero_documento']);
        });
    }
    public function down()
    {
        Schema::dropIfExists('t_salud_bloque4');
    }
};
