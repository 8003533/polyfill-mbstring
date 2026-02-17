<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\Bitacora;

class CuadrillasController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $cuadrilla = $request->cuadrilla;
        if ($cuadrilla != "") {
            $data['cuadrillas'] = Cuadrilla::where('cnombre_cuadrilla','like','%'.$cuadrilla.'%')
                ->where('iestatus',1)->get();
        } else {
            $data['cuadrillas'] = Cuadrilla::where('iestatus',1)
                ->latest()->take(200)->get();
        }
        return view('cuadrillas.index',$data);
    }

    public function nueva_cuadrilla()
    {
        $cuadrilla = new Cuadrilla();
        $noeditar = '';
        return view('cuadrillas.nueva',compact('cuadrilla','noeditar'));
    }

    public function guardar_cuadrilla(Request $request)
    {
        if(trim((string)$request->nombre_cuadrilla)==""){
            return redirect()->route('cuadrillas.index')
                ->with('danger','El nombre de la cuadrilla es obligatorio.');
        }

        $ya_hay = Cuadrilla::where('cnombre_cuadrilla',$request->nombre_cuadrilla)
            ->where('iestatus',1)->count();

        if($ya_hay>0){
            return redirect()->route('cuadrillas.index')
                ->with('danger','YA EXISTE una Cuadrilla con este Nombre.');
        }

        $cuadrilla = new Cuadrilla();
        $jsonBefore = "NEW INSERT CUADRILLA";
        $cuadrilla->cnombre_cuadrilla = $request->nombre_cuadrilla;
        $cuadrilla->iestatus = 1;
        $cuadrilla->iid_usuario = auth()->id();   // CORREGIDO
        $cuadrilla->save();

        self::bitacora($jsonBefore,json_encode($cuadrilla));

        // Igual que Administraciones: regresar al index
        return redirect()->route('cuadrillas.index')
            ->with('success','Cuadrilla guardada satisfactoriamente');
    }

    public function editar_cuadrilla(string $id_cuadrilla)
    {
        $cuadrilla = Cuadrilla::where('iid_cuadrilla',$id_cuadrilla)->first();
        $noeditar = '';
        return view('cuadrillas.editar',compact('cuadrilla','noeditar'));
    }

    public function actualizar_cuadrilla(Request $request)
    {
        $cuadrilla = Cuadrilla::where('iid_cuadrilla',$request->id_cuadrilla)->first();
        $jsonBefore = json_encode($cuadrilla);

        if($request->noeditar=="disabled"){
            if($cuadrilla->iestatus==0){
                $operacion="RECUPERADA";
                $cuadrilla->iestatus=1;
            }else{
                $operacion="BORRADA";
                $cuadrilla->iestatus=0;
            }
        }else{
            $operacion="ACTUALIZADA";
            $cuadrilla->cnombre_cuadrilla = $request->nombre_cuadrilla;
            $cuadrilla->iestatus = 1;
        }

        $cuadrilla->iid_usuario = auth()->id();   // CORREGIDO
        $cuadrilla->save();

        self::bitacora($jsonBefore,$operacion.' '.json_encode($cuadrilla));

        return redirect()->route('cuadrillas.index')
            ->with('success','Cuadrilla '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_cuadrilla(string $id_cuadrilla)
    {
        $cuadrilla = Cuadrilla::where('iid_cuadrilla',$id_cuadrilla)->first();
        $noeditar = 'disabled';
        return view('cuadrillas.inhabilitar',compact('cuadrilla','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes = ($jsonBefore==null?'NEW INSERT':$jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario = auth()->id(); // CORREGIDO
        $bitacora->save();
    }
}
