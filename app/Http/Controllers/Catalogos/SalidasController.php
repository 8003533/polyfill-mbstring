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
        $salidas = Salida::orderBy('id_salida', 'desc')->paginate(10);
        return view('salidas.index', compact('salidas'));
    }

    public function nuevo()
    {
        $bienes = Bien::all();
        return view('salidas.nuevo', compact('bienes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'folio' => 'nullable|string|max:100',
            'motivo' => 'nullable|string|max:255',
            'id_bien' => 'required|exists:tcbienes,id_bien',
            'cantidad_utilizada' => 'required|numeric|min:0.01'
        ]);

        $bien = Bien::findOrFail($request->id_bien);

        $salida = Salida::create([
            'fecha' => $request->fecha,
            'folio' => $request->folio,
            'motivo' => $request->motivo
        ]);

        DetalleSalida::create([
            'id_salida' => $salida->id_salida,
            'id_bien' => $bien->id_bien,
            'cantidad_disponible' => $bien->stock_maximo,
            'cantidad_utilizada' => $request->cantidad_utilizada
        ]);

        return redirect()->route('salidas.index')
            ->with('success', 'Salida registrada correctamente');
    }

    public function eliminar($id_salida)
    {
        Salida::findOrFail($id_salida)->delete();

        return redirect()->route('salidas.index')
            ->with('success', 'Salida eliminada correctamente');
    }

    
}
