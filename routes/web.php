<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Catalogos\AdministracionesController;
use App\Http\Controllers\Catalogos\EdificiosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Rutas de Administraciones
Route::get('administraciones/index',                                [AdministracionesController::class, 'index'])->name('administraciones.index');
Route::get('administraciones/nueva',                                [AdministracionesController::class, 'nueva_administracion'])->name('administraciones.nuevo');
Route::post('administraciones/guardar',                             [AdministracionesController::class, 'guardar_administracion']);
Route::get('administraciones/editar/{id_administracion}',           [AdministracionesController::class, 'editar_administracion'])->name('administraciones.editar');
Route::post('administraciones/actualizar',                          [AdministracionesController::class, 'actualizar_administracion']);
Route::get('administraciones/inhabilitar/{id_administracion}',      [AdministracionesController::class, 'confirmainhabilitar_administracion']);

//Rutas de Edificios
Route::get('edificios/index',                               [EdificiosController::class, 'index'])->name('edificios.index');
Route::get('edificios/nuevo',                               [EdificiosController::class, 'nuevo_edificio'])->name('edificios.nuevo');
Route::post('edificios/guardar',                            [EdificiosController::class, 'guardar_edificio']);
Route::get('edificios/editar/{id_edificio}',                [EdificiosController::class, 'editar_edificio'])->name('edificios.editar');
Route::post('edificios/actualizar',                         [EdificiosController::class, 'actualizar_edificio']);
Route::get('edificios/inhabilitar/{id_edificio}',           [EdificiosController::class, 'confirmainhabilitar_edificio']);
