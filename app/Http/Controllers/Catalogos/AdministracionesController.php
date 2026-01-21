<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Administracion;
use App\Models\Servicios\Bitacora;

class AdministracionesController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $administracion = $request->administracion;

        if ($administracion != "") {
            $data['administraciones'] = Administracion::where('cdescripcion_administracion','like','%'.$administracion.'%')
                ->where('iestatus','=',1)
                ->get();
        } else {
            $data['administraciones'] = Administracion::where('iestatus','=',1)
                ->latest()
                ->take(200)
                ->get();
        }

        return view('administraciones.index', $data);
    }

    public function nueva_administracion()
    {
        $administracion = new Administracion();
        $noeditar = '';
        return view('administraciones.nueva', compact('administracion','noeditar'));
    }

    // modal
    public function guardar_administracion(Request $request)
    {
        $request->validate([
            'descripcion_administracion' => 'required|max:120'
        ]);

        $ya_hay_administracion = Administracion::where('cdescripcion_administracion', $request->descripcion_administracion)
            ->where('iestatus', 1)
            ->count();

        if ($ya_hay_administracion > 0) {
            return redirect()->route('administraciones.index')
                ->withInput()
                ->with('danger','YA EXISTE una Administración con este Nombre Guardado Previamente. Verifique.');
        }

        $administracion = new Administracion();
        $jsonBefore = "NEW INSERT ADMINISTRACIÓN";

        $administracion->cdescripcion_administracion = $request->descripcion_administracion;
        $administracion->iestatus = 1;
        $administracion->iid_usuario = auth()->id(); 
        $administracion->save();

        $jsonAfter = json_encode($administracion);
        AdministracionesController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('administraciones.index')
            ->with('success','Administración guardada satisfactoriamente');
    }

    public function editar_administracion(string $id_administracion)
    {
        $administracion = Administracion::where('iid_administracion','=',$id_administracion)
            ->where('iestatus','=',1)
            ->first();

        $noeditar = '';
        return view('administraciones.editar', compact('administracion','noeditar'));
    }

    public function actualizar_administracion(Request $request)
    {
        $administracion = Administracion::where('iid_administracion','=',$request->id_administracion)->first();
        $jsonBefore = json_encode($administracion);

        if ($request->noeditar == "disabled") {
            if ($administracion->iestatus == 0) {
                $operacion = "RECUPERADA";
                $administracion->iestatus = 1;
            } else {
                $operacion = "BORRADA";
                $administracion->iestatus = 0;
            }
        } else {
            $operacion = "ACTUALIZADA";
            $administracion->cdescripcion_administracion = $request->descripcion_administracion;
            $administracion->iestatus = 1;
        }

        $administracion->iid_usuario = auth()->id();
        $administracion->save();

        $jsonAfter = $operacion.' '.json_encode($administracion);
        AdministracionesController::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('administraciones.index')
            ->with('success','Administración '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_administracion(string $id_administracion)
    {
        $administracion = Administracion::where('iid_administracion','=',$id_administracion)
            ->where('iestatus','=',1)
            ->first();

        $noeditar = 'disabled';
        return view('administraciones.inhabilitar', compact('administracion','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->id(); 
        $bitacora->save();
    }
}
