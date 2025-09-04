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
            if (Schema::hasColumn('t_proteccion_bloque5', 'p32_red_apoyo')) {
                $table->dropColumn('p32_red_apoyo');
            }
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
            $table->json('p32_red_apoyo')->nullable();
        });
    }
};
