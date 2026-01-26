<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadosController extends Controller
{
    public function index(Request $request)
    {
        // ===== CATÁLOGOS (solo activos) =====
        $adscripciones = DB::table('tcadscripciones')
            ->where('iestatus', 1)
            ->orderBy('cdescripcion_adscripcion')
            ->get();

        $puestos = DB::table('tcpuestos')
            ->where('iestatus', 1)
            ->orderBy('cdescripcion_puesto')
            ->get();

        $talleres = DB::table('tctalleres')
            ->where('iestatus', 1)
            ->orderBy('cdescripcion_taller')
            ->get();

        $cuadrillas = DB::table('tccuadrillas')
            ->where('iestatus', 1)
            ->orderBy('cnombre_cuadrilla')
            ->get();

        // ===== EMPLEADOS + JOINS =====
        $empleados = DB::table('tcempleados_talleres as e')
            ->leftJoin('tcpuestos as p', 'p.iid_puesto', '=', 'e.iid_puesto')
            ->leftJoin('tcadscripciones as a', 'a.iid_adscripcion', '=', 'e.iid_adscripcion')
            ->leftJoin('tctalleres as t', 't.iid_taller', '=', 'e.iid_taller')
            ->leftJoin('tccuadrillas as c', 'c.iid_cuadrilla', '=', 'e.iid_cuadrilla')
            ->select(
                'e.*',
                DB::raw('IFNULL(p.cdescripcion_puesto,"-") as cdescripcion_puesto'),
                DB::raw('IFNULL(a.cdescripcion_adscripcion,"-") as cdescripcion_adscripcion'),
                DB::raw('IFNULL(t.cdescripcion_taller,"-") as cdescripcion_taller'),
                DB::raw('IFNULL(c.cnombre_cuadrilla,"-") as cnombre_cuadrilla')
            )
            ->where('e.iestatus', 1) // si quieres mostrar solo activos
            ->orderBy('e.iid_empleado_taller', 'desc')
            ->get();

        return view('empleados.index', compact(
            'empleados',
            'adscripciones',
            'puestos',
            'talleres',
            'cuadrillas'
        ));
    }

    public function guardar_empleado(Request $request)
    {
        $request->validate([
            'cnombre_empleado_taller'   => 'required|string|max:50',
            'cpaterno_empleado_taller'  => 'required|string|max:50',
            'cmaterno_empleado_taller'  => 'nullable|string|max:50',

            'iid_adscripcion' => 'nullable|integer|exists:tcadscripciones,iid_adscripcion',
            'iid_puesto'      => 'nullable|integer|exists:tcpuestos,iid_puesto',
            'iid_taller'      => 'nullable|integer|exists:tctalleres,iid_taller',
            'iid_cuadrilla'   => 'nullable|integer|exists:tccuadrillas,iid_cuadrilla',

            'ccorreo_electronico' => 'nullable|email|max:150',
        ]);

        DB::table('tcempleados_talleres')->insert([
            'cnombre_empleado_taller'   => $request->cnombre_empleado_taller,
            'cpaterno_empleado_taller'  => $request->cpaterno_empleado_taller,
            'cmaterno_empleado_taller'  => $request->cmaterno_empleado_taller,
            'iid_adscripcion'           => $request->iid_adscripcion,
            'iid_puesto'                => $request->iid_puesto,
            'iid_taller'                => $request->iid_taller,
            'iid_cuadrilla'             => $request->iid_cuadrilla,
            'ccorreo_electronico'       => $request->ccorreo_electronico,
            'iestatus'                  => 1,
            'iid_usuario'               => null, // si luego lo manejas con auth lo ponemos
            'created_at'                => now(),
            'updated_at'                => now(),
        ]);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado creado correctamente.');
    }
}
