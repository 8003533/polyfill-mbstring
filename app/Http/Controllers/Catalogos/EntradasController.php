<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\DetalleEntrada;
use App\Models\Catalogos\Bien;
use App\Models\Catalogos\Proveedor;

class EntradasController extends Controller
{
    public function index()
    {
        $entradas = Entrada::with(['proveedor'])
            ->orderByDesc('id_entrada')
            ->get();

        return view('entradas/index', compact('entradas'));
    }

    public function nuevo()
    {
        $proveedores = Proveedor::all();
        $bienes = Bien::all();

        return view('entradas.nuevo', compact('proveedores', 'bienes'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required',
            'fecha_entrada' => 'required|date'
        ]);

        $entrada = Entrada::create([
            'id_proveedor' => $request->id_proveedor,
            'fecha_entrada' => $request->fecha_entrada

        ]);

        if ($request->bienes) {
            foreach ($request->bienes as $bien) {
                if ($bien['cantidad'] > 0) {
                    DetalleEntrada::create([
                        'id_entrada' => $entrada->id_entrada,
                        'id_bien' => $bien['id_bien'],
                        'cantidad' => $bien['cantidad']
                    ]);

                    Bien::where('id_bien', $bien['id_bien'])
                        ->increment('stock', $bien['cantidad']);
                }
            }
        }

        return redirect()->route('entradas.index');
    }

    public function actualizar(Request $request)
    {
        Entrada::where('id_entrada', $request->id_entrada)
            ->update([
                'fecha_entrada' => $request->fecha_entrada
            ]);

        return redirect()->route('entradas.index');
    }

    public function eliminar($id)
    {
        DetalleEntrada::where('id_entrada', $id)->delete();
        Entrada::where('id_entrada', $id)->delete();

        return redirect()->route('entradas.index');
    }
}
