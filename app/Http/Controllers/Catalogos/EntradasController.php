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
    public function index(Request $request)
    {
        // ✅ Listado con proveedor (JOIN) + total (SUM cantidad detalle)
        // Ajusta nombres de tablas si los tuyos cambian:
        // tcentradas, tcproveedores, tadetalle_entrada

        $entradas = Entrada::query()
            ->leftJoin('tcproveedores as p', 'p.id_proveedor', '=', 'tcentradas.id_proveedor')
            ->leftJoin('tadetalle_entrada as d', 'd.id_entrada', '=', 'tcentradas.id_entrada')
            ->select(
                'tcentradas.*',
                'p.nombre as proveedor_nombre',
                DB::raw('COALESCE(SUM(d.cantidad),0) as total_cantidad')
            )
            ->groupBy(
                'tcentradas.id_entrada',
                'tcentradas.id_proveedor',
                'tcentradas.folio',
                'tcentradas.tipo',
                'tcentradas.fecha',
                'tcentradas.created_at',
                'tcentradas.updated_at',
                'p.nombre'
            )
            ->orderByDesc('tcentradas.id_entrada')
            ->paginate(10);

        $proveedores = Proveedor::orderBy('nombre')->get();
        $bienes = Bien::orderBy('codigo')->get();

        return view('entradas.index', compact('entradas', 'proveedores', 'bienes'));
    }

    public function crear(Request $request)
    {
        $data = $request->validate([
            'id_proveedor' => ['required', 'integer'],
            'folio'        => ['nullable', 'string', 'max:100'],
            'tipo'         => ['required', 'string', 'max:100'],
            'fecha'        => ['required', 'date'],

            // detalle (1 bien + 1 cantidad) como tu modal
            'id_bien'      => ['required', 'integer'],
            'cantidad'     => ['required', 'numeric', 'min:1'],
        ], [
            'id_proveedor.required' => 'Selecciona un proveedor.',
            'id_bien.required'      => 'Selecciona un bien.',
            'cantidad.min'          => 'La cantidad debe ser mayor a 0.',
        ]);

        DB::transaction(function () use ($data) {

            $entrada = Entrada::create([
                'id_proveedor' => $data['id_proveedor'],
                'folio'        => $data['folio'] ?? null,
                'tipo'         => $data['tipo'],
                'fecha'        => $data['fecha'],
            ]);

            DetalleEntrada::create([
                'id_entrada' => $entrada->id_entrada,
                'id_bien'    => $data['id_bien'],
                'cantidad'   => $data['cantidad'],
            ]);
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada registrada correctamente.');
    }

    public function actualizar(Request $request)
    {
        $data = $request->validate([
            'id_entrada'   => ['required', 'integer'],
            'id_proveedor' => ['required', 'integer'],
            'folio'        => ['nullable', 'string', 'max:100'],
            'tipo'         => ['required', 'string', 'max:100'],
            'fecha'        => ['required', 'date'],
        ], [
            'id_proveedor.required' => 'Selecciona un proveedor.',
        ]);

        $entrada = Entrada::findOrFail($data['id_entrada']);

        $entrada->update([
            'id_proveedor' => $data['id_proveedor'],
            'folio'        => $data['folio'] ?? null,
            'tipo'         => $data['tipo'],
            'fecha'        => $data['fecha'],
        ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
    }

    public function eliminar($id)
    {
        $entrada = Entrada::findOrFail($id);

        DB::transaction(function () use ($entrada) {
            // ✅ primero borras detalles para no romper FK
            DetalleEntrada::where('id_entrada', $entrada->id_entrada)->delete();

            $entrada->delete();
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
    }
}
