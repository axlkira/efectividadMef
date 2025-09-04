<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            if (!Schema::hasColumn('t_caracterizacion_bloque1', 'jefatura_nucleo')) {
                $table->unsignedSmallInteger('jefatura_nucleo')->nullable()->comment('¿Quién es la jefatura o figura de representación en tu núcleo familiar?');
            }
        });
    }

    public function down(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->dropColumn('jefatura_nucleo');
        });
    }
};
