<?php

namespace App\Http\Controllers;

use App\Models\SisbenData;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SisbenController extends Controller
{
    /**
     * Display the Sisbén consultation form.
     *
     * @return \Illuminate\View\View
     */
        public function index($documento_profesional = null)
    {
        // Assumes the view is at /resources/views/sisben/consulta.blade.php
        return view('sisben.consulta', ['documento_profesional' => $documento_profesional]);
    }

    /**
     * Handle the search request from the consultation form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search($cedula, $documento_profesional = null)
    {
        $validator = Validator::make(['cedula' => $cedula], [
            'cedula' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sisben.index')->withErrors($validator)->withInput();
        }

        // 1. Encontrar los IDs de los hogares a los que pertenece la persona consultada.
        $householdIds = SisbenData::where('num_documento', $cedula)
            ->pluck('identificacion_tentativa_num_hogares')
            ->unique();

        $hogaresData = collect();

        // 2. Si se encontraron hogares, procesar cada uno.
        if ($householdIds->isNotEmpty()) {
            foreach ($householdIds as $householdId) {
                // Obtener todos los miembros de este hogar, cargando las relaciones de barrio y comuna.
                $miembros = SisbenData::with(['barrio', 'comuna'])
                    ->where('identificacion_tentativa_num_hogares', $householdId)
                    ->get();

                if ($miembros->isEmpty()) {
                    continue;
                }

                // La información general es la misma para todos los miembros, se toma del primero.
                $infoGeneral = $miembros->first();
                // Encontrar al jefe de hogar.
                $jefeHogar = $miembros->firstWhere('asignacion_jefe_hogar', 'Si');

                $hogaresData->push([
                    'info_general' => $infoGeneral,
                    'jefe_hogar' => $jefeHogar,
                    'miembros' => $miembros,
                ]);
            }
        }

        // 3. Calcular el total de hogares en el sistema y la fecha del último corte.
        // El total de hogares se calcula contando el número de jefes de hogar ('Si').
        $totalHogaresSistema = SisbenData::where('asignacion_jefe_hogar', 'Si')->count();
        
        // Obtener el conteo total de registros directamente usando SQL puro
        $totalResult = DB::select("SELECT COUNT(*) as total FROM t_hogares_sisben");
        $totalIntegrantes = $totalResult[0]->total;
        $latestCutDate = SisbenData::max('fec_corte');

        // 4. Devolver la vista con todos los datos procesados.
        return view('sisben.consulta', [
            'resultados' => $hogaresData,
            'cedula_buscada' => $cedula,
            'totalHogares' => $totalHogaresSistema,
            'totalIntegrantes' => $totalIntegrantes,
            'fechaCorte' => $latestCutDate ? \Carbon\Carbon::parse($latestCutDate)->translatedFormat('d \\d\\e F \\d\\e Y') : 'N/A',
            'documento_profesional' => $documento_profesional,
        ]);
    }
}
