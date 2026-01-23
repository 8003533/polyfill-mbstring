<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BienesController extends Controller
{
    public function index()
    {
        $unidades   = DB::table('tcunidades')->orderBy('nombre')->get();
        $categorias = DB::table('tccategorias')->orderBy('nombre')->get();

        $bienes = DB::table('tcbienes as b')
            ->leftJoin('tcunidades as u', 'u.id_unidad', '=', 'b.id_unidad')
            ->leftJoin('tccategorias as c', 'c.id_categoria', '=', 'b.id_categoria')
            ->select(
                'b.id_bien',
                'b.codigo',
                'b.nombre',
                'b.id_unidad',
                'b.id_categoria',
                'b.stok_min',
                'b.stok_max',
                DB::raw('IFNULL(u.nombre,"-") as unidad_nombre'),
                DB::raw('IFNULL(c.nombre,"-") as categoria_nombre')
            )
            ->orderByDesc('b.id_bien')
            ->paginate(10);

        return view('bienes.index', compact('bienes','unidades','categorias'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'codigo'       => 'required|string|max:100',
            'nombre'       => 'required|string|max:255',
            'id_unidad'    => 'required|integer',
            'id_categoria' => 'required|integer',
            'stok_min'     => 'nullable|numeric',
            'stok_max'     => 'nullable|numeric',
        ]);

        DB::table('tcbienes')->insert([
            'codigo'       => $request->codigo,
            'nombre'       => $request->nombre,
            'id_unidad'    => $request->id_unidad,
            'id_categoria' => $request->id_categoria,
            'stok_min'     => $request->stok_min ?? 0,
            'stok_max'     => $request->stok_max ?? 0,
        ]);

        return redirect()->route('bienes.index')->with('success','Bien guardado correctamente.');
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_bien'      => 'required|integer',
            'codigo'       => 'required|string|max:100',
            'nombre'       => 'required|string|max:255',
            'id_unidad'    => 'required|integer',
            'id_categoria' => 'required|integer',
            'stok_min'     => 'nullable|numeric',
            'stok_max'     => 'nullable|numeric',
        ]);

        DB::table('tcbienes')
            ->where('id_bien', $request->id_bien)
            ->update([
                'codigo'       => $request->codigo,
                'nombre'       => $request->nombre,
                'id_unidad'    => $request->id_unidad,
                'id_categoria' => $request->id_categoria,
                'stok_min'     => $request->stok_min ?? 0,
                'stok_max'     => $request->stok_max ?? 0,
            ]);

        return redirect()->route('bienes.index')->with('success','Bien actualizado correctamente.');
    }

    public function eliminar($id_bien)
    {
        DB::table('tcbienes')->where('id_bien', $id_bien)->delete();
        return redirect()->route('bienes.index')->with('success','Bien eliminado correctamente.');
    }
}
