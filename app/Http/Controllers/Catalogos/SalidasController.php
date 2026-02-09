<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Salida;
use App\Models\Catalogos\DetalleSalida;
use App\Models\Catalogos\Bien;

class SalidasController extends Controller
{
    public function index()
    {
        $salidas = Salida::query()
            ->withSum('detalles as total_utilizada', 'cantidad_utilizada')
            ->orderByDesc('id_salida')
            ->get();

        return view('salidas.index', compact('salidas'));
    }

    public function nuevo()
    {
        $bienes = Bien::orderBy('codigo')->get();
        return view('salidas.nuevo', compact('bienes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'fecha'  => ['required', 'date'],
            'folio'  => ['nullable', 'string', 'max:255'],
            'motivo' => ['nullable', 'string', 'max:255'],

            // detalle
            'id_bien' => ['required', 'array', 'min:1'],
            'id_bien.*' => ['required', 'integer', 'exists:tcbienes,id_bien'],

            'cantidad_disponible' => ['required', 'array', 'min:1'],
            'cantidad_disponible.*' => ['required', 'numeric', 'min:0'],

            'cantidad_utilizada' => ['required', 'array', 'min:1'],
            'cantidad_utilizada.*' => ['required', 'numeric', 'min:0.001'],
        ]);

        DB::transaction(function () use ($request) {

            $salida = Salida::create([
                'fecha'  => $request->fecha,
                'folio'  => $request->folio,
                'motivo' => $request->motivo,
            ]);

            foreach ($request->id_bien as $i => $idBien) {
                DetalleSalida::create([
                    'id_salida'            => $salida->id_salida,
                    'id_bien'              => $idBien,
                    'cantidad_disponible'  => $request->cantidad_disponible[$i],
                    'cantidad_utilizada'   => $request->cantidad_utilizada[$i],
                ]);
            }
        });

        return redirect()->route('salidas.index')->with('success', 'Salida creada correctamente.');
    }

    public function editar($id_salida)
    {
        $salida = Salida::with('detalles.bien')->findOrFail($id_salida);
        $bienes = Bien::orderBy('codigo')->get();

        return view('salidas.editar', compact('salida', 'bienes'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_salida' => ['required','integer','exists:tasalidas,id_salida'],
            'fecha'  => ['required', 'date'],
            'folio'  => ['nullable', 'string', 'max:255'],
            'motivo' => ['nullable', 'string', 'max:255'],
        ]);

        $salida = Salida::findOrFail($request->id_salida);
        $salida->update([
            'fecha'  => $request->fecha,
            'folio'  => $request->folio,
            'motivo' => $request->motivo,
        ]);

        return redirect()->route('salidas.index')->with('success', 'Salida actualizada correctamente.');
    }

    public function eliminar($id_salida)
    {
        $salida = Salida::findOrFail($id_salida);
        $salida->delete(); // cascade elimina tadetalle_salida

        return redirect()->route('salidas.index')->with('success', 'Salida eliminada correctamente.');
    }

    public function datos_salida($id_salida)
    {
        $salida = Salida::with('detalles.bien')->findOrFail($id_salida);
        return view('salidas.datos_salida', compact('salida'));
    }
}
