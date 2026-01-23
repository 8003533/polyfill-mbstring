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
        $entradas = Entrada::with('proveedor')
            ->withSum('detalles as total_cantidad', 'cantidad')
            ->orderByDesc('id_entrada')
            ->get();

        $proveedores = Proveedor::orderBy('nombre')->get();
        $bienes = Bien::orderBy('codigo')->get(); // ✅ para modal nuevo si lo ocupas

        return view('entradas.index', compact('entradas', 'proveedores', 'bienes'));
    }

    public function nuevo()
    {
        $proveedores = Proveedor::orderBy('nombre')->get();
        $bienes = Bien::orderBy('codigo')->get();

        return view('entradas.nuevo', compact('proveedores', 'bienes'));
    }

    public function crear(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|integer',
            'fecha'        => 'required|date',
            'tipo'         => 'required|string|max:100',
            'folio'        => 'nullable|string|max:100',

            // Detalle
            'anio'     => 'required|integer|min:2000|max:2100',
            'id_bien'  => 'required|integer',
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
            'id_entrada'   => 'required|integer',
            'id_proveedor' => 'required|integer',
            'folio'        => 'nullable|string|max:100',
            'fecha'        => 'required|date',
            'tipo'         => 'required|string|max:100',
        ]);

        $entrada = Entrada::where('id_entrada', $request->id_entrada)->firstOrFail();

        $entrada->id_proveedor = $request->id_proveedor;
        $entrada->folio        = $request->folio;
        $entrada->fecha        = $request->fecha;
        $entrada->tipo         = $request->tipo;
        $entrada->save();

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
    }

    public function inhabilitar($id)
    {
        DB::transaction(function () use ($id) {
            // Borra detalles y cabecera
            DB::table('detalle_entrada')->where('id_entrada', $id)->delete();
            Entrada::where('id_entrada', $id)->delete();
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
    }
}
