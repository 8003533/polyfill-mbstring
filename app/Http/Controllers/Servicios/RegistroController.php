<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catalogos\Taller;
use App\Models\Servicios\OrdenesServicio;

class RegistroController extends Controller
{
    //FFV Controlador para registrar las ordenes de servicio
    public function index(Request $request)
    {
        
        return view('registro.index');
    }

    public function guardar(Request $request)
    {
            // Validar
            $request->validate([
                'area' => 'required|integer',
                'solicitante' => 'required|integer',
                'taller' => 'required|integer',
                'descripcion_servicio' => 'required|string',
                'personal' => 'required|integer',
            ]);

            // Generar folio
            $folio = 'ORD-' . now()->format('Ymd-His');

            // Guardar en la tabla taservicios
            DB::table('taservicios')->insert([
                'folio' => $folio,
                'fecha_solicitud' => now(),
                'id_area' => $request->area,
                'id_solicitante' => $request->solicitante,
                'id_taller' => $request->taller,
                'descripcion_servicio' => $request->descripcion_servicio,
                'id_personal' => $request->personal,
                'observaciones' => '',
                'conclusion' => '',
                'created_at' => now(),
            ]);

            return response()->json(['folio' => $folio], 200);
    }

}
