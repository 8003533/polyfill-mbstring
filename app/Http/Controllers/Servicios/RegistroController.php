<?php

namespace App\Http\Controllers\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Taller;
use App\Models\Catalogos\Administracion;
use App\Models\Catalogos\Personal;
use App\Models\Catalogos\Cuadrilla;
use App\Models\Servicios\OrdenesServicio;


class RegistroController extends Controller
{
    //FFV Controlador para registrar las ordenes de servicio
    public function index(Request $request)
    {
         $administracion = Administracion::all();
         $personal_solicitante = Personal::all();
         $talleres = Taller::all();
         $cuadrilla = Cuadrilla::all();
        return view('registro.index',compact('administracion','personal_solicitante','talleres','cuadrilla'));
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

                $now                                    = new \DateTime();
                $ordenes                              = new OdrdenesServicio();
                $jsonBefore                             = "NEW INSERT ORDENES SERVICIO";
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
                $edificio->iid_usuario                  = auth()->user()->id;
                $edificio->save();
                $jsonAfter                              = json_encode($edificio);

            return response()->json(['folio' => $folio], 200);
    }

}
