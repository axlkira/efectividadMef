<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisbenData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_hogares_sisben';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ide_ficha_origen',
        'cod_barrio',
        'cod_comuna',
        'dir_vivienda',
        'fec_corte',
        'num_personas_hogar',
        'identificacion_tentativa_num_hogares',
        'num_tel_contacto',
        'asignacion_jefe_hogar',
        'ide_persona',
        'nombre_persona_hogar_concatenado',
        'num_documento',
        'cod_calificacion',
        'clasificacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fec_corte' => 'datetime',
        'cod_barrio' => 'integer',
        'cod_comuna' => 'integer',
        'num_personas_hogar' => 'integer',
        'identificacion_tentativa_num_hogares' => 'integer',
        'ide_persona' => 'integer',
        'num_tel_contacto' => 'integer',
    ];

    /**
     * Obtiene el barrio asociado con el registro de Sisbén.
     */
    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'cod_barrio', 'cod_barrio');
    }

    /**
     * Obtiene la comuna asociada con el registro de Sisbén.
     */
    public function comuna()
    {
        return $this->belongsTo(Comuna::class, 'cod_comuna', 'id_comuna_corregimiento');
    }
}
