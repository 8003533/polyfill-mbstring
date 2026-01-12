<?php
namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\DetalleSalida;
use App\Models\Servicios\Bitacora;

class DetalleSalidaController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $detalle = $request->detalle ?? '';
        if ($detalle != "") {
            $data['detalleSalidas'] = DetalleSalida::where('cdescripcion_detalle','like','%'.$detalle.'%')
                                                   ->where('iestatus',1)
                                                   ->orderBy('cdescripcion_detalle')
                                                   ->get();
        } else {
            $data['detalleSalidas'] = DetalleSalida::where('iestatus',1)
                                                   ->orderBy('cdescripcion_detalle')
                                                   ->latest()
                                                   ->take(200)
                                                   ->get();
        }
        return view('detalle_salida.index',$data);
    }

    public function nuevo_detalle()
    {
        $detalle = new DetalleSalida();
        $noeditar = '';
        return view('detalle_salida.nuevo',compact('detalle','noeditar'));
    }

    public function guardar_detalle(Request $request)
    {
        if ($request->descripcion_detalle!="") {
            $existe = DetalleSalida::where('cdescripcion_detalle',$request->descripcion_detalle)
                                    ->where('iestatus',1)->count();
            if ($existe==0) {
                $detalle = new DetalleSalida();
                $jsonBefore = "NEW INSERT DETALLE SALIDA";
                $detalle->cdescripcion_detalle = $request->descripcion_detalle;
                $detalle->iestatus = 1;
                $detalle->iid_usuario = auth()->user()->id;
                $detalle->save();
                $jsonAfter = json_encode($detalle);
                DetalleSalidaController::bitacora($jsonBefore,$jsonAfter);
            } else {
                return redirect()->route('detalle_salida.nuevo')
                                 ->with('danger','YA EXISTE un Detalle de Salida con este Nombre.');
            }
        }
        return redirect()->route('detalle_salida.editar',$detalle->iid_detalle)
                         ->with('success','Detalle de Salida guardado satisfactoriamente');
    }

    public function editar_detalle($id)
    {
        $detalle = DetalleSalida::where('iid_detalle',$id)->first();
        $noeditar = '';
        return view('detalle_salida.editar',compact('detalle','noeditar'));
    }

    public function actualizar_detalle(Request $request)
    {
        $detalle = DetalleSalida::where('iid_detalle',$request->id_detalle)->first();
        $jsonBefore = json_encode($detalle);

        if ($request->noeditar=="disabled") {
            $operacion = ($detalle->iestatus==0)?"RECUPERADO":"BORRADO";
            $detalle->iestatus = ($detalle->iestatus==0)?1:0;
        } else {
            $operacion = "ACTUALIZADO";
            $detalle->cdescripcion_detalle = $request->descripcion_detalle;
            $detalle->iestatus = 1;
        }

        $detalle->iid_usuario = auth()->user()->id;
        $detalle->save();

        $jsonAfter = $operacion.' '.json_encode($detalle);
        DetalleSalidaController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('detalle_salida.index')
                         ->with('success','Detalle de Salida '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_detalle($id)
    {
        $detalle = DetalleSalida::where('iid_detalle',$id)->first();
        $noeditar = 'disabled';
        return view('detalle_salida.inhabilitar',compact('detalle','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes = ($jsonBefore==null?'NEW INSERT':$jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario = auth()->user()->id;
        $bitacora->save();
    }

    public static function buscaDetalle(Request $request)
    {
        $ba = $request->ba;
        $lista = DetalleSalida::where('cdescripcion_detalle','like','%'.$ba.'%')
                              ->where('iestatus',1)
                              ->get();
        if(!$lista->isEmpty()){
            return response()->json(['lista'=>$lista,'exito'=>1]);
        } else {
            return response()->json(['lista'=>null,'exito'=>0]);
        }
    }
}
