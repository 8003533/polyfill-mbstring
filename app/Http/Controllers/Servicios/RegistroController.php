<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\OrdenesServicio;

class RegistroController extends Controller
{
    /**
     * Vista principal del registro de órdenes
     */
    public function index(Request $request)
    {
        $administracion = Administracion::all();
        $personal_solicitante = Personal::all();
        $talleres = Taller::all();
        $cuadrilla = Cuadrilla::all();

        return view('registro.index', compact('administracion','personal_solicitante','talleres','cuadrilla'));
    }

    /**
     * AJAX: siguiente folio del año (reinicia cada año)
     * Formato: consecutivo/anio -> 1/2025
     */
    public function folioActual()
    {
        $anio = (int) now()->format('Y');

        $ultimo = OrdenesServicio::where('anio', $anio)->max('consecutivo');
        $consecutivo = ($ultimo ?? 0) + 1;

        $folio = $consecutivo . '/' . $anio;

        return response()->json([
            'anio' => $anio,
            'consecutivo' => $consecutivo,
            'folio' => $folio
        ]);
    }

    /**
     * Guardar orden del modal
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'area' => ['required','integer'],
            'solicitante' => ['required','integer'],
            'taller' => ['required','integer'],
            'descripcion_servicio' => ['required','string','max:500'],

            // solicitud automatica (formato DB)
            'fecha_solicitud' => ['required','date_format:Y-m-d H:i:s'],

            // conclusion manual (nullable)
            'conclusion' => ['nullable','string','max:50'],

            // asignación
            'tipo_asignacion' => ['required','in:personal,cuadrilla'],
            'personal_ids' => ['nullable','array'],
            'personal_ids.*' => ['integer'],
            'cuadrilla' => ['nullable','integer'],

            // observaciones nulo
            'observaciones' => ['nullable','string','max:255'],

            // folio calculado
            'anio' => ['required','integer'],
            'consecutivo' => ['required','integer'],
            'folio' => ['required','string','max:50'],
        ], [
            'area.required' => 'Selecciona un área.',
            'solicitante.required' => 'Selecciona un solicitante.',
            'taller.required' => 'Selecciona un taller.',
            'descripcion_servicio.required' => 'Agrega la descripción del servicio.',
        ]);

        return DB::transaction(function() use ($request){

            $anio = (int) $request->anio;

            // ✅ Evita colisiones si dos usuarios abren modal al mismo tiempo
            $ultimo = OrdenesServicio::where('anio', $anio)->lockForUpdate()->max('consecutivo');
            $consecutivo = ($ultimo ?? 0) + 1;
            $folio = $consecutivo . '/' . $anio;

            // Fechas
            $fechaSolicitud = Carbon::createFromFormat('Y-m-d H:i:s', $request->fecha_solicitud);

            $fechaConclusion = null;
            if ($request->filled('conclusion')) {
                // Esperado: dd/mm/yy, HH:MM hrs
                $raw = str_replace(' hrs', '', $request->conclusion);
                $fechaConclusion = Carbon::createFromFormat('d/m/y, H:i', $raw);
            }

            // Guardar en taservicios
            $serv = new OrdenesServicio();

            $serv->anio = $anio;
            $serv->consecutivo = $consecutivo;

            // ✅ Debe existir columna "folio" en taservicios (string)
            $serv->folio = $folio;

            $serv->dfecha_solicitud = $fechaSolicitud;
            $serv->dfecha_conclusion = $fechaConclusion;

            $serv->iid_administracion = $request->area;
            $serv->iid_personal_solicitante = $request->solicitante;
            $serv->iid_taller = $request->taller;

            $serv->cdescripcion_servicio = $request->descripcion_servicio;

            // Observaciones nulo al crear
            $serv->cobservaciones = $request->observaciones;

            // Cuadrilla si aplica
            if ($request->tipo_asignacion === 'cuadrilla' && $request->filled('cuadrilla')) {
                $serv->iid_cuadrilla = $request->cuadrilla;
            } else {
                $serv->iid_cuadrilla = null;
            }

            $serv->save();

            // Personal multi -> pivote
            if ($request->tipo_asignacion === 'personal' && $request->filled('personal_ids')) {
                foreach ($request->personal_ids as $pid) {
                    DB::table('taservicio_personal')->insert([
                        'iid_servicio' => $serv->iid_servicio,
                        'iid_personal' => (int) $pid,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()->back()->with('success', "Orden creada con folio: {$folio}");
        });
    }
}
