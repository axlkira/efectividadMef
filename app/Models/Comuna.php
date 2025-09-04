<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comuna extends Model
{
    use HasFactory;

    protected $table = 't_comunas_corregimientos';
    protected $primaryKey = 'id_comuna_corregimiento';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    public function hogares()
    {
        return $this->hasMany(SisbenData::class, 'cod_comuna', 'id_comuna_corregimiento');
    }
}
