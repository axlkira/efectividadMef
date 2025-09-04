<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('t_vida_digna_bloque2', function (Blueprint $table) {
            $table->string('tipo_documento', 3);
            $table->string('numero_documento', 32);
            // Aquí irán los campos de las preguntas 15 a 19 (se agregarán después)
            $table->timestamps();
            $table->primary(['tipo_documento', 'numero_documento'], 'pk_vida_digna_bloque2');
        });
    }
    public function down() {
        Schema::dropIfExists('t_vida_digna_bloque2');
    }
};
