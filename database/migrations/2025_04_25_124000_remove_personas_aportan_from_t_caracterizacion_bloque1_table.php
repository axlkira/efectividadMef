<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            if (Schema::hasColumn('t_caracterizacion_bloque1', 'personas_aportan')) {
                $table->dropColumn('personas_aportan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('t_caracterizacion_bloque1', function (Blueprint $table) {
            $table->string('personas_aportan', 32)->nullable();
        });
    }
};
