<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Puesto;
use App\Models\Servicios\Bitacora;

class PuestosController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $puesto = $request->puesto;
        if ($puesto != "") {
            $data['puestos'] = Puesto::where('cdescripcion_puesto','like','%'.$puesto.'%')
                ->where('iestatus',1)->orderBy('cdescripcion_puesto')->get();
        } else {
            $data['puestos'] = Puesto::where('iestatus',1)
                ->orderBy('cdescripcion_puesto')->latest()->take(200)->get();
        }
        return view('puestos.index',$data);
    }

    public function nuevo_puesto()
    {
        $puesto = new Puesto();
        $noeditar = '';
        return view('puestos.nuevo',compact('puesto','noeditar'));
    }

    public function guardar_puesto(Request $request)
    {
        if(trim((string)$request->descripcion_puesto)==""){
            return redirect()->route('puestos.index')
                ->with('danger','La descripción es obligatoria.');
        }

        $ya_hay = Puesto::where('cdescripcion_puesto',$request->descripcion_puesto)
            ->where('iestatus',1)->count();

        if($ya_hay>0){
            return redirect()->route('puestos.index')
                ->with('danger','YA EXISTE un Puesto con este Nombre.');
        }

        $puesto = new Puesto();
        $jsonBefore = "NEW INSERT PUESTO";
        $puesto->cdescripcion_puesto = $request->descripcion_puesto;
        $puesto->iestatus = 1;
        $puesto->iid_usuario = auth()->id();   // CORRECTO
        $puesto->save();

        self::bitacora($jsonBefore,json_encode($puesto));

        return redirect()->route('puestos.index')
            ->with('success','Puesto guardado satisfactoriamente');
    }

    public function editar_puesto($id_puesto)
    {
        $puesto = Puesto::where('iid_puesto',$id_puesto)->first();
        $noeditar = '';
        return view('puestos.editar',compact('puesto','noeditar'));
    }

    public function actualizar_puesto(Request $request)
    {
        $puesto = Puesto::where('iid_puesto',$request->id_puesto)->first();
        $jsonBefore = json_encode($puesto);

        if($request->noeditar=="disabled"){
            if($puesto->iestatus==0){
                $operacion="RECUPERADO";
                $puesto->iestatus=1;
            }else{
                $operacion="BORRADO";
                $puesto->iestatus=0;
            }
        }else{
            $operacion="ACTUALIZADO";
            $puesto->cdescripcion_puesto=$request->descripcion_puesto;
            $puesto->iestatus=1;
        }

        $puesto->iid_usuario = auth()->id();   // CORRECTO
        $puesto->save();

        self::bitacora($jsonBefore,$operacion.' '.json_encode($puesto));

        return redirect()->route('puestos.index')
            ->with('success','Puesto '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_puesto($id_puesto)
    {
        $puesto = Puesto::where('iid_puesto',$id_puesto)->first();
        $noeditar = 'disabled';
        return view('puestos.inhabilitar',compact('puesto','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes = ($jsonBefore==null?'NEW INSERT':$jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario = auth()->id(); // CORRECTO
        $bitacora->save();
    }

    public static function buscaPuestos(Request $request)
    {
        $bp = $request->bp;
        $lista = Puesto::where('cdescripcion_puesto','like','%'.$bp.'%')
            ->where('iestatus',1)->get();

        return response()->json([
            'listaPstos'=>$lista->isEmpty()?null:$lista,
            'exito'=>$lista->isEmpty()?0:1
        ]);
    }
}
