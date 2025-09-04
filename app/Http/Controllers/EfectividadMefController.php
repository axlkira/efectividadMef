<?php

namespace App\Http\Controllers;

use App\Models\UsuarioEncuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EfectividadMefController extends Controller
{
    public function index($documento_profesional)
    {
        /*
        ┌─────────────────────────────────────────────────────────────┐
        │ MODO PRODUCCIÓN: Documento recibido por URL                │
        │ Ejemplo: http://127.0.0.1:8000/efectividad-mef/1001033716  │
        └─────────────────────────────────────────────────────────────┘
        */
        
        // ✅ USO ACTUAL: Documento recibido desde la URL
        $usuarioId = $documento_profesional;
        
        // 🔄 MODO ALTERNATIVO: Validar que el usuario tenga permiso
        /*
        // Opción 1: Validar que el usuario logueado coincida con el URL
        if (Auth::check() && Auth::user()->documento != $documento_profesional) {
            abort(403, 'No tienes permiso para ver estos datos');
        }
        
        // Opción 2: Validar por roles/permisos
        if (!Auth::user()->can('ver-efectividad', $documento_profesional)) {
            abort(403, 'Acceso no autorizado');
        }
        */
        
        // 🔄 MODO ALTERNATIVO: Si no hay documento, usar el logueado
        /*
        if (empty($documento_profesional)) {
            $usuarioId = Auth::user()->documento;
        } else {
            $usuarioId = $documento_profesional;
        }
        */
        
        $usuarios = UsuarioEncuesta::getUsuariosParaEncuesta($usuarioId);
        
        // Pasar también el documento del profesional a la vista
        return view('efectividadMef.index', compact('usuarios', 'documento_profesional'));
    }
}
