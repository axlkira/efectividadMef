<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UsuarioEncuesta extends Model
{
    protected $table = 't1_principalhogar_s';
    
    protected $primaryKey = 'folio';
    
    public $timestamps = false;
    
    protected $fillable = [
        'folio',
        'metodologia',
        'idintegrantetitular',
        'folioactivo',
        'usuario'
    ];
    
    public static function getUsuariosParaEncuesta($usuarioId)
    {
        // Consulta para traer nombres correctos del titular
        return DB::table('t1_principalhogar_s as thp')
            ->select([
                'thp.folio',
                'thp.metodologia',
                'thp.idintegrantetitular',
                DB::raw('COALESCE(tih.nombre1, "") as nombre1'),
                DB::raw('COALESCE(tih.nombre2, "") as nombre2'),
                DB::raw('COALESCE(tih.apellido1, "") as apellido1'),
                DB::raw('COALESCE(tih.apellido2, "") as apellido2'),
                DB::raw('COALESCE(tc.comuna, "Sin Comuna") as comuna'),
                DB::raw('COALESCE(tb.barriovereda, "Sin Barrio") as barrio'),
                DB::raw('COALESCE(thg.direccion, "Sin Dirección") as direccion'),
                DB::raw('COALESCE(tih.telefono, "") as telefono'),
                DB::raw('COALESCE(tih.celular, "") as celular'),
                DB::raw('COALESCE(tvn.linea, "") as desclinea'),
                DB::raw('COALESCE(tvn.descripcion, "Sin Visita") as descripcion'),
                DB::raw('COALESCE(tvr.finvisita, "") as fecharegistro'),
                'thp.folioactivo',
                DB::raw('COALESCE(tvr.linea, "") as idestacion'),
                DB::raw('COALESCE(tih.documento, "") as documento'),
                DB::raw('COALESCE(tcf.nombrecif, "") as cif'),
                DB::raw('COALESCE(tu.doc_dinamizador, "") as docgestor')
            ])
            ->join('t1_integranteshogar_s as tih', 'thp.idintegrantetitular', '=', 'tih.idintegrante')
            ->leftJoin('t1_hogardatosgeograficos_s as thg', 'thp.folio', '=', 'thg.folio')
            ->leftJoin('t_comunas as tc', 'thg.comuna', '=', 'tc.codigo')
            ->leftJoin('t_barrios as tb', 'thg.barrio', '=', 'tb.codigo')
            ->leftJoin('t1_visitasrealizadas_s as tvr', function($join) {
                $join->on('thp.folio', '=', 'tvr.folio')
                     ->whereRaw('tvr.finvisita = (SELECT MAX(finvisita) FROM t1_visitasrealizadas_s WHERE folio = thp.folio)');
            })
            ->leftJoin('t_visitasrealizadasnombres_s as tvn', 'tvr.linea', '=', 'tvn.linea')
            ->leftJoin('t_usuario as tu', 'thp.usuario', '=', 'tu.documento')
            ->leftJoin('t_cif as tcf', 'tu.cif', '=', 'tcf.id')
            ->where('thp.usuario', $usuarioId)
            ->where('thp.folioactivo', 1)
            ->orderBy('thp.folio', 'asc')
            ->get();
    }
}
