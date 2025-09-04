<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsuarioEncuesta;
use App\Models\EncuestaSatisfaccionMef;

class EfectividadMefController extends Controller
{
    public function index($documento_profesional)
    {
        $usuarios = UsuarioEncuesta::getUsuariosParaEncuesta($documento_profesional);
        
        return view('efectividadMef.index', compact('usuarios'));
    }
    
    public function guardarEncuesta(Request $request)
    {
        EncuestaSatisfaccionMef::create([
            'folio' => $request->folio,
            'idintegrantetitular' => $request->idintegrantetitular,
            'documento_profesional' => $request->documento_profesional,
            'estado_encuesta' => $request->status,
            'satisfaccion_servicio' => $request->serviceSatisfaction,
            'oportunidad_brindada' => $request->opportunityHelpful,
            'trato_gestor' => $request->managerTreatment,
            'aspecto_gustado' => $request->likedAspect,
            'aspecto_no_gustado' => $request->dislikedAspect,
            'nombre_encuestado' => $request->respondentName,
            'telefono_encuestado' => $request->respondentPhone
        ]);
        
        return response()->json(['success' => true]);
    }
}
