<?php
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Servicios\RegistroController;
/// Nuevos Catalogos
use App\Http\Controllers\Catalogos\CatalogosController;
use App\Http\Controllers\Catalogos\AreasController;
use App\Http\Controllers\Catalogos\BienesController;
use App\Http\Controllers\Catalogos\ProveedoresController;
use App\Http\Controllers\Catalogos\EntradasController;
use App\Http\Controllers\Catalogos\SalidasController;
use App\Http\Controllers\Catalogos\UnidadesController;

Route::get('/catalogos', [CatalogosController::class, 'index'])->name('catalogos.index');


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


// Rutas de empleados
Route::get('empleados/index', [EmpleadosController::class, 'index'])->name('empleados.index');
Route::get('empleados/nuevo', [EmpleadosController::class, 'nuevo_empleado'])->name('empleados.nuevo');
Route::post('empleados/guardar', [EmpleadosController::class, 'guardar_empleado'])->name('empleados.guardar');
Route::get('empleados/editar/{id_empleado}', [EmpleadosController::class, 'editar_empleado'])->name('empleados.editar');
Route::post('empleados/actualizar', [EmpleadosController::class, 'actualizar_empleado'])->name('empleados.actualizar');
Route::get('empleados/inhabilitar/{id_empleado}', [EmpleadosController::class, 'confirmainhabilitar_empleado'])->name('empleados.inhabilitar');

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


// Rutas de adscripciones
Route::get('adscripciones/index', [AdscripcionesController::class, 'index'])->name('adscripciones.index');
Route::post('adscripciones/guardar', [AdscripcionesController::class, 'guardar'])->name('adscripciones.guardar');
Route::get('adscripciones/editar/{id_adscripcion}', [AdscripcionesController::class, 'editar'])->name('adscripciones.editar');
Route::post('adscripciones/actualizar', [AdscripcionesController::class, 'actualizar'])->name('adscripciones.actualizar');
Route::get('adscripciones/inhabilitar/{id_adscripcion}', [AdscripcionesController::class, 'inhabilitar'])->name('adscripciones.inhabilitar');

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



//Rutas de Servicio
Route::get('registro/index',                        [RegistroController::class, 'index'])->name('registro.index');
Route::post('registro/guardar',                      [RegistroController::class, 'guardar'])->name('registro.guardar');



// -------------------- ÁREAS --------------------

Route::get('areas/index',           [AreasController::class, 'index'])->name('areas.index');
Route::get('areas/nuevo',           [AreasController::class, 'nuevo_area'])->name('areas.nuevo');
Route::post('areas/guardar',        [AreasController::class, 'guardar_area'])->name('areas.guardar');
Route::get('areas/editar/{id_areas}',     [AreasController::class, 'editar_area'])->name('areas.editar');
// Actualizar área

Route::post('/areas/actualizar', [App\Http\Controllers\Catalogos\AreasController::class, 'actualizar_area'])->name('areas.actualizar');


Route::get('areas/inhabilitar/{id_areas}', [AreasController::class, 'confirmainhabilitar_area'])->name('areas.inhabilitar');
Route::get('areas/datos/{id}',      [AreasController::class, 'datos_area'])->name('areas.datos');
Route::delete('areas/{id_areas}', [AreasController::class, 'eliminar'])->name('areas.eliminar');


// -------------------- BIENES --------------------

Route::get('bienes/index',
    [BienesController::class, 'index']
)->name('bienes.index');

Route::get('bienes/nuevo',
    [BienesController::class, 'nuevo_bien']
)->name('bienes.nuevo');

Route::post('bienes/guardar',
    [BienesController::class, 'guardar']
)->name('bienes.guardar');

Route::get('bienes/editar/{id}',
    [BienesController::class, 'editar']
)->name('bienes.editar');

Route::post('bienes/actualizar',
    [BienesController::class, 'actualizar']
)->name('bienes.actualizar');

Route::delete('bienes/{id}',
    [BienesController::class, 'eliminar']
)->name('bienes.eliminar');


/** PROVEEDORES */

Route::get('proveedores/index',           [ProveedoresController::class, 'index'])->name('proveedores.index');
Route::get('proveedores/nuevo',           [ProveedoresController::class, 'nuevo'])->name('proveedores.nuevo');
Route::post('proveedores/guardar',        [ProveedoresController::class, 'guardar'])->name('proveedores.guardar');

Route::get('proveedores/editar/{id_proveedor}', [ProveedoresController::class, 'editar'])->name('proveedores.editar');
Route::post('proveedores/actualizar',     [ProveedoresController::class, 'actualizar'])->name('proveedores.actualizar');

Route::delete('proveedores/{id_proveedor}', [ProveedoresController::class, 'eliminar'])->name('proveedores.eliminar');


/** UNIDADES */
Route::get('unidades', [UnidadesController::class, 'index'])->name('unidades.index');
Route::get('unidades/nuevo', [UnidadesController::class, 'nuevo'])->name('unidades.nuevo');
Route::post('unidades/guardar', [UnidadesController::class, 'guardar'])->name('unidades.guardar');
Route::get('unidades/editar/{id_unidad}', [UnidadesController::class, 'editar'])->name('unidades.editar');
Route::post('unidades/actualizar', [UnidadesController::class, 'actualizar'])->name('unidades.actualizar');
Route::delete('unidades/{id_unidad}', [UnidadesController::class, 'eliminar'])->name('unidades.eliminar');

/** ENTRADAS */




Route::prefix('entradas')->group(function () {
    Route::get('/', [EntradasController::class, 'index'])->name('entradas.index');
    Route::get('/nuevo', [EntradasController::class, 'nuevo'])->name('entradas.nuevo');

    // Crear (tcentradas + detalle_entrada)
    Route::post('/crear', [EntradasController::class, 'crear'])->name('entradas.crear');

    // Actualizar cabecera (tcentradas)
    Route::post('/actualizar', [EntradasController::class, 'actualizar'])->name('entradas.actualizar');

    // Eliminar (detalle_entrada + tcentradas)
    Route::delete('/{id}', [EntradasController::class, 'inhabilitar'])->name('entradas.inhabilitar');
});






/** SALIDAS */

Route::prefix('salidas')->group(function () {

    Route::get('/', [SalidasController::class, 'index'])->name('salidas.index');

    Route::get('/nuevo', [SalidasController::class, 'create'])->name('salidas.nuevo');

    Route::post('/guardar', [SalidasController::class, 'store'])->name('salidas.guardar');

    Route::get('/editar/{id_salida}', [SalidasController::class, 'edit'])->name('salidas.editar');

    Route::put('/actualizar', [SalidasController::class, 'actualizar'])->name('salidas.actualizar');

    Route::delete('/eliminar/{id_salida}', [SalidasController::class, 'destroy'])->name('salidas.eliminar');
});
