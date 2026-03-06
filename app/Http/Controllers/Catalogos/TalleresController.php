<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Catalogos\Taller;
use App\Models\Servicios\Bitacora;

class TalleresController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $taller = $request->taller;

        if ($taller != "") {
            $data['talleres'] = Taller::where('cdescripcion_taller', 'like', '%' . $taller . '%')
                ->where('iestatus', 1)
                ->orderBy('cdescripcion_taller')
                ->get();
        } else {
            $data['talleres'] = Taller::where('iestatus', 1)
                ->orderBy('iid_taller', 'desc')
                ->take(200)
                ->get();
        }

        return view('talleres.index', $data);
    }

    public function nuevo_taller()
    {
        $taller   = new Taller();
        $noeditar = '';
        return view('talleres.nuevo', compact('taller', 'noeditar'));
    }

    public function guardar_taller(Request $request)
    {
        $request->validate([
            'descripcion_taller' => 'required|string|max:50',
        ]);

        // Revisar que no exista un Taller con la misma Descripción (activo)
        $ya_hay_taller = Taller::where('cdescripcion_taller', '=', $request->descripcion_taller)
            ->where('iestatus', '=', 1)
            ->count();

        if ($ya_hay_taller > 0) {
            return redirect()->route('talleres.nuevo')
                ->with('danger', 'YA EXISTE un taller con este Nombre Guardado Previamente. Verifique.')
                ->withInput();
        }

        $taller = new Taller();
        $jsonBefore = "NEW INSERT TALLER";

        $taller->cdescripcion_taller = $request->descripcion_taller;
        $taller->iestatus            = 1;

        //  SIN ERROR: si no hay sesión, Auth::id() regresa null
        $taller->iid_usuario         = Auth::id();

        $taller->save();

        $jsonAfter = json_encode($taller);
        self::bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('talleres.index', $taller->iid_taller)
            ->with('success', 'Taller guardado satisfactoriamente');
    }

    public function editar_taller(string $id_taller)
    {
        $taller = Taller::where('iid_taller', '=', $id_taller)
            ->where('iestatus', '=', 1)
            ->first();

        if (!$taller) {
            return redirect()->route('talleres.index')
                ->with('danger', 'Taller no encontrado o inhabilitado.');
        }

        $noeditar = '';
        return view('talleres.editar', compact('taller', 'noeditar'));
    }

    public function actualizar_taller(Request $request)
    {
        $request->validate([
            'id_taller' => 'required|integer',
            'descripcion_taller' => 'nullable|string|max:50',
            'noeditar' => 'nullable|string',
        ]);

        $taller = Taller::where('iid_taller', '=', $request->id_taller)->first();

        if (!$taller) {
            return redirect()->route('talleres.index')
                ->with('danger', 'Taller no encontrado.');
        }

        $jsonBefore = json_encode($taller);

        if ($request->noeditar === "disabled") {
            if ((int)$taller->iestatus === 0) {
                $operacion = "RECUPERADO";
                $taller->iestatus = 1;
            } else {
                $operacion = "BORRADO";
                $taller->iestatus = 0;
            }
        } else {
            $request->validate([
                'descripcion_taller' => 'required|string|max:50',
            ]);

            $operacion = "ACTUALIZADO";
            $taller->cdescripcion_taller = $request->descripcion_taller;
            $taller->iestatus = 1;
        }

        //  SIN ERROR
        $taller->iid_usuario = Auth::id();
        $taller->save();

        $jsonAfter = $operacion . ' ' . json_encode($taller);
        self::bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('talleres.index')
            ->with('success', 'Taller ' . $operacion . ' satisfactoriamente');
    }

    public function confirmainhabilitar_taller(string $id_taller)
    {
        $taller = Taller::where('iid_taller', '=', $id_taller)->first();

        if (!$taller) {
            return redirect()->route('talleres.index')
                ->with('danger', 'Taller no encontrado.');
        }

        $noeditar = 'disabled';
        return view('talleres.inhabilitar', compact('taller', 'noeditar'));
    }

    public static function bitacora(?string $jsonBefore, string $jsonAfter)
    {
        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = ($jsonBefore == null ? 'NEW INSERT' : $jsonBefore);
        $bitacora->cjson_despues = $jsonAfter;

        //  SIN ERROR
        $bitacora->iid_usuario   = Auth::id();

        $bitacora->save();
    }
}
