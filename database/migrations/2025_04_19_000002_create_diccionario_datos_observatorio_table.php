<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('t_diccionario_datos_observatorio', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('descripcion', 255);
        });
    }

    public function down() {
        Schema::dropIfExists('t_diccionario_datos_observatorio');
    }
};
