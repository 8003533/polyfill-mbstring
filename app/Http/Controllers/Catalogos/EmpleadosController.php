<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\EmpleadoTaller;
use App\Models\Catalogos\Puesto;
use App\Models\Catalogos\Adscripcion;
use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\Bitacora;

use Mpdf\Mpdf;

use \stdClass;
use \Datetime;
use \DateInterval;

class EmpleadosController extends Controller
{
    //Formato de Fechas MySQL
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $nombre = $request->nombre;
        if ($nombre != "") {
            $data['empleados'] = EmpleadosController::algoritmo_busca_empleado($nombre);
        } else {
            $data['empleados'] = DB::table('tcempleados_talleres as emp')
                                  ->Join('tcpuestos as pst','emp.iid_puesto','=','pst.iid_puesto')
                                  ->Join('tcadscripciones as adsc','emp.iid_adscripcion','=','adsc.iid_adscripcion')
                                  ->Join('tctalleres as tll','emp.iid_taller','=','tll.iid_taller')
                                  ->Join('tccuadrillas as cdr','emp.iid_cuadrilla','=','cdr.iid_cuadrilla')
                                  ->select('emp.*','pst.*','adsc.*','tll.*','cdr.*')
                                  ->where('emp.iestatus','=',1)
                                  ->orderBy('emp.cnombre_empleado_taller')->take(200)->get();
                                  //->latest()->take(200)->get();
        }
        return view('empleados.index',$data);
    }

    public function nuevo_empleado()
    {
        $empleado           = new EmpleadoTaller();
        $listPuestos        = Puesto::where('iestatus','=',1)->orderBy('cdescripcion_puesto')->get();
        $listAdscrips       = Adscripcion::where('iestatus','=',1)->orderBy('cdescripcion_adscripcion')->get();
        $listTalleres       = Taller::where('iestatus','=',1)->orderBy('cdescripcion_taller')->get();
        $listCuadrillas     = Cuadrilla::where('iestatus','=',1)->orderBy('cnombre_cuadrilla')->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar = '';
        return view('empleados.nuevo',compact('empleado','listPuestos','listAdscrips','listTalleres','listCuadrillas','noeditar'));
    }

    public function guardar_empleado(Request $request)
    {
        if($request->nombre_empleado!="" && $request->paterno_empleado!=""){
        //Revisar que no exista una Empleado con el mismo Nombre y Apellidos
            $ya_hay_emp                         = EmpleadoTaller::where('cnombre_empleado_taller', '=',$request->nombre_empleado)
                                                                ->where('cpaterno_empleado_taller','=',$request->paterno_empleado)
                                                                ->where('cmaterno_empleado_taller','=',$request->materno_empleado)
                                                                ->where('iestatus','=',1)->count();
        //Si no hay, entonces agregar al catálogo
            if ($ya_hay_emp==0) {
                $now                                    = new \DateTime();
                $empleado                               = new EmpleadoTaller();
                $jsonBefore1                            = "NEW INSERT EMPLEADO TALLER";
                $empleado->cnombre_empleado_taller      = $request->nombre_empleado;
                $empleado->cpaterno_empleado_taller     = $request->paterno_empleado;
                $empleado->cmaterno_empleado_taller     = $request->materno_empleado;
        //SI SE CAPTURA NUEVO PUESTO...
                if ($request->nuevo_puesto!="") {
                //Revisar que no exista un puesto con la misma Descripción
                    $ya_hay_puesto              = Puesto::where('cdescripcion_puesto','=',$request->nuevo_puesto)
                                                        ->where('iestatus','=',1)->count();
                    $puesto_que_yaexiste        = Puesto::where('cdescripcion_puesto','=',$request->nuevo_puesto)
                                                        ->where('iestatus','=',1)->first();
                //Si no hay, entonces agregar al catálogo
                    if ($ya_hay_puesto==0) {
                        $now                             = new \DateTime();
                        $nvo_puesto                      = new Puesto();
                        $jsonBefore2                     = "NEW INSERT PUESTO";
                        $nvo_puesto->cdescripcion_puesto = $request->nuevo_puesto;
                        $nvo_puesto->iestatus            = 1;
                        $nvo_puesto->iid_usuario         = auth()->user()->id;
                        $nvo_puesto->save();
                        $jsonAfter                       = json_encode($nvo_puesto);
                        PuestosController::bitacora($jsonBefore2,$jsonAfter);
                        $empleado->iid_puesto            = $nvo_puesto->iid_puesto;
                    } else {
                        $empleado->iid_puesto            = $puesto_que_yaexiste->iid_puesto;
                    }
                } else {
                    $empleado->iid_puesto       = $request->puesto;
                }
        //SI SE CAPTURA NUEVA ADSCRIPCIÓN..
                if ($request->nueva_adscripcion!="") {
                //Revisar que no exista una adscripción con la misma Descripción
                    $ya_hay_adsc                               = Adscripcion::where('cdescripcion_adscripcion','=',$request->nueva_adscripcion)
                                                                            ->where('iestatus','=',1)->count();
                    $adscrip_que_yaexiste                      = Adscripcion::where('cdescripcion_adscripcion','=',$request->nueva_adscripcion)
                                                                            ->where('iestatus','=',1)->first();
                //Si no hay, entonces agregar al catálogo
                    if ($ya_hay_adsc==0) {
                        $now                                        = new \DateTime();
                        $nva_adscripcion                            = new Adscripcion();
                        $jsonBefore3                                = "NEW INSERT ADSCRIPCION";
                        $nva_adscripcion->cdescripcion_adscripcion  = $request->nueva_adscripcion;
                        $nva_adscripcion->csiglas                   = "";
                        $nva_adscripcion->iid_tipo_area             = 9;
                        $nva_adscripcion->iestatus                  = 1;
                        $nva_adscripcion->iid_usuario               = auth()->user()->id;
                        $nva_adscripcion->save();
                        $jsonAfter                                  = json_encode($nva_adscripcion);
                        AdscripcionesController::bitacora($jsonBefore3,$jsonAfter);
                        $empleado->iid_adscripcion                  = $nva_adscripcion->iid_adscripcion;
                    } else {
                        $empleado->iid_adscripcion                  = $adscrip_que_yaexiste->iid_adscripcion;
                    }
                } else {
                    $empleado->iid_adscripcion  = $request->adscripcion;
                }
                $empleado->iid_taller           = $request->taller;
                $empleado->iid_cuadrilla        = $request->cuadrilla;
                $empleado->ccorreo_electronico  = $request->correo_electronico;
                $empleado->iestatus             = 1;
                $empleado->iid_usuario          = auth()->user()->id;
                $empleado->save();
                $jsonAfter                      = json_encode($empleado);
                EmpleadosController::bitacora($jsonBefore1,$jsonAfter);
            } else {
                return redirect()->route('empleados.nuevo')
                         ->with('danger','YA EXISTE una Empleado con este Nombre Guardado Previamente. Verifique.');
            }
        }

        return redirect()->route('empleados.editar',$empleado->iid_empleado_taller)
                         ->with('success','Empleado guardado satisfactoriamente');
    }

    public function editar_empleado($id_empleado)
    {
        $empleado           = EmpleadoTaller::where('iid_empleado_taller','=',$id_empleado)->first();
        $listPuestos        = Puesto::where('iestatus','=',1)->orderBy('cdescripcion_puesto')->get();
        $listAdscrips       = Adscripcion::where('iestatus','=',1)->orderBy('cdescripcion_adscripcion')->get();
        $listTalleres       = Taller::where('iestatus','=',1)->orderBy('cdescripcion_taller')->get();
        $listCuadrillas     = Cuadrilla::where('iestatus','=',1)->orderBy('cnombre_cuadrilla')->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar = '';
        return view('empleados.editar',compact('empleado','listPuestos','listAdscrips','listTalleres','listCuadrillas','noeditar'));
    }

    public function actualizar_empleado(Request $request)
    {
        $now                               = new \DateTime();
        $empleado                          = EmpleadoTaller::where('iid_empleado_taller','=',$request->id_empleado)->first();
        $jsonBefore                        = json_encode($empleado);
        //Se Habilita o Inhabilita el Empleado
        if ($request->noeditar == "disabled") {
            if ($empleado->iestatus == 0) {
                $operacion                 = "RECUPERADO";
                $empleado->iestatus        = 1;
            } else {
                $operacion                 = "BORRADO";
                $empleado->iestatus        = 0;
            }
        } else {
            //Se actualizan los datos del Empleado
            $operacion                          = "ACTUALIZADO";
            $empleado->cnombre_empleado_taller  = $request->nombre_empleado;
            $empleado->cpaterno_empleado_taller = $request->paterno_empleado;
            $empleado->cmaterno_empleado_taller = $request->materno_empleado;
    //SI SE CAPTURA NUEVO PUESTO...
            if ($request->nuevo_puesto!="") {
            //Revisar que no exista un puesto con la misma Descripción
                $ya_hay_puesto              = Puesto::where('cdescripcion_puesto','=',$request->nuevo_puesto)
                                                    ->where('iestatus','=',1)->count();
                $puesto_que_yaexiste        = Puesto::where('cdescripcion_puesto','=',$request->nuevo_puesto)
                                                    ->where('iestatus','=',1)->first();
            //Si no hay, entonces agregar al catálogo
                if ($ya_hay_puesto==0) {
                    $now                             = new \DateTime();
                    $nvo_puesto                      = new Puesto();
                    $jsonBefore2                     = "NEW INSERT PUESTO";
                    $nvo_puesto->cdescripcion_puesto = $request->nuevo_puesto;
                    $nvo_puesto->iestatus            = 1;
                    $nvo_puesto->iid_usuario         = auth()->user()->id;
                    $nvo_puesto->save();
                    $jsonAfter                       = json_encode($nvo_puesto);
                    PuestosController::bitacora($jsonBefore2,$jsonAfter);
                    $empleado->iid_puesto            = $nvo_puesto->iid_puesto;
                } else {
                    $empleado->iid_puesto            = $puesto_que_yaexiste->iid_puesto;
                }
            } else {
                $empleado->iid_puesto       = $request->puesto;
            }
    //SI SE CAPTURA NUEVA ADSCRIPCIÓN..
            if ($request->nueva_adscripcion!="") {
            //Revisar que no exista una adscripción con la misma Descripción
                $ya_hay_adsc                               = Adscripcion::where('cdescripcion_adscripcion','=',$request->nueva_adscripcion)
                                                                        ->where('iestatus','=',1)->count();
                $adscrip_que_yaexiste                      = Adscripcion::where('cdescripcion_adscripcion','=',$request->nueva_adscripcion)
                                                                        ->where('iestatus','=',1)->first();
            //Si no hay, entonces agregar al catálogo
                if ($ya_hay_adsc==0) {
                    $now                                        = new \DateTime();
                    $nva_adscripcion                            = new Adscripcion();
                    $jsonBefore3                                = "NEW INSERT ADSCRIPCION";
                    $nva_adscripcion->cdescripcion_adscripcion  = $request->nueva_adscripcion;
                    $nva_adscripcion->csiglas                   = "";
                    $nva_adscripcion->iid_tipo_area             = 9;
                    $nva_adscripcion->iestatus                  = 1;
                    $nva_adscripcion->iid_usuario               = auth()->user()->id;
                    $nva_adscripcion->save();
                    $jsonAfter                                  = json_encode($nva_adscripcion);
                    AdscripcionesController::bitacora($jsonBefore3,$jsonAfter);
                    $empleado->iid_adscripcion                  = $nva_adscripcion->iid_adscripcion;
                } else {
                    $empleado->iid_adscripcion                  = $adscrip_que_yaexiste->iid_adscripcion;
                }
            } else {
                $empleado->iid_adscripcion  = $request->adscripcion;
            }
            $empleado->iid_taller           = $request->taller;
            $empleado->iid_cuadrilla        = $request->cuadrilla;
            $empleado->ccorreo_electronico  = $request->correo_electronico;
            $empleado->iestatus             = 1;
        }
        $empleado->iid_usuario              = auth()->user()->id;
        $empleado->save();
        $jsonAfter                          = $operacion.' '.json_encode($empleado);
        EmpleadosController::bitacora($jsonBefore,$jsonAfter);

        if ($operacion=="BORRADO") {
            return redirect()->route('empleados.index')
                             ->with('success','Empleado '.$operacion.' satisfactoriamente');
        } else {
            return redirect()->route('empleados.editar',$empleado->iid_empleado_taller)
                             ->with('success','Empleado '.$operacion.' satisfactoriamente');
        }
    }

//Esta misma función se utiliza para Inhabilitar/Habilitar el Empleado
    public function confirmainhabilitar_empleado($id_empleado)
    {
        $empleado           = EmpleadoTaller::where('iid_empleado_taller','=',$id_empleado)->first();
        $listPuestos        = Puesto::where('iestatus','=',1)->get();
        $listAdscrips       = Adscripcion::where('iestatus','=',1)->get();
        $listTalleres       = Taller::where('iestatus','=',1)->orderBy('cdescripcion_taller')->get();
        $listCuadrillas     = Cuadrilla::where('iestatus','=',1)->orderBy('cnombre_cuadrilla')->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar     = 'disabled';
        return view('empleados.inhabilitar',compact('empleado','listPuestos','listTalleres','listCuadrillas','listAdscrips','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter){
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->user()->id;
        $bitacora->save();
    }

    //NUEVO MÉTODO DE BÚSQUEDA
    public static function algoritmo_busca_empleado(string $nombre) {
    //Si no hay espacios, se trata de un nombre
        if (strpos($nombre, " ") == 0 && strripos($nombre, " ") == 0) {
            $empleado           = DB::table('tcempleados_talleres as emp')
                                    ->Join('tcpuestos as pst','emp.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','emp.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->Join('tctalleres as tll','emp.iid_taller','=','tll.iid_taller')
                                    ->Join('tccuadrillas as cdr','emp.iid_cuadrilla','=','cdr.iid_cuadrilla')
                                    ->select('emp.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion','tll.*','cdr.*')
                                    ->where('emp.iestatus','=',1)
                                    ->where('emp.cnombre_empleado_taller','like','%'.$nombre.'%')
                                    ->get();
    //Si hay un espacio, se trata de un nombre y un paterno, o de dos nombres
        } elseif (strpos($nombre, " ") == strripos($nombre, " ")) {
            $empleado           = DB::table('tcempleados_talleres as emp')
                                    ->Join('tcpuestos as pst','emp.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','emp.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->Join('tctalleres as tll','emp.iid_taller','=','tll.iid_taller')
                                    ->Join('tccuadrillas as cdr','emp.iid_cuadrilla','=','cdr.iid_cuadrilla')
                                    ->select('emp.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion','tll.*','cdr.*')
                                    ->where('emp.iestatus','=',1)
                                    ->where('emp.cnombre_empleado_taller','like','%'.mb_strimwidth($nombre,0,strpos($nombre, " ")).'%')
                                    ->where('emp.cpaterno_empleado_taller','like','%'.mb_strimwidth($nombre,strpos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->orWhere('emp.cnombre_empleado_taller','like','%'.$nombre.'%')
                                    ->get();
    //Si hay dos espacios, se trata de un nombre y un paterno
        } elseif (strpos($nombre, " ") > 0 && (strripos($nombre, " ") > strpos($nombre, " "))) {
            $empleado           = DB::table('tcempleados_talleres as emp')
                                    ->Join('tcpuestos as pst','emp.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','emp.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->Join('tctalleres as tll','emp.iid_taller','=','tll.iid_taller')
                                    ->Join('tccuadrillas as cdr','emp.iid_cuadrilla','=','cdr.iid_cuadrilla')
                                    ->select('emp.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion','tll.*','cdr.*')
                                    ->where('emp.iestatus','=',1)
                                    ->where('emp.cnombre_empleado_taller' ,'like','%'.mb_strimwidth($nombre,                       0,strpos($nombre, " ")).'%')
                                    ->where('emp.cpaterno_empleado_taller','like','%'.mb_strimwidth($nombre,  strpos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->where('emp.cnombre_empleado_taller' ,'like','%'.mb_strimwidth($nombre,                       0,strripos($nombre, " ")).'%')
                                    ->orWhere('emp.cpaterno_empleado_taller','like','%'.mb_strimwidth($nombre,strripos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->get();
        }
        return $empleado;
    }
}
