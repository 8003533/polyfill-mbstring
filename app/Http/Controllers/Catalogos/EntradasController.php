<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\DetalleEntrada;
use App\Models\Catalogos\Proveedor;
use App\Models\Catalogos\Bien;

class EntradasController extends Controller
{
    public function index()
    {
        // DER:
        // tcentradas (id_entrada, fecha, id_proveedor, tipo, folio)
        // detalle_entrada (id_entrada, anio, id_bien, cantidad)

        $entradas = Entrada::query()
            ->with(['proveedor']) // tcproveedores
            ->withSum('detalles as total_cantidad', 'cantidad') // SUM(detalle_entrada.cantidad)
            ->orderByDesc('id_entrada')
            ->get();

        $proveedores = Proveedor::orderBy('nombre')->get();
        $bienes      = Bien::orderBy('codigo')->get();

        return view('entradas.index', compact('entradas', 'proveedores', 'bienes'));
    }

    public function nuevo()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $bienes      = Bien::orderBy('codigo')->get();

        return view('entradas.nuevo', compact('proveedores', 'bienes'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|integer|exists:tcproveedores,id_proveedor',
            'fecha'        => 'required|date',
            'tipo'         => 'required|string|max:100',
            'folio'        => 'nullable|string|max:100',

            // Detalle (detalle_entrada)
            'anio'     => 'required|integer|min:2000|max:2100',
            'id_bien'  => 'required|integer|exists:tcbienes,id_bien',
            'cantidad' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $entrada = Entrada::create([
                'fecha'        => $request->fecha,
                'id_proveedor' => $request->id_proveedor,
                'tipo'         => $request->tipo,
                'folio'        => $request->folio,
            ]);

            DetalleEntrada::create([
                'id_entrada' => $entrada->id_entrada,
                'anio'       => $request->anio,
                'id_bien'    => $request->id_bien,
                'cantidad'   => $request->cantidad,
            ]);
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada creada correctamente.');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_entrada'   => 'required|integer|exists:tcentradas,id_entrada',
            'id_proveedor' => 'required|integer|exists:tcproveedores,id_proveedor',
            'folio'        => 'nullable|string|max:100',
            'fecha'        => 'required|date',
            'tipo'         => 'required|string|max:100',
        ]);

        $entrada = Entrada::where('id_entrada', $request->id_entrada)->firstOrFail();

        $entrada->update([
            'id_proveedor' => $request->id_proveedor,
            'folio'        => $request->folio,
            'fecha'        => $request->fecha,
            'tipo'         => $request->tipo,
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
    }

    public function inhabilitar($id)
    {
        DB::transaction(function () use ($id) {

            // borra detalle_entrada primero (FK)
            DetalleEntrada::where('id_entrada', $id)->delete();

            // borra tcentradas
            Entrada::where('id_entrada', $id)->delete();
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
    }
}
