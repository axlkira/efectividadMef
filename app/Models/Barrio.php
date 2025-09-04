<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    use HasFactory;

    protected $table = 't_barrios';
    protected $primaryKey = 'cod_barrio';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function comuna()
    {
        return $this->belongsTo(Comuna::class, 'id_comuna_corregimiento', 'id_comuna_corregimiento');
    }

    public function hogares()
    {
        return $this->hasMany(SisbenData::class, 'cod_barrio', 'cod_barrio');
    }
}
