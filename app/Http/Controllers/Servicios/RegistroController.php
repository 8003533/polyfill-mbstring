<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Servicios\OrdenesServicio; // <-- ASEGÚRATE que tu modelo exista con este namespace
use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Cuadrilla;

class RegistroController extends Controller
{
    public function index()
    {
        $administracion = Administracion::orderBy('cdescripcion_administracion')->get();
        $personal_solicitante = Personal::orderBy('cnombre_personal')->get();
        $talleres = Taller::orderBy('cdescripcion_taller')->get();
        $cuadrilla = Cuadrilla::orderBy('cnombre_cuadrilla')->get();

        return view('registro.index', compact('administracion','personal_solicitante','talleres','cuadrilla'));
    }

    public function folioActual()
    {
        $anio = (int) now()->format('Y');

        $ultimo = OrdenesServicio::where('anio', $anio)->max('consecutivo');
        $consecutivo = ($ultimo ?? 0) + 1;

        return response()->json(['folio' => $anio . '/' . $consecutivo]);
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'area' => ['required'],
            'solicitante' => ['required'],
            'taller' => ['required'],
            'descripcion_servicio' => ['required','string','max:500'],

            'conclusion' => ['nullable','string','max:50'],
            'observaciones' => ['nullable','string','max:255'],

            'personal_ids' => ['nullable','array'],
            'personal_ids.*' => ['integer'],

            'cuadrilla' => ['nullable','integer'],
        ], [
            'area.required' => 'Selecciona un área.',
            'solicitante.required' => 'Selecciona un solicitante.',
            'taller.required' => 'Selecciona un taller.',
            'descripcion_servicio.required' => 'Agrega la descripción del servicio.',
        ]);

        return DB::transaction(function () use ($request) {

            $anio = (int) now()->format('Y');
            $ultimo = OrdenesServicio::where('anio', $anio)->max('consecutivo');
            $consecutivo = ($ultimo ?? 0) + 1;
            $folio = $anio . '/' . $consecutivo;

            // "dd/mm/yy, HH:MM hrs" -> datetime
            $fechaConclusion = null;
            if ($request->filled('conclusion')) {
                $raw = str_replace(' hrs', '', $request->conclusion);
                $fechaConclusion = Carbon::createFromFormat('d/m/y, H:i', $raw);
            }

            $serv = new OrdenesServicio();

            // Ajusta nombres de columnas según tu tabla taservicios
            $serv->anio = $anio;
            $serv->consecutivo = $consecutivo;
            $serv->cfolio = $folio;

            $serv->dfecha_solicitud = now();
            $serv->dfecha_conclusion = $fechaConclusion;

            $serv->iid_administracion = $request->area;
            $serv->iid_personal_solicitante = $request->solicitante;
            $serv->iid_taller = $request->taller;

            $serv->cdescripcion_servicio = $request->descripcion_servicio;
            $serv->cobservaciones = $request->observaciones;

            $serv->iid_cuadrilla = $request->cuadrilla;

            $serv->save();

            // Si tienes pivote taservicio_personal, descomenta:
            /*
            if ($request->filled('personal_ids')) {
                foreach ($request->personal_ids as $pid) {
                    DB::table('taservicio_personal')->insert([
                        'iid_servicio' => $serv->iid_servicio,
                        'iid_personal' => $pid,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            */

            return redirect()->back()->with('success', "Orden creada con folio: {$folio}");
        });
    }
}
