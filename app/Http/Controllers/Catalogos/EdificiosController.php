<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catalogos\Alcaldia;
use App\Models\Catalogos\Colonia;
use App\Models\Catalogos\Entidad;
use App\Models\Catalogos\CodigoPostal;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Edificio;
use App\Models\Servicios\Bitacora;

class EdificiosController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $edificio = $request->edificio;

        if ($edificio != "") {
            $edificios = Edificio::with('administracion','colonia','alcaldia','entidad','codigo_postal')
                ->where('cnombre_edificio','like','%'.$edificio.'%')
                ->where('iestatus','=',1)
                ->get();
        } else {
            $edificios = Edificio::with('administracion','colonia','alcaldia','entidad','codigo_postal')
                ->where('iestatus','=',1)
                ->latest()
                ->take(200)
                ->get();
        }

        // ✅ Para el select del modal
        $admins = Administracion::where('iestatus','=',1)
            ->orderBy('cdescripcion_administracion')
            ->get();

        // ✅ Alias por si tu vista usa $administraciones
        $administraciones = $admins;

        return view('edificios.index', compact('edificios','admins','administraciones'));
    }

    public function nuevo_edificio()
    {
        $edificio   = new Edificio();
        $colonias   = Colonia::where('iestatus','=',1)->get();
        $alcaldias  = Alcaldia::where('iestatus','=',1)->get();
        $entidades  = Entidad::where('iestatus','=',1)->get();
        $cps        = CodigoPostal::where('iestatus','=',1)->get();
        $admins     = Administracion::where('iestatus','=',1)->get();
        $noeditar   = '';

        return view('edificios.nuevo',compact('edificio','admins','colonias','alcaldias','entidades','cps','noeditar'));
    }

    public function guardar_edificio(Request $request)
    {
        if ($request->nombre_edificio == "") {
            return redirect()->route('edificios.index')
                ->with('danger','Favor de capturar el nombre del edificio.');
        }

        $ya_hay_edificio = Edificio::where('cnombre_edificio','=',$request->nombre_edificio)
            ->where('iestatus','=',1)
            ->count();

        if ($ya_hay_edificio > 0) {
            return redirect()->route('edificios.index')
                ->with('danger','YA EXISTE un Edificio con este Nombre Guardado Previamente. Verifique.');
        }

        $edificio                               = new Edificio();
        $jsonBefore                             = "NEW INSERT EDIFICIO";

        $edificio->iid_administracion           = $request->administracion;
        $edificio->cnombre_edificio             = $request->nombre_edificio;
        $edificio->ccalle                       = $request->calle;
        $edificio->cnumero_exterior             = $request->numero_exterior;
        $edificio->cnumero_interior             = $request->numero_interior;
        $edificio->iid_colonia                  = $request->colonia;
        $edificio->iid_alcaldia                 = $request->alcaldia;
        $edificio->iid_entidad                  = $request->entidad;
        $edificio->cid_codigo_postal            = $request->codigo_postal;
        $edificio->ilatitud                     = $request->latitud;
        $edificio->ilongitud                    = $request->longitud;
        $edificio->iestatus                     = 1;
        $edificio->iid_usuario                  = auth()->id();

        $edificio->save();

        $jsonAfter = json_encode($edificio);
        self::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('edificios.editar',$edificio->iid_edificio)
            ->with('success','Edificio guardado satisfactoriamente');
    }

    public function editar_edificio(string $id_edificio)
    {
        $edificio = Edificio::with('administracion','colonia','alcaldia','entidad','codigo_postal')
            ->where('iid_edificio','=',$id_edificio)
            ->where('iestatus','=',1)
            ->first();

        $colonias   = Colonia::where('iestatus','=',1)->get();
        $alcaldias  = Alcaldia::where('iestatus','=',1)->get();
        $entidades  = Entidad::where('iestatus','=',1)->get();
        $cps        = CodigoPostal::where('iestatus','=',1)->get();
        $admins     = Administracion::where('iestatus','=',1)->get();
        $noeditar   = '';

        return view('edificios.editar',compact('edificio','admins','colonias','alcaldias','entidades','cps','noeditar'));
    }

    public function actualizar_edificio(Request $request)
    {
        $edificio   = Edificio::where('iid_edificio','=',$request->id_edificio)->first();
        $jsonBefore = json_encode($edificio);

        if ($request->noeditar == "disabled") {
            if ($edificio->iestatus == 0) {
                $operacion          = "RECUPERADO";
                $edificio->iestatus = 1;
            } else {
                $operacion          = "BORRADO";
                $edificio->iestatus = 0;
            }
        } else {
            $operacion                              = "ACTUALIZADO";
            $edificio->iid_administracion           = $request->administracion;
            $edificio->cnombre_edificio             = $request->nombre_edificio;
            $edificio->ccalle                       = $request->calle;
            $edificio->cnumero_exterior             = $request->numero_exterior;
            $edificio->cnumero_interior             = $request->numero_interior;
            $edificio->iid_colonia                  = $request->colonia;
            $edificio->iid_alcaldia                 = $request->alcaldia;
            $edificio->iid_entidad                  = $request->entidad;
            $edificio->cid_codigo_postal            = $request->codigo_postal;
            $edificio->ilatitud                     = $request->latitud;
            $edificio->ilongitud                    = $request->longitud;
            $edificio->iestatus                     = 1;
        }

        $edificio->iid_usuario = auth()->id();
        $edificio->save();

        $jsonAfter = $operacion.' '.json_encode($edificio);
        self::bitacora($jsonBefore,$jsonAfter);

        return redirect()->route('edificios.index')
            ->with('success','Edificio '.$operacion.' satisfactoriamente');
    }

    public function confirmainhabilitar_edificio(string $id_edificio)
    {
        $edificio = Edificio::with('administracion','colonia','alcaldia','entidad','codigo_postal')
            ->where('iid_edificio','=',$id_edificio)
            ->where('iestatus','=',1)->first();

        $colonias   = Colonia::where('iestatus','=',1)->get();
        $alcaldias  = Alcaldia::where('iestatus','=',1)->get();
        $entidades  = Entidad::where('iestatus','=',1)->get();
        $cps        = CodigoPostal::where('iestatus','=',1)->get();
        $admins     = Administracion::where('iestatus','=',1)->get();
        $noeditar   = 'disabled';

        return view('edificios.inhabilitar',compact('edificio','admins','colonias','alcaldias','entidades','cps','noeditar'));
    }

    public static function bitacora(string $jsonBefore,string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore==null ? 'NEW INSERT': $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = auth()->id();
        $bitacora->save();
    }

    // ✅ CP -> Colonias + Alcaldía + Entidad
    public function buscaAlcaldiaColonia(Request $request)
    {
        $cp = $request->cp;

        $listaColonia = Colonia::where('cid_codigo_postal', '=', $cp)
            ->where('iestatus', '=', 1)
            ->get();

        if(!$listaColonia->isEmpty()){

            $alcaldia = Alcaldia::where('iid_alcaldia', '=', $listaColonia[0]->iid_alcaldia)
                ->where('iestatus', '=', 1)
                ->first();

            $entidad = null;
            if($alcaldia && isset($alcaldia->iid_entidad)){
                $entidad = Entidad::where('iid_entidad', '=', $alcaldia->iid_entidad)
                    ->where('iestatus', '=', 1)
                    ->first();
            }

            return response()->json([
                'listaColonia' => $listaColonia,
                'alcaldia' => $alcaldia,
                'entidad' => $entidad,
                'exito' => 1
            ]);
        }

        return response()->json([
            'listaColonia' => null,
            'alcaldia' => null,
            'entidad' => null,
            'exito' => 0
        ]);
    }

    // ✅ Administración -> Calle + Número Ext/Int
    public function buscaDireccionAdministracion(Request $request)
    {
        $id = $request->administracion;

        $admin = Administracion::where('iid_administracion', $id)
            ->where('iestatus', 1)
            ->first();

        if(!$admin){
            return response()->json([
                'exito' => 0,
                'calle' => '',
                'numero_exterior' => '',
                'numero_interior' => '',
            ]);
        }

        return response()->json([
            'exito' => 1,
            'calle' => $admin->ccalle ?? '',
            'numero_exterior' => $admin->cnumero_exterior ?? '',
            'numero_interior' => $admin->cnumero_interior ?? '',
        ]);
    }
}
