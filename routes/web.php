<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EfectividadMefController;
use App\Http\Controllers\SisbenController;

/*ImageController
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Rutas para el módulo de consulta Sisbén
/* Route::get('/sisben/{documento_profesional?}', [SisbenController::class, 'index'])->name('sisben.index');
Route::get('/sisben/consultar', [SisbenController::class, 'consultar'])->name('sisben.consultar');
Route::get('/sisben/consulta/{cedula}/{documento_profesional?}', [SisbenController::class, 'search'])->name('sisben.search'); */

// Rutas para Efectividad MEF
Route::get('/efectividad-mef/{documento_profesional}', [EfectividadMefController::class, 'index'])->name('efectividad-mef.index');
Route::post('/efectividad-mef/guardar-encuesta', [EfectividadMefController::class, 'guardarEncuesta'])->name('efectividad-mef.guardar-encuesta');