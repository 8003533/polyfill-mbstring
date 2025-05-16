<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Puesto;
use App\Models\Catalogos\Adscripcion;
use App\Models\Servicios\Bitacora;

use Mpdf\Mpdf;

use \stdClass;
use \Datetime;
use \DateInterval;

class PersonalController extends Controller
{
    //Formato de Fechas MySQL
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $nombre = $request->nombre;
        if ($nombre != "") {
            $data['personal'] = PersonalController::algoritmo_busca_persona($nombre);
        } else {
            $data['personal'] = DB::table('tcpersonal as pers')
                                  ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                  ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                  ->select('pers.*','pst.*','adsc.*')
                                  ->where('pers.iestatus','=',1)
                                  ->orderBy('pers.cnombre_personal')->take(200)->get();
                                  //->latest()->take(200)->get();
        }
        return view('personal.index',$data);
    }

    public function nuevo_personal()
    {
        $personal     = new Personal();
        $listPuestos  = Puesto::where('iestatus','=',1)->orderBy('cdescripcion_puesto')->get();
        $listAdscrips = Adscripcion::where('iestatus','=',1)->orderBy('cdescripcion_adscripcion')->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar = '';
        return view('personal.nuevo',compact('personal','listPuestos','listAdscrips','noeditar'));
    }

    public function guardar_personal(Request $request)
    {
        if($request->nombre_personal!="" && $request->paterno_personal!=""){
        //Revisar que no exista una persona con el mismo Nombre y Apellidos
            $ya_hay_pers                        = Personal::where('cnombre_personal', '=',$request->nombre_personal)
                                                          ->where('cpaterno_personal','=',$request->paterno_personal)
                                                          ->where('cmaterno_personal','=',$request->materno_personal)
                                                          ->where('iestatus','=',1)->count();
        //Si no hay, entonces agregar al catálogo
            if ($ya_hay_pers==0) {
                $now                            = new \DateTime();
                $personal                       = new Personal();
                $jsonBefore1                    = "NEW INSERT PERSONAL";
                $personal->cnombre_personal     = $request->nombre_personal;
                $personal->cpaterno_personal    = $request->paterno_personal;
                $personal->cmaterno_personal    = $request->materno_personal;
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
                        $personal->iid_puesto            = $nvo_puesto->iid_puesto;
                    } else {
                        $personal->iid_puesto            = $puesto_que_yaexiste->iid_puesto;
                    }
                } else {
                    $personal->iid_puesto       = $request->puesto;
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
                        $personal->iid_adscripcion                  = $nva_adscripcion->iid_adscripcion;
                    } else {
                        $personal->iid_adscripcion                  = $adscrip_que_yaexiste->iid_adscripcion;
                    }
                } else {
                    $personal->iid_adscripcion  = $request->adscripcion;
                }
                $personal->ccorreo_electronico  = $request->correo_electronico;
                $personal->iestatus             = 1;
                $personal->iid_usuario          = auth()->user()->id;
                $personal->save();
                $jsonAfter                      = json_encode($personal);
                PersonalController::bitacora($jsonBefore1,$jsonAfter);
            } else {
                return redirect()->route('personal.nuevo')
                         ->with('danger','YA EXISTE una Persona con este Nombre Guardado Previamente. Verifique.');
            }
        }

        return redirect()->route('personal.editar',$personal->iid_personal)
                         ->with('success','Personal guardado satisfactoriamente');
    }

    public function editar_personal($id_personal)
    {
        $personal     = Personal::where('iid_personal','=',$id_personal)->first();
        $listPuestos  = Puesto::where('iestatus','=',1)->orderBy('cdescripcion_puesto')->get();
        $listAdscrips = Adscripcion::where('iestatus','=',1)->orderBy('cdescripcion_adscripcion')->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar = '';
        return view('personal.editar',compact('personal','listPuestos','listAdscrips','noeditar'));
    }

    public function actualizar_personal(Request $request)
    {
        $now                               = new \DateTime();
        $personal                          = Personal::where('iid_personal','=',$request->id_personal)->first();
        $jsonBefore                        = json_encode($personal);
        //Se Habilita o Inhabilita el Puesto
        if ($request->noeditar == "disabled") {
            if ($personal->iestatus == 0) {
                $operacion                 = "RECUPERADO";
                $personal->iestatus        = 1;
            } else {
                $operacion                 = "BORRADO";
                $personal->iestatus        = 0;
            }
        } else {
            //Se actualizan los datos del Puesto
            $operacion                     = "ACTUALIZADO";
            $personal->cnombre_personal    = $request->nombre_personal;
            $personal->cpaterno_personal   = $request->paterno_personal;
            $personal->cmaterno_personal   = $request->materno_personal;
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
                    $personal->iid_puesto            = $nvo_puesto->iid_puesto;
                } else {
                    $personal->iid_puesto            = $puesto_que_yaexiste->iid_puesto;
                }
            } else {
                $personal->iid_puesto       = $request->puesto;
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
                    $personal->iid_adscripcion                  = $nva_adscripcion->iid_adscripcion;
                } else {
                    $personal->iid_adscripcion                  = $adscrip_que_yaexiste->iid_adscripcion;
                }
            } else {
                $personal->iid_adscripcion  = $request->adscripcion;
            }
            $personal->ccorreo_electronico = $request->correo_electronico;
            $personal->iestatus            = 1;
        }
        $personal->iid_usuario             = auth()->user()->id;
        $personal->save();
        $jsonAfter                         = $operacion.' '.json_encode($personal);
        PersonalController::bitacora($jsonBefore,$jsonAfter);

        if ($operacion=="BORRADO") {
            return redirect()->route('personal.index')
                             ->with('success','Personal '.$operacion.' satisfactoriamente');
        } else {
            return redirect()->route('personal.editar',$personal->iid_personal)
                             ->with('success','Personal '.$operacion.' satisfactoriamente');
        }
    }

    public function actualizar_personal_pstoads($id_personal)
    {
        $personal     = Personal::where('iid_personal','=',$id_personal)->first();
        $listPuestos  = Puesto::where('iestatus','=',1)->get();
        $listAdscrips = Adscripcion::where('iestatus','=',1)->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar = '';
        return view('personal.actualizar',compact('personal','listPuestos','listAdscrips','noeditar'));
    }

//ACTUALIZAR PUESTO Y ADSCRIPCIÓN, CREANDO UN NUEVO REGISTRO.
    public function actualizar_psto_adsc(Request $request)
    {
        $now                            = new \DateTime();
        $personal                       = new Personal();
        $jsonBefore                     = "NEW INSERT PERSONAL";
        $personal->cnombre_personal     = $request->nombre_personal;
        $personal->cpaterno_personal    = $request->paterno_personal;
        $personal->cmaterno_personal    = $request->materno_personal;
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
                $personal->iid_puesto            = $nvo_puesto->iid_puesto;
            } else {
                $personal->iid_puesto            = $puesto_que_yaexiste->iid_puesto;
            }
        } else {
            $personal->iid_puesto       = $request->puesto;
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
                $personal->iid_adscripcion                  = $nva_adscripcion->iid_adscripcion;
            } else {
                $personal->iid_adscripcion                  = $adscrip_que_yaexiste->iid_adscripcion;
            }
        } else {
            $personal->iid_adscripcion  = $request->adscripcion;
        }
        $personal->ccorreo_electronico  = $request->correo_electronico;
        $personal->iestatus             = 1;
        $personal->iid_usuario          = auth()->user()->id;
        $personal->save();
        $jsonAfter                      = json_encode($personal);
        PersonalController::bitacora($jsonBefore,$jsonAfter);
    //Borrado lógico del registro anterior del Personal
        $personal_anterior              = Personal::where('iid_personal','=',$request->id_personal)->first();
        $jsonBefore                     = "BORRADO LÓGICO DE PERSONAL POR ACTUALIZACION DE PSTO / ADSC ".json_encode($personal_anterior);
        $personal_anterior->iestatus    = 0;
        $personal_anterior->iid_usuario = auth()->user()->id;
        $personal_anterior->save();
        $jsonAfter                      = json_encode($personal_anterior);
        PersonalController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('personal.editar',$personal->iid_personal)
                         ->with('success','Personal ACTUALIZADO (Puesto/Adscripción) satisfactoriamente');
    }    

    //Esta misma función se utiliza para Inhabilitar/Habilitar el Personal
    public function confirmainhabilitar_personal($id_personal)
    {
        $personal     = Personal::where('iid_personal','=',$id_personal)->first();
        $listPuestos  = Puesto::where('iestatus','=',1)->get();
        $listAdscrips = Adscripcion::where('iestatus','=',1)->get();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar     = 'disabled';
        return view('personal.inhabilitar',compact('personal','listPuestos','listAdscrips','noeditar'));
    }

//NUEVO MÉTODO DE BÚSQUEDA
    public static function algoritmo_busca_persona(string $nombre) {
    //Si no hay espacios, se trata de un nombre
        if (strpos($nombre, " ") == 0 && strripos($nombre, " ") == 0) {
            /*
            $data['personal']   = Personal::with('puesto','adscripcion')->where('iestatus','=',1)
                                      ->where('cnombre_personal','like','%'.$nombre.'%')
                                      ->get();
                                      */
            $personal           = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal','like','%'.$nombre.'%')
                                    ->get();
    //Si hay un espacio, se trata de un nombre y un paterno, o de dos nombres
        } elseif (strpos($nombre, " ") == strripos($nombre, " ")) {
            /*
            $data['personal']   = Personal::with('puesto','adscripcion')->where('iestatus','=',1)
                                      ->where('cnombre_personal','like','%'.mb_strimwidth($nombre,0,strpos($nombre, " ")).'%')
                                      ->where('cpaterno_personal','like','%'.mb_strimwidth($nombre,strpos($nombre, " ")+1,strlen($nombre)).'%')
                                      ->orWhere('cnombre_personal','like','%'.$nombre.'%')
                                      ->get();
                                      */
            $personal           = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal','like','%'.mb_strimwidth($nombre,0,strpos($nombre, " ")).'%')
                                    ->where('pers.cpaterno_personal','like','%'.mb_strimwidth($nombre,strpos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->orWhere('pers.cnombre_personal','like','%'.$nombre.'%')
                                    ->get();
    //Si hay dos espacios, se trata de un nombre y un paterno
        } elseif (strpos($nombre, " ") > 0 && (strripos($nombre, " ") > strpos($nombre, " "))) {
            /*
            $data['personal']   = Personal::with('puesto','adscripcion')->where('iestatus','=',1)
                                      ->where('cnombre_personal'   ,'like','%'.mb_strimwidth($nombre,                       0,strpos($nombre, " ")).'%')
                                      ->where('cpaterno_personal'  ,'like','%'.mb_strimwidth($nombre,  strpos($nombre, " ")+1,strlen($nombre)).'%')
                                      ->where('cnombre_personal'   ,'like','%'.mb_strimwidth($nombre,                       0,strripos($nombre, " ")).'%')
                                      ->orWhere('cpaterno_personal','like','%'.mb_strimwidth($nombre,strripos($nombre, " ")+1,strlen($nombre)).'%')
                                      ->get();
                                      */
            $personal           = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.iid_puesto','pst.cdescripcion_puesto','adsc.iid_adscripcion','adsc.cdescripcion_adscripcion')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal' ,'like','%'.mb_strimwidth($nombre,                       0,strpos($nombre, " ")).'%')
                                    ->where('pers.cpaterno_personal','like','%'.mb_strimwidth($nombre,  strpos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->where('pers.cnombre_personal' ,'like','%'.mb_strimwidth($nombre,                       0,strripos($nombre, " ")).'%')
                                    ->orWhere('pers.cpaterno_personal','like','%'.mb_strimwidth($nombre,strripos($nombre, " ")+1,strlen($nombre)).'%')
                                    ->get();
        }
        return $personal;
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter){
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->user()->id;
        $bitacora->save();
    }

    public static function buscaPuestoAdscrip(Request $request){
        $nr               = $request->nr;
        $personal_rem     = PersonalController::algoritmo_busca_persona($nr);
        if(!$personal_rem->isEmpty() && $personal_rem[0]->iestatus==1){
            $idRemitente  = $personal_rem[0]->iid_personal;
            $nombreRemtte = $personal_rem[0]->cnombre_personal.' '.$personal_rem[0]->cpaterno_personal.' '.$personal_rem[0]->cmaterno_personal;
            $listaNR      = $personal_rem;
            $listaPuesto  = Puesto::where('iid_puesto','=',$personal_rem[0]->iid_puesto)->where('iestatus','=',1)->get();
            $listaAdscrip = Adscripcion::where('iid_adscripcion','=',$personal_rem[0]->iid_adscripcion)->where('iestatus','=',1)->get();
            return response()->json(
                [
                    'idRemitente'  => $idRemitente,
                    'nombreRemtte' => $nombreRemtte,
                    'listaNR'      => $listaNR,
                    'listaPuesto'  => $listaPuesto,
                    'listaAdscrip' => $listaAdscrip,
                    'exito'        => 1
                ]
            );
        } else {
            return response()->json(
                [
                    'idRemitente'  => null,
                    'nombreRemtte' => null,
                    'listaNR'      => null,
                    'listaPuesto'  => null,
                    'listaAdscrip' => null,
                    'exito'        => 0
                ]
            );
        }
    }


    public static function actualizaPuestoAdscrip(Request $request){
        $idrmtte            = $request->lnr;
        $remitente          = Personal::where('iid_personal','=',$idrmtte)->get();
        if (!$remitente->isEmpty()){
            $puesto         = Puesto::where('iid_puesto','=',$remitente[0]->iid_puesto)->get();
            $adscripcion    = Adscripcion::where('iid_adscripcion','=',$remitente[0]->iid_adscripcion)->get();
            return response()->json(
                [
                    'puesto'        => $puesto,
                    'adscripcion'   => $adscripcion,
                    'exito'         => 1
                ]
            );
        } else {
            return response()->json(
                [
                    'puesto'        => null,
                    'adscripcion'   => null,
                    'exito'         => 0
                ]
            );
        }
    }

    public static function buscaOtroNombre(Request $request){
        $on               = $request->on;
        //$otro_personal    = PersonalController::algoritmo_busca_persona($on);

    //NUEVO MÉTODO DE BÚSQUEDA
    //Si no hay espacios, se trata de un nombre
        if (strpos($on, " ") == 0 && strripos($on, " ") == 0) {
            $otro_personal    = Personal::with('puesto','adscripcion')
                                        ->where('iestatus','=',1)
                                        ->where('cnombre_personal','like','%'.$on.'%')
                                        ->get();
            /*
            $otro_personal    = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.*','adsc.*')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal','like','%'.$on.'%')
                                    ->get();
                                        */
    //Si hay un espacio, se trata de un nombre y un paterno, o de dos nombres
        } elseif (strpos($on, " ") == strripos($on, " ")) {
            $otro_personal    = Personal::with('puesto','adscripcion')
                                        ->where('iestatus','=',1)
                                        ->where('cnombre_personal','like','%'.mb_strimwidth($on,0,strpos($on, " ")).'%')
                                        ->where('cpaterno_personal','like','%'.mb_strimwidth($on,strpos($on, " ")+1,strlen($on)).'%')
                                        ->orWhere('cnombre_personal','like','%'.$on.'%')
                                        ->get();
            /*
            $otro_personal    = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.*','adsc.*')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal'  ,'like','%'.mb_strimwidth($on,0,strpos($on, " ")).'%')
                                    ->where('pers.cpaterno_personal' ,'like','%'.mb_strimwidth($on,strpos($on, " ")+1,strlen($on)).'%')
                                    ->orWhere('pers.cnombre_personal','like','%'.$on.'%')
                                    ->get();
                                        */
    //Si hay dos espacios, se trata de un nombre y un paterno
        } elseif (strpos($on, " ") > 0 && (strripos($on, " ") > strpos($on, " "))) {
            $otro_personal    = Personal::with('puesto','adscripcion')
                                        ->where('iestatus','=',1)
                                        ->where('cnombre_personal'   ,'like','%'.mb_strimwidth($on,                   0,strpos($on, " ")).'%')
                                        ->where('cpaterno_personal'  ,'like','%'.mb_strimwidth($on,  strpos($on, " ")+1,strlen($on)).'%')
                                        ->where('cnombre_personal'   ,'like','%'.mb_strimwidth($on,                   0,strripos($on, " ")).'%')
                                        ->orWhere('cpaterno_personal','like','%'.mb_strimwidth($on,strripos($on, " ")+1,strlen($on)).'%')
                                        ->get();
            /*
            $otro_personal    = DB::table('tcpersonal as pers')
                                    ->Join('tcpuestos as pst','pers.iid_puesto','=','pst.iid_puesto')
                                    ->Join('tcadscripciones as adsc','pers.iid_adscripcion','=','adsc.iid_adscripcion')
                                    ->select('pers.*','pst.*','adsc.*')
                                    ->where('pers.iestatus','=',1)
                                    ->where('pers.cnombre_personal'   ,'like','%'.mb_strimwidth($on,                   0,strpos($on, " ")).'%')
                                    ->where('pers.cpaterno_personal'  ,'like','%'.mb_strimwidth($on,  strpos($on, " ")+1,strlen($on)).'%')
                                    ->where('pers.cnombre_personal'   ,'like','%'.mb_strimwidth($on,                   0,strripos($on, " ")).'%')
                                    ->orWhere('pers.cpaterno_personal','like','%'.mb_strimwidth($on,strripos($on, " ")+1,strlen($on)).'%')
                                    ->get();
                                        */
        }

        if(!$otro_personal->isEmpty() && $otro_personal[0]->iestatus==1){
            return response()->json(
                [
                    'otro_personal'=> $otro_personal,
                    'exito'        => 1
                ]
            );
        } else {
            return response()->json(
                [
                    'otro_personal'=> null,
                    'exito'        => 0
                ]
            );
        }
    }
}
