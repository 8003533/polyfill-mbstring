<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catalogos\Salida;
use App\Models\Catalogos\DetalleSalida;
use App\Models\Catalogos\Bien;

class SalidasController extends Controller
{
    public function index()
    {
        $bienes = Bien::orderBy('codigo')->get();

        // Salidas + sus detalles + bien
        $salidas = Salida::with(['detalles.bien'])
            ->orderByDesc('id_salida')
            ->paginate(10);

        return view('salidas.index', compact('salidas', 'bienes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'folio' => 'nullable|string|max:100',
            'motivo' => 'nullable|string|max:255',
            'id_bien' => 'required|exists:tcbienes,id_bien',
            'cantidad_utilizada' => 'required|numeric|min:0.01',
        ]);

        $bien = Bien::findOrFail($request->id_bien);

        $salida = Salida::create([
            'fecha' => $request->fecha,
            'folio' => $request->folio,
            'motivo' => $request->motivo,
        ]);

        DetalleSalida::create([
            'id_salida' => $salida->id_salida,
            'id_bien' => $bien->id_bien,
            'cantidad_disponible' => $bien->stok_max, // DER: stok max
            'cantidad_utilizada' => $request->cantidad_utilizada,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida registrada correctamente');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_salida' => 'required|exists:tasalidas,id_salida',
            'id_detalle_salida' => 'required|exists:detalle_salida,id_detalle_salida',
            'fecha' => 'required|date',
            'folio' => 'nullable|string|max:100',
            'motivo' => 'nullable|string|max:255',
            'id_bien' => 'required|exists:tcbienes,id_bien',
            'cantidad_utilizada' => 'required|numeric|min:0.01',
        ]);

        $salida = Salida::findOrFail($request->id_salida);
        $salida->update([
            'fecha' => $request->fecha,
            'folio' => $request->folio,
            'motivo' => $request->motivo,
        ]);

        $bien = Bien::findOrFail($request->id_bien);

        $detalle = DetalleSalida::findOrFail($request->id_detalle_salida);

        // Seguridad extra: ese detalle debe pertenecer a esa salida
        if ((int)$detalle->id_salida !== (int)$salida->id_salida) {
            return redirect()->route('salidas.index')->with('danger', 'Detalle no corresponde a la salida.');
        }

        $detalle->update([
            'id_bien' => $bien->id_bien,
            'cantidad_disponible' => $bien->stok_max,
            'cantidad_utilizada' => $request->cantidad_utilizada,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida actualizada correctamente');
    }

    public function eliminar($id_salida)
    {
        // BORRA DETALLES (si no tienes cascade)
        DetalleSalida::where('id_salida', $id_salida)->delete();

        Salida::findOrFail($id_salida)->delete();

        return redirect()->route('salidas.index')->with('success', 'Salida eliminada correctamente');
    }
}
