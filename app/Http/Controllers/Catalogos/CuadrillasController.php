<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\Bitacora;

use Mpdf\Mpdf;

use \stdClass;
use \Datetime;
use \DateInterval;

class CuadrillasController extends Controller
{
    //Formato de Fechas MySQL
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $cuadrilla = $request->cuadrilla;
        if ($cuadrilla != "") {
            $data['cuadrillas'] = Cuadrilla::where('cnombre_cuadrilla','like','%'.$cuadrilla.'%')->where('iestatus','=',1)->get();
        } else {
            $data['cuadrillas'] = Cuadrilla::where('iestatus','=',1)->latest()->take(200)->get();
        }
        return view('cuadrillas.index',$data);
    }

    public function nueva_cuadrilla()
    {
        $cuadrilla      = new Cuadrilla();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar       = '';
        return view('cuadrillas.nueva',compact('cuadrilla','noeditar'));
    }

    public function guardar_cuadrilla(Request $request)
    {
        if ($request->nombre_cuadrilla!="") {
        //Revisar que no exista una Cuadrilla con la misma Descripción
            $ya_hay_cuadrilla                   = Cuadrilla::where('cnombre_cuadrilla','=',$request->nombre_cuadrilla)
                                                           ->where('iestatus','=',1)->count();
        //Si no hay, entonces agregar al catálogo
            if ($ya_hay_cuadrilla==0) {
                $now                                    = new \DateTime();
                $cuadrilla                              = new cuadrilla();
                $jsonBefore                             = "NEW INSERT CUADRILLA";
                $cuadrilla->cnombre_cuadrilla           = $request->nombre_cuadrilla;
                $cuadrilla->iestatus                    = 1;
                $cuadrilla->iid_usuario                 = auth()->user()->id;
                $cuadrilla->save();
                $jsonAfter                              = json_encode($cuadrilla);
                CuadrillasController::bitacora($jsonBefore,$jsonAfter);
            } else {
                return redirect()->route('cuadrillas.nueva')
                                 ->with('danger','YA EXISTE una Cuadrilla con este Nombre Guardado Previamente. Verifique.');
            }
        }

        return redirect()->route('cuadrillas.editar',$cuadrilla->iid_cuadrilla)
                         ->with('success','Cuadrilla guardada satisfactoriamente');
    }

    public function editar_cuadrilla(string $id_cuadrilla)
    {
        $cuadrilla     = Cuadrilla::where('iid_cuadrilla','=',$id_cuadrilla)
                                  ->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = '';
        return view('cuadrillas.editar',compact('cuadrilla','noeditar'));
    }

    public function actualizar_cuadrilla(Request $request)
    {
        $now                                = new \DateTime();
        $cuadrilla                          = Cuadrilla::where('iid_cuadrilla','=',$request->id_cuadrilla)->first();
        $jsonBefore                         = json_encode($cuadrilla);
        //Se Habilita o Inhabilita la Cuadrilla
        if ($request->noeditar == "disabled") {
            if ($cuadrilla->iestatus == 0) {
                $operacion                  = "RECUPERADA";
                $cuadrilla->iestatus        = 1;
            } else {
                $operacion                  = "BORRADA";
                $cuadrilla->iestatus        = 0;
            }
        } else {
            //Se actualizan los datos de la Cuadrilla
            $operacion                      = "ACTUALIZADA";
            $cuadrilla->cnombre_cuadrilla   = $request->nombre_cuadrilla;
            $cuadrilla->iestatus            = 1;
        }
        $cuadrilla->iid_usuario             = auth()->user()->id;
        $cuadrilla->save();
        $jsonAfter                          = $operacion.' '.json_encode($cuadrilla);
        CuadrillasController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('cuadrillas.index')
                         ->with('success','Cuadrilla '.$operacion.' satisfactoriamente');
    }

    //Esta misma función se utiliza para Inhabilitar/Habilitar la Cuadrilla
    public function confirmainhabilitar_cuadrilla(string $id_cuadrilla)
    {
        $cuadrilla  = Cuadrilla::where('iid_cuadrilla','=',$id_cuadrilla)->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar   = 'disabled';
        return view('cuadrillas.inhabilitar',compact('cuadrilla','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter){
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->user()->id;
        $bitacora->save();
    }

}
