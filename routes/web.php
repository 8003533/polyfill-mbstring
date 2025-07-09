<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Catalogos\TalleresController;
use App\Http\Controllers\Catalogos\EmpleadosController;
use App\Http\Controllers\Catalogos\CuadrillasController;
use App\Http\Controllers\Catalogos\AdministracionesController;
use App\Http\Controllers\Catalogos\EdificiosController;
use App\Http\Controllers\Catalogos\PuestosController;
use App\Http\Controllers\Catalogos\AdscripcionesController;
use App\Http\Controllers\Catalogos\PersonalController;

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

//Rutas de Talleres
Route::get('talleres/index',                                [TalleresController::class, 'index'])->name('talleres.index');
Route::get('talleres/nuevo',                                [TalleresController::class, 'nuevo_taller'])->name('talleres.nuevo');
Route::post('talleres/guardar',                             [TalleresController::class, 'guardar_taller']);
Route::get('talleres/editar/{id_taller}',                   [TalleresController::class, 'editar_taller'])->name('talleres.editar');
Route::post('talleres/actualizar',                          [TalleresController::class, 'actualizar_taller']);
Route::get('talleres/inhabilitar/{id_taller}',              [TalleresController::class, 'confirmainhabilitar_taller']);

//Rutas de Empleados Talleres
Route::get('empleados/index',                               [EmpleadosController::class, 'index'])->name('empleados.index');
Route::get('empleados/nuevo',                               [EmpleadosController::class, 'nuevo_empleado'])->name('empleados.nuevo');
Route::post('empleados/guardar',                            [EmpleadosController::class, 'guardar_empleado']);
//CORRECCIÓN DE DATOS
Route::get('empleados/editar/{id_empleado}',                [EmpleadosController::class, 'editar_empleado'])->name('empleados.editar');
Route::post('empleados/actualizar',                         [EmpleadosController::class, 'actualizar_empleado']);
//BORRAR / RECUPERAR
Route::get('empleados/inhabilitar/{id_empleado}',           [EmpleadosController::class, 'confirmainhabilitar_empleado']);

//Rutas de Cuadrillas
Route::get('cuadrillas/index',                              [CuadrillasController::class, 'index'])->name('cuadrillas.index');
Route::get('cuadrillas/nueva',                              [CuadrillasController::class, 'nueva_cuadrilla'])->name('cuadrillas.nueva');
Route::post('cuadrillas/guardar',                           [CuadrillasController::class, 'guardar_cuadrilla']);
Route::get('cuadrillas/editar/{id_cuadrilla}',              [CuadrillasController::class, 'editar_cuadrilla'])->name('cuadrillas.editar');
Route::post('cuadrillas/actualizar',                        [CuadrillasController::class, 'actualizar_cuadrilla']);
Route::get('cuadrillas/inhabilitar/{id_cuadrilla}',         [CuadrillasController::class, 'confirmainhabilitar_cuadrilla']);

//Rutas de Administraciones
Route::get('administraciones/index',                        [AdministracionesController::class, 'index'])->name('administraciones.index');
Route::get('administraciones/nueva',                        [AdministracionesController::class, 'nueva_administracion'])->name('administraciones.nuevo');
Route::post('administraciones/guardar',                     [AdministracionesController::class, 'guardar_administracion']);
Route::get('administraciones/editar/{id_administracion}',   [AdministracionesController::class, 'editar_administracion'])->name('administraciones.editar');
Route::post('administraciones/actualizar',                  [AdministracionesController::class, 'actualizar_administracion']);
Route::get('administraciones/inhabilitar/{id_administracion}', [AdministracionesController::class, 'confirmainhabilitar_administracion']);

//Rutas de Edificios
Route::get('edificios/index',                               [EdificiosController::class, 'index'])->name('edificios.index');
Route::get('edificios/nuevo',                               [EdificiosController::class, 'nuevo_edificio'])->name('edificios.nuevo');
Route::post('edificios/guardar',                            [EdificiosController::class, 'guardar_edificio']);
Route::get('edificios/editar/{id_edificio}',                [EdificiosController::class, 'editar_edificio'])->name('edificios.editar');
Route::post('edificios/actualizar',                         [EdificiosController::class, 'actualizar_edificio']);
Route::get('edificios/inhabilitar/{id_edificio}',           [EdificiosController::class, 'confirmainhabilitar_edificio']);
Route::post('buscaAlcaldiaColonia',                         [EdificiosController::class, 'buscaAlcaldiaColonia']);

//Rutas de Puestos
Route::get('puestos/index',                         [PuestosController::class, 'index'])->name('puestos.index');
Route::get('puestos/nuevo',                         [PuestosController::class, 'nuevo_puesto'])->name('puestos.nuevo');
Route::post('puestos/guardar',                      [PuestosController::class, 'guardar_puesto']);
Route::get('puestos/editar/{id_puesto}',            [PuestosController::class, 'editar_puesto'])->name('puestos.editar');
Route::post('puestos/actualizar',                   [PuestosController::class, 'actualizar_puesto']);
Route::get('puestos/inhabilitar/{id_puesto}',       [PuestosController::class, 'confirmainhabilitar_puesto']);
Route::post('buscaPuestos',                         [PuestosController::class, 'buscaPuestos']);

//Rutas de Adscripciones
Route::get('adscripciones/index',                   [AdscripcionesController::class, 'index'])->name('adscripciones.index');
Route::get('adscripciones/nueva',                   [AdscripcionesController::class, 'nueva_adscripcion'])->name('adscripciones.nueva');
Route::post('adscripciones/guardar',                [AdscripcionesController::class, 'guardar_adscripcion']);
Route::get('adscripciones/editar/{id_adsc}',        [AdscripcionesController::class, 'editar_adscripcion'])->name('adscripciones.editar');
Route::post('adscripciones/actualizar',             [AdscripcionesController::class, 'actualizar_adscripcion']);
Route::get('adscripciones/inhabilitar/{id_adsc}',   [AdscripcionesController::class, 'confirmainhabilitar_adscripcion']);
Route::post('buscaAdscripciones',                   [AdscripcionesController::class, 'buscaAdscripciones']);

//Rutas de Personal
Route::get('personal/index',                        [PersonalController::class, 'index'])->name('personal.index');
Route::get('personal/nuevo',                        [PersonalController::class, 'nuevo_personal'])->name('personal.nuevo');
Route::post('personal/guardar',                     [PersonalController::class, 'guardar_personal']);
//CORRECCIÓN DE DATOS
Route::get('personal/editar/{id_personal}',         [PersonalController::class, 'editar_personal'])->name('personal.editar');
Route::post('personal/actualizar',                  [PersonalController::class, 'actualizar_personal']);
//ACTUALIZAR PUESTO Y ADSCRIPCIÓN, CREANDO UN NUEVO REGISTRO.
Route::get('personal/actualizar/{id_personal}',     [PersonalController::class, 'actualizar_personal_pstoads']);
Route::post('personal/act_psto_adsc',               [PersonalController::class, 'actualizar_psto_adsc']);
//BORRAR / RECUPERAR
Route::get('personal/inhabilitar/{id_personal}',    [PersonalController::class, 'confirmainhabilitar_personal']);
Route::post('buscaPuestoAdscrip',                   [PersonalController::class, 'buscaPuestoAdscrip']);
Route::post('actualizaPuestoAdscrip',               [PersonalController::class, 'actualizaPuestoAdscrip']);
Route::post('buscaOtroNombre',                      [PersonalController::class, 'buscaOtroNombre']);