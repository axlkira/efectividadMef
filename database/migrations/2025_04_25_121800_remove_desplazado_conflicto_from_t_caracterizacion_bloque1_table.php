<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            if (Schema::hasColumn('t_caracterizacion_bloque1', 'desplazado_conflicto')) {
                $table->dropColumn('desplazado_conflicto');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->tinyInteger('desplazado_conflicto')->nullable();
        });
    }
};
