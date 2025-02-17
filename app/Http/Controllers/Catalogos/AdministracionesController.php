<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Administracion;
use App\Models\Servicios\Bitacora;

use Mpdf\Mpdf;

use \stdClass;
use \Datetime;
use \DateInterval;

class AdministracionesController extends Controller
{
    //Formato de Fechas MySQL
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $administracion = $request->administracion;
        if ($administracion != "") {
            $data['administraciones'] = Administracion::where('cdescripcion_administracion','like','%'.$administracion.'%')->where('iestatus','=',1)->get();
        } else {
            $data['administraciones'] = Administracion::where('iestatus','=',1)->latest()->take(200)->get();
        }
        return view('administraciones.index',$data);
    }

    public function nueva_administracion()
    {
        $administracion     = new Administracion();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = '';
        return view('administraciones.nueva',compact('administracion','noeditar'));
    }

    public function guardar_administracion(Request $request)
    {
        if ($request->descripcion_administracion!="") {
        //Revisar que no exista una Administración con la misma Descripción
            $ya_hay_administracion                      = Administracion::where('cdescripcion_administracion','=',$request->descripcion_administracion)
                                                                        ->where('iestatus','=',1)->count();
        //Si no hay, entonces agregar al catálogo
            if ($ya_hay_administracion==0) {
                $now                                            = new \DateTime();
                $administracion                                 = new Administracion();
                $jsonBefore                                     = "NEW INSERT ADMINISTRACIÓN";
                $administracion->cdescripcion_administracion    = $request->descripcion_administracion;
                $administracion->iestatus                       = 1;
                $administracion->iid_usuario                    = auth()->user()->id;
                $administracion->save();
                $jsonAfter                                      = json_encode($administracion);
                AdministracionesController::bitacora($jsonBefore,$jsonAfter);
            } else {
                return redirect()->route('administraciones.nueva')
                                 ->with('danger','YA EXISTE una Administración con este Nombre Guardado Previamente. Verifique.');
            }
        }

        return redirect()->route('administraciones.editar',$administracion->iid_administracion)
                         ->with('success','Administración guardada satisfactoriamente');
    }

    public function editar_administracion(string $id_administracion)
    {
        $administracion     = Administracion::where('iid_administracion','=',$id_administracion)
                                          ->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = '';
        return view('administraciones.editar',compact('administracion','noeditar'));
    }

    public function actualizar_administracion(Request $request)
    {
        $now                                        = new \DateTime();
        $administracion                             = Administracion::where('iid_administracion','=',$request->id_administracion)->first();
        $jsonBefore                                 = json_encode($administracion);
        //Se Habilita o Inhabilita la Administracion
        if ($request->noeditar == "disabled") {
            if ($administracion->iestatus == 0) {
                $operacion                          = "RECUPERADA";
                $administracion->iestatus           = 1;
            } else {
                $operacion                          = "BORRADA";
                $administracion->iestatus           = 0;
            }
        } else {
            //Se actualizan los datos de la Administracion
            $operacion                                      = "ACTUALIZADA";
            $administracion->cdescripcion_administracion    = $request->descripcion_administracion;
            $administracion->iestatus                       = 1;
        }
        $administracion->iid_usuario                        = auth()->user()->id;
        $administracion->save();
        $jsonAfter                                          = $operacion.' '.json_encode($administracion);
        AdministracionesController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('administraciones.index')
                         ->with('success','Administración '.$operacion.' satisfactoriamente');
    }

    //Esta misma función se utiliza para Inhabilitar/Habilitar la Administracion
    public function confirmainhabilitar_administracion(string $id_administracion)
    {
        $administracion     = Administracion::where('iid_administracion','=',$id_administracion)->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = 'disabled';
        return view('administraciones.inhabilitar',compact('administracion','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter){
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->user()->id;
        $bitacora->save();
    }

}
