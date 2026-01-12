<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Taller;
use App\Models\Servicios\Bitacora;

use Mpdf\Mpdf;

use \stdClass;
use \Datetime;
use \DateInterval;

class TalleresController extends Controller
{
    //Formato de Fechas MySQL
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $taller = $request->taller;
        if ($taller != "") {
            $data['talleres'] = Taller::where('cdescripcion_taller','like','%'.$taller.'%')->where('iestatus','=',1)->get();
        } else {
            $data['talleres'] = Taller::where('iestatus','=',1)->latest()->take(200)->get();
        }
        return view('talleres.index',$data);
    }

    public function nuevo_taller()
    {
        $taller     = new Taller();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = '';
        return view('talleres.nuevo',compact('taller','noeditar'));
    }

    public function guardar_taller(Request $request)
    {
        if ($request->descripcion_taller!="") {
        //Revisar que no exista un Taller con la misma Descripción
            $ya_hay_taller                      = Taller::where('cdescripcion_taller','=',$request->descripcion_taller)
                                                        ->where('iestatus','=',1)->count();
        //Si no hay, entonces agregar al catálogo
            if ($ya_hay_taller==0) {
                $now                                    = new \DateTime();
                $taller                                 = new Taller();
                $jsonBefore                             = "NEW INSERT TALLER";
                $taller->cdescripcion_taller            = $request->descripcion_taller;
                $taller->iestatus                       = 1;
                $taller->iid_usuario                    = auth()->id;
                $taller->save();
                $jsonAfter                              = json_encode($taller);
                TalleresController::bitacora($jsonBefore,$jsonAfter);
            } else {
                return redirect()->route('talleres.nuevo')
                                 ->with('danger','YA EXISTE un taller con este Nombre Guardado Previamente. Verifique.');
            }
        }

        return redirect()->route('talleres.editar',$taller->iid_taller)
                         ->with('success','Taller guardado satisfactoriamente');
    }

    public function editar_taller(string $id_taller)
    {
        $taller     = Taller::where('iid_taller','=',$id_taller)
                            ->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar           = '';
        return view('talleres.editar',compact('taller','noeditar'));
    }

    public function actualizar_taller(Request $request)
    {
        $now                                = new \DateTime();
        $taller                             = Taller::where('iid_taller','=',$request->id_taller)->first();
        $jsonBefore                         = json_encode($taller);
        //Se Habilita o Inhabilita la Administracion
        if ($request->noeditar == "disabled") {
            if ($taller->iestatus == 0) {
                $operacion                  = "RECUPERADO";
                $taller->iestatus           = 1;
            } else {
                $operacion                  = "BORRADO";
                $taller->iestatus           = 0;
            }
        } else {
            //Se actualizan los datos del Taller
            $operacion                      = "ACTUALIZADO";
            $taller->cdescripcion_taller    = $request->descripcion_taller;
            $taller->iestatus               = 1;
        }
        $taller->iid_usuario                = auth()->id;
        $taller->save();
        $jsonAfter                          = $operacion.' '.json_encode($taller);
        TalleresController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('talleres.index')
                         ->with('success','Taller '.$operacion.' satisfactoriamente');
    }

    //Esta misma función se utiliza para Inhabilitar/Habilitar la Administracion
    public function confirmainhabilitar_taller(string $id_taller)
    {
        $taller     = Taller::where('iid_taller','=',$id_taller)->where('iestatus','=',1)->first();
        //Auxiliar para indicar campos deshabilitados (disabled), ''=habilitados
        $noeditar   = 'disabled';
        return view('talleres.inhabilitar',compact('taller','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter){
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->id;
        $bitacora->save();
    }

}
