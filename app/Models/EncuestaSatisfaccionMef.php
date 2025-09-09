<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaSatisfaccionMef extends Model
{
    protected $table = 't22_encuestas_satisfaccion_mef';
    
    protected $fillable = [
        'folio',
        'idintegrantetitular',
        'documento_profesional',
        'estado_encuesta',
        'satisfaccion_servicio',
        'oportunidad_brindada',
        'trato_gestor',
        'aspecto_gustado',
        'aspecto_no_gustado',
        'nombre_encuestado',
        'telefono_encuestado',
        'linea'
    ];
}
