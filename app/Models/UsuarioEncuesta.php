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
        // Consulta para traer nombres correctos del titular con validaciones adicionales
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
                DB::raw('COALESCE(nombres_linea.descripcion, "Sin Descripción") as descripcion_linea'),
                DB::raw('COALESCE(tvr.finvisita, "") as fecharegistro'),
                'thp.folioactivo',
                DB::raw('COALESCE(tvr.linea, "") as idestacion'),
                DB::raw('COALESCE(tih.documento, "") as documento'),
                DB::raw('COALESCE(tcf.nombrecif, "") as cif'),
                DB::raw('COALESCE(tu.doc_dinamizador, "") as docgestor'),
                'visitas_tipo_1.created_at as fecha_visita_tipo_1'
            ])
            ->join('t1_integranteshogar_s as tih', 'thp.idintegrantetitular', '=', 'tih.idintegrante')
            ->leftJoin('t1_hogardatosgeograficos_s as thg', 'thp.folio', '=', 'thg.folio')
            ->leftJoin('t_comunas as tc', 'thg.comuna', '=', 'tc.codigo')
            ->leftJoin('t_barrios as tb', 'thg.barrio', '=', 'tb.codigo')
            ->leftJoin('t1_visitasrealizadas_s as tvr', function($join) {
                $join->on('thp.folio', '=', 'tvr.folio')
                     ->whereRaw('tvr.finvisita = (SELECT MAX(finvisita) FROM t1_visitasrealizadas_s WHERE folio = thp.folio)');
            })
            // Join para verificar si existe una visita tipo 1 (linea = 200)
            ->join(DB::raw('(SELECT folio, linea, created_at FROM t1_visitasrealizadas_s WHERE linea = 200) as visitas_tipo_1'), 
                  'thp.folio', '=', 'visitas_tipo_1.folio')
            ->leftJoin('t_visitasrealizadasnombres_s as tvn', 'tvr.linea', '=', 'tvn.linea')
            ->leftJoin('t_visitasrealizadasnombres_s as nombres_linea', 'visitas_tipo_1.linea', '=', 'nombres_linea.linea')
            ->leftJoin('t_usuario as tu', 'thp.usuario', '=', 'tu.documento')
            ->leftJoin('t_cif as tcf', 'tu.cif', '=', 'tcf.id')
            ->where('thp.usuario', $usuarioId)
            ->where('thp.folioactivo', 1)
            // Validación de que no hayan pasado más de 20 días desde la fecha de servicio
            ->whereRaw('DATEDIFF(NOW(), visitas_tipo_1.created_at) <= 20')
            // Excluir folios que ya tienen encuesta guardada
            ->whereNotExists(function($query) {
                $query->select(DB::raw(1))
                      ->from('t22_encuestas_satisfaccion_mef')
                      ->whereRaw('t22_encuestas_satisfaccion_mef.folio = thp.folio');
            })
            ->orderBy('thp.folio', 'asc')
            ->get();
    }
}
