<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\Proveedor;
use App\Models\Catalogos\Bien;

class EntradasController extends Controller
{
    public function index()
    {
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

    public function guardar(Request $request)
    {
        $data = $request->validate([
            'id_proveedor' => ['required', 'integer'],
            'folio'        => ['nullable', 'string', 'max:100'],
            'tipo'         => ['required', 'string', 'max:100'],
            'fecha'        => ['required', 'date'],
            'id_bien'      => ['required', 'integer'],
            'cantidad'     => ['required', 'integer', 'min:1'],
        ], [
            'id_proveedor.required' => 'Selecciona un proveedor.',
            'id_bien.required'      => 'Selecciona un bien.',
            'cantidad.min'          => 'La cantidad debe ser mayor a 0.',
        ]);

        DB::transaction(function () use ($data) {

            $idEntrada = DB::table('tcentradas')->insertGetId([
                'id_proveedor' => $data['id_proveedor'],
                'folio'        => $data['folio'] ?? null,
                'tipo'         => $data['tipo'],
                'fecha'        => $data['fecha'],
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);

            DB::table('tadetalle_entrada')->insert([
                'id_entrada' => $idEntrada,
                'id_bien'    => $data['id_bien'],
                'cantidad'   => $data['cantidad'],
                'created_at' => now(),
                'updated_at' => now(),
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

        DB::table('tcentradas')
            ->where('id_entrada', $data['id_entrada'])
            ->update([
                'id_proveedor' => $data['id_proveedor'],
                'folio'        => $data['folio'] ?? null,
                'tipo'         => $data['tipo'],
                'fecha'        => $data['fecha'],
                'updated_at'   => now(),
            ]);

        return redirect()->route('entradas.index')->with('success', 'Entrada actualizada correctamente.');
    }

    public function eliminar($id)
    {
        DB::transaction(function () use ($id) {
            DB::table('tadetalle_entrada')->where('id_entrada', $id)->delete();
            DB::table('tcentradas')->where('id_entrada', $id)->delete();
        });

        return redirect()->route('entradas.index')->with('success', 'Entrada eliminada correctamente.');
    }
}
