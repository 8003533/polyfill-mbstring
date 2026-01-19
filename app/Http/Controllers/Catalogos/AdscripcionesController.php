<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catalogos\Adscripcion;
use App\Models\Catalogos\TipoArea;

class AdscripcionesController extends Controller
{
    public function index(Request $request)
    {
        // Lista adscripciones con tipoarea (relación)
        $adscripciones = Adscripcion::with('tipoarea')
            ->orderBy('cdescripcion_adscripcion')
            ->get();

        // Tipos de área para llenar el select del modal
        $tiposArea = TipoArea::where('iestatus', 1)
            ->orderBy('cdescripcion_tipo_area')
            ->get();

        return view('adscripciones.index', compact('adscripciones', 'tiposArea'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'cdescripcion_adscripcion' => 'required|string|max:300',
            'csiglas'                  => 'nullable|string|max:50',
            'iid_tipo_area'            => 'required|integer',
        ]);

        // Evitar duplicado por descripción
        $yaExiste = Adscripcion::where('cdescripcion_adscripcion', $request->cdescripcion_adscripcion)
            ->where('iestatus', 1)
            ->exists();

        if ($yaExiste) {
            return redirect()->route('adscripciones.index')
                ->withInput()
                ->withErrors(['cdescripcion_adscripcion' => 'Ya existe una adscripción con esa descripción.']);
        }

        $adscripcion = new Adscripcion();
        $adscripcion->cdescripcion_adscripcion = $request->cdescripcion_adscripcion;
        $adscripcion->csiglas                  = $request->csiglas ?? '';
        $adscripcion->iid_tipo_area            = $request->iid_tipo_area;
        $adscripcion->iestatus                 = 1;
        $adscripcion->iid_usuario              = auth()->id();
        $adscripcion->save();

        return redirect()->route('adscripciones.index')
            ->with('success', 'Adscripción guardada correctamente.');
    }

    public function editar($id_adscripcion)
    {
        $adscripcion = Adscripcion::where('iid_adscripcion', $id_adscripcion)->firstOrFail();

        $tiposArea = TipoArea::where('iestatus', 1)
            ->orderBy('cdescripcion_tipo_area')
            ->get();

        $noeditar = '';

        return view('adscripciones.editar', compact('adscripcion', 'tiposArea', 'noeditar'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_adscripcion'           => 'required|integer',
            'cdescripcion_adscripcion' => 'required|string|max:300',
            'csiglas'                  => 'nullable|string|max:50',
            'iid_tipo_area'            => 'required|integer',
        ]);

        $adscripcion = Adscripcion::where('iid_adscripcion', $request->id_adscripcion)->firstOrFail();

        $adscripcion->cdescripcion_adscripcion = $request->cdescripcion_adscripcion;
        $adscripcion->csiglas                  = $request->csiglas ?? '';
        $adscripcion->iid_tipo_area            = $request->iid_tipo_area;
        $adscripcion->iid_usuario              = auth()->id();
        $adscripcion->save();

        return redirect()->route('adscripciones.index')
            ->with('success', 'Adscripción actualizada correctamente.');
    }

    public function inhabilitar($id_adscripcion)
    {
        $adscripcion = Adscripcion::where('iid_adscripcion', $id_adscripcion)->firstOrFail();

        $adscripcion->iestatus = ($adscripcion->iestatus == 1) ? 0 : 1;
        $adscripcion->iid_usuario = auth()->id();
        $adscripcion->save();

        return redirect()->route('adscripciones.index')
            ->with('success', 'Cambio aplicado correctamente.');
    }
}
