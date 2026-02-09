<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\OrdenesServicio;

class RegistroController extends Controller
{
    public function index(Request $request)
    {
        $administracion = Administracion::query()
            ->when(
                Schema::hasColumn((new Administracion)->getTable(), 'iestatus'),
                fn ($q) => $q->where('iestatus', 1)
            )
            ->orderBy('cdescripcion_administracion')
            ->get();

        $personal_solicitante = Personal::query()
            ->when(
                Schema::hasColumn((new Personal)->getTable(), 'iestatus'),
                fn ($q) => $q->where('iestatus', 1)
            )
            ->orderBy('cnombre_personal')
            ->get();

        $talleres = Taller::query()
            ->when(
                Schema::hasColumn((new Taller)->getTable(), 'iestatus'),
                fn ($q) => $q->where('iestatus', 1)
            )
            ->orderBy('cdescripcion_taller')
            ->get();

        $cuadrilla = Cuadrilla::query()
            ->when(
                Schema::hasColumn((new Cuadrilla)->getTable(), 'iestatus'),
                fn ($q) => $q->where('iestatus', 1)
            )
            ->orderBy('cnombre_cuadrilla')
            ->get();

        $personal_catalogo = $personal_solicitante;

        return view('registro.index', compact(
            'administracion',
            'personal_solicitante',
            'personal_catalogo',
            'talleres',
            'cuadrilla'
        ));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'area' => 'required|integer',
            'solicitante' => 'required|integer',
            'taller' => 'required|integer',
            'descripcion_servicio' => 'required|string|max:2000',

            'tipo_asignacion' => 'required|in:personal,cuadrilla',
            'personal' => 'required|array|min:1',
            'personal.*' => 'required|integer',

            'folio' => 'required|string|max:20',
            'anio_folio' => 'required|integer',
            'consecutivo_folio' => 'required|integer',
            'fecha_solicitud' => 'required|string|max:30',

            'conclusion' => 'nullable',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $orden = new OrdenesServicio();

        $orden->folio = $request->folio;
        $orden->anio_folio = (int) $request->anio_folio;
        $orden->consecutivo_folio = (int) $request->consecutivo_folio;

        $orden->fecha_solicitud = $request->fecha_solicitud;
        $orden->conclusion = $request->conclusion;

        $orden->iid_area = (int) $request->area;
        $orden->iid_solicitante = (int) $request->solicitante;
        $orden->iid_taller = (int) $request->taller;

        $orden->descripcion_servicio = $request->descripcion_servicio;
        $orden->observaciones = $request->observaciones;
        $orden->tipo_asignacion = $request->tipo_asignacion;

        if (Schema::hasColumn($orden->getTable(), 'asignados')) {
            $orden->asignados = json_encode(array_values($request->personal));
        }

        if (Schema::hasColumn($orden->getTable(), 'iestatus')) {
            $orden->iestatus = 1;
        }

        if (Schema::hasColumn($orden->getTable(), 'iid_usuario')) {
            $orden->iid_usuario = auth()->id();
        }

        $orden->save();

        return response()->json([
            'ok' => true,
            'id' => $orden->getKey(),
            'folio' => $orden->folio
        ], 200);
    }
}