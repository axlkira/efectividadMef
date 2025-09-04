<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('t_representacion_bloque8', function (Blueprint $table) {
            $table->string('tipo_documento', 3);
            $table->string('numero_documento', 32);
            $table->integer('p44_participacion_decisiones')->nullable(); // Única respuesta
            // Eliminada columna p45_jefatura_familia
            $table->tinyInteger('estado')->default(0);
            $table->string('profesional_documento', 32)->nullable();
            $table->primary(['tipo_documento', 'numero_documento']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('t_representacion_bloque8');
    }
};
