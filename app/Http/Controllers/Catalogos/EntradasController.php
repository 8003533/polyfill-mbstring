<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\Proveedor;
use App\Models\Catalogos\Bien;

class EntradasController extends Controller
{
    /**
     * Listado de entradas
     */
    public function index()
    {
        $entradas = Entrada::orderBy('id_entrada', 'desc')->paginate(10);
        return view('entradas.index', compact('entradas'));
    }

    /**
     * Formulario nueva entrada
     */
    public function crear()
    {
        $proveedores = Proveedor::all();
        $bienes = Bien::all();

        return view('entradas.nuevo', compact('proveedores', 'bienes'));
    }

    /**
     * Guardar entrada
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'id_proveedor' => 'required|exists:tcproveedores,id_proveedor',
            'tipo' => 'required|string',
            'folio' => 'nullable|string',
        ]);

        Entrada::create([
            'fecha' => $request->fecha,
            'id_proveedor' => $request->id_proveedor,
            'tipo' => $request->tipo,
            'folio' => $request->folio,
        ]);

        return redirect()
            ->route('entradas.index')
            ->with('success', 'Entrada registrada correctamente.');
    }
}
