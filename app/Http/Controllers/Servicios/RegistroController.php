<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// MODELOS (ajusta namespaces si los tienes diferentes)
use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\OrdenesServicio;

class RegistroController extends Controller
{
    /**
     * Vista principal: registro/index
     * Carga catálogos: Área (Administración), Solicitante (Personal), Taller, Cuadrillas
     */
    public function index()
    {
        $administracion = Administracion::query()
            ->when(\Schema::hasColumn((new Administracion)->getTable(), 'iestatus'), fn($q) => $q->where('iestatus', 1))
            ->orderBy('cdescripcion_administracion')
            ->get();

        $personal_solicitante = Personal::query()
            ->when(\Schema::hasColumn((new Personal)->getTable(), 'iestatus'), fn($q) => $q->where('iestatus', 1))
            ->orderBy('cnombre_personal')
            ->get();

        $talleres = Taller::query()
            ->when(\Schema::hasColumn((new Taller)->getTable(), 'iestatus'), fn($q) => $q->where('iestatus', 1))
            ->orderBy('cdescripcion_taller')
            ->get();

        $cuadrilla = Cuadrilla::query()
            ->when(\Schema::hasColumn((new Cuadrilla)->getTable(), 'iestatus'), fn($q) => $q->where('iestatus', 1))
            ->orderBy('cnombre_cuadrilla')
            ->get();

        return view('registro.index', compact('administracion', 'personal_solicitante', 'talleres', 'cuadrilla'));
    }

    /**
     * AJAX: devuelve el siguiente folio del año en formato YYYY/0001
     * Reinicia cada año porque busca max(consecutivo) por anio.
     */
    public function folioActual()
    {
        $anio = (int) now()->format('Y');

        // último consecutivo del año (si no hay, null)
        $ultimo = OrdenesServicio::where('anio', $anio)->max('consecutivo');
        $consecutivo = ($ultimo ?? 0) + 1;

        // folio: 2026/0021 (4 dígitos con ceros)
        $folio = $anio . '/' . str_pad((string)$consecutivo, 4, '0', STR_PAD_LEFT);

        return response()->json([
            'anio' => $anio,
            'consecutivo' => $consecutivo,
            'folio' => $folio,
        ]);
    }

    /**
     * Guarda la orden desde el modal.
     * - Solicitud: se guarda NOW() (no editable)
     * - Folio: se recalcula aquí en transacción para evitar duplicados
     * - Conclusión: opcional (datetime-local -> se parsea)
     * - Asignación: personal multi o cuadrilla multi (pivotes)
     */
    public function guardar(Request $request)
    {
        // Validación alineada a lo que pides
        $request->validate([
            'area' => ['required', 'integer'],
            'solicitante' => ['required', 'integer'],
            'taller' => ['required', 'integer'],
            'descripcion_servicio' => ['required', 'string', 'max:500'],

            // datetime-local: llega como "YYYY-MM-DDTHH:MM" o vacío
            'conclusion' => ['nullable', 'string'],

            // radios
            'tipo_asignacion' => ['required', 'in:personal,cuadrilla'],

            // multi
            'personal_ids' => ['nullable', 'array'],
            'personal_ids.*' => ['integer'],

            'cuadrilla_ids' => ['nullable', 'array'],
            'cuadrilla_ids.*' => ['integer'],

            'observaciones' => ['nullable', 'string', 'max:255'],
        ], [
            'area.required' => 'Selecciona un área.',
            'solicitante.required' => 'Selecciona un solicitante.',
            'taller.required' => 'Selecciona un taller.',
            'descripcion_servicio.required' => 'Agrega la descripción del servicio.',
        ]);

        return DB::transaction(function () use ($request) {

            // 1) Consecutivo por año (seguro en BD)
            $anio = (int) now()->format('Y');
            $ultimo = OrdenesServicio::where('anio', $anio)->lockForUpdate()->max('consecutivo');
            $consecutivo = ($ultimo ?? 0) + 1;

            $folio = $anio . '/' . str_pad((string)$consecutivo, 4, '0', STR_PAD_LEFT);

            // 2) Parseo de conclusión si viene
            $fechaConclusion = null;
            if ($request->filled('conclusion')) {
                try {
                    // datetime-local: 2026-02-03T11:27
                    $fechaConclusion = Carbon::createFromFormat('Y-m-d\TH:i', $request->conclusion);
                } catch (\Throwable $e) {
                    $fechaConclusion = null;
                }
            }

            // 3) Crear servicio (ajusta nombres de columnas si difieren)
            $serv = new OrdenesServicio();
            $serv->anio = $anio;
            $serv->consecutivo = $consecutivo;

            // Si en tu tabla el folio se llama cfolio, cámbialo aquí:
            $serv->cfolio = $folio;

            // Solicitud automática
            $serv->dfecha_solicitud = now();

            // Conclusión opcional
            $serv->dfecha_conclusion = $fechaConclusion;

            // Catálogos
            $serv->iid_administracion = $request->area;
            $serv->iid_personal_solicitante = $request->solicitante;
            $serv->iid_taller = $request->taller;

            // Descripción
            $serv->cdescripcion_servicio = $request->descripcion_servicio;

            // Observaciones (nulo permitido)
            $serv->cobservaciones = $request->observaciones;

            $serv->save();

            // 4) Asignación: guarda en pivotes según radio seleccionado
            if ($request->tipo_asignacion === 'personal') {

                // Personal multi -> tabla pivote: taservicio_personal
                $ids = $request->input('personal_ids', []);
                if (!empty($ids)) {
                    $rows = [];
                    foreach ($ids as $pid) {
                        $rows[] = [
                            'iid_servicio' => $serv->iid_servicio,
                            'iid_personal' => $pid,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    DB::table('taservicio_personal')->insert($rows);
                }

            } else {

                // Cuadrilla multi -> tabla pivote: taservicio_cuadrilla
                $ids = $request->input('cuadrilla_ids', []);
                if (!empty($ids)) {
                    $rows = [];
                    foreach ($ids as $cid) {
                        $rows[] = [
                            'iid_servicio' => $serv->iid_servicio,
                            'iid_cuadrilla' => $cid,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    DB::table('taservicio_cuadrilla')->insert($rows);
                }
            }

            // 5) Regresa con folio final
            return redirect()
                ->back()
                ->with('success', "Orden creada con folio: {$folio}");
        });
    }
}
