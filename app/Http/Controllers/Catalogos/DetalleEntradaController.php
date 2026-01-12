<?php
namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\DetalleEntrada;
use App\Models\Servicios\Bitacora;

class DetalleEntradaController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $detalle = $request->detalle ?? '';
        if ($detalle != "") {
            $data['detalleEntradas'] = DetalleEntrada::where('cdescripcion_detalle','like','%'.$detalle.'%')
                                                      ->where('iestatus',1)
                                                      ->orderBy('cdescripcion_detalle')
                                                      ->get();
        } else {
            $data['detalleEntradas'] = DetalleEntrada::where('iestatus',1)
                                                      ->orderBy('cdescripcion_detalle')
                                                      ->latest()
                                                      ->take(200)
                                                      ->get();
        }
        return view('detalle_entrada.index',$data);
    }

    public function nuevo_detalle()
    {
        $detalle = new DetalleEntrada();
        $noeditar = '';
        return view('detalle_entrada.nuevo',compact('detalle','noeditar'));
    }

    public function guardar_detalle(Request $request)
    {
        if ($request->descripcion_detalle!="") {
            $existe = DetalleEntrada::where('cdescripcion_detalle',$request->descripcion_detalle)
                                     ->where('iestatus',1)->count();
            if ($existe==0) {
                $detalle = new DetalleEntrada();
                $jsonBefore = "NEW INSERT DETALLE ENTRADA";
                $detalle->cdescripcion_detalle = $request->descripcion_detalle;
                $detalle->iestatus = 1;
                $detalle->iid_usuario = auth()->id;
                $detalle->save();
                $jsonAfter = json_encode($detalle);
                DetalleEntradaController::bitacora($jsonBefore,$jsonAfter);
            } else {
                return redirect()->route('detalle_entrada.nuevo')
                                 ->with('danger','YA EXISTE un Detalle de Entrada con este Nombre.');
            }
        }
        return redirect()->route('detalle_entrada.editar',$detalle->iid_detalle)
                         ->with('success','Detalle de Entrada guardado satisfactoriamente');
    }

    public function editar_detalle($id)
    {
        $detalle = DetalleEntrada::where('iid_detalle',$id)->first();
        $noeditar = '';
        return view('detalle_entrada.editar',compact('detalle','noeditar'));
    }

    public function actualizar_detalle(Request $request)
    {
        $detalle = DetalleEntrada::where('iid_detalle',$request->id_detalle)->first();
        $jsonBefore = json_encode($detalle);

        if ($request->noeditar=="disabled") {
            $operacion = ($detalle->iestatus==0)?"RECUPERADO":"BORRADO";
            $detalle->iestatus = ($detalle->iestatus==0)?1:0;
        } else {
            $operacion = "ACTUALIZADO";
            $detalle->cdescripcion_detalle = $request->descripcion_detalle;
            $detalle->iestatus = 1;
        }

        $detalle->iid_usuario = auth()->id;
        $detalle->save();

        $jsonAfter = $operacion.' '.json_encode($detalle);
        DetalleEntradaController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('detalle_entrada.index')
                         ->with('success','Detalle de Entrada '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_detalle($id)
    {
        $detalle = DetalleEntrada::where('iid_detalle',$id)->first();
        $noeditar = 'disabled';
        return view('detalle_entrada.inhabilitar',compact('detalle','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes = ($jsonBefore==null?'NEW INSERT':$jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario = auth()->id;
        $bitacora->save();
    }

    public static function buscaDetalle(Request $request)
    {
        $ba = $request->ba;
        $lista = DetalleEntrada::where('cdescripcion_detalle','like','%'.$ba.'%')
                               ->where('iestatus',1)
                               ->get();
        if(!$lista->isEmpty()){
            return response()->json(['lista'=>$lista,'exito'=>1]);
        } else {
            return response()->json(['lista'=>null,'exito'=>0]);
        }
    }
}
