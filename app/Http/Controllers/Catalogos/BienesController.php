<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Bien;
use App\Models\Catalogos\Unidad;
use App\Models\Catalogos\Categoria;

class BienesController extends Controller
{

public function index(Request $request)
{
    $buscar = $request->get('buscar');

    $bienes = Bien::with(['unidad', 'categoria'])
        ->paginate(10);

    // 🔥 FORZAMOS QUE SIEMPRE EXISTA
    if (!isset($bienes)) {
        $bienes = collect();
    }

    return view('bienes.index', [
        'bienes' => $bienes
    ]);
}

    // ==========================
    // NUEVO
    // ==========================
    public function nuevo_bien()
    {
        $unidades   = Unidad::all();
        $categorias = Categoria::all();

        return view('bienes.nuevo', compact('unidades', 'categorias'));
    }

    // ==========================
    // GUARDAR
    // ==========================
    public function guardar(Request $request)
    {
        $request->validate([
            'codigo'       => 'required',
            'nombre'       => 'required',
            'id_unidad'    => 'required',
            'id_categoria' => 'required',
            'stock_min'    => 'required|numeric',
            'stock_max'    => 'required|numeric',
        ]);

        Bien::create($request->all());

        return redirect()->route('bienes.index')
            ->with('success', 'Bien creado correctamente');
    }

    // ==========================
    // EDITAR
    // ==========================
    public function editar($id)
    {
        $bien       = Bien::findOrFail($id);
        $unidades   = Unidad::all();
        $categorias = Categoria::all();

        return view('bienes.editar', compact('bien', 'unidades', 'categorias'));
    }

    // ==========================
    // ACTUALIZAR
    // ==========================
    public function actualizar(Request $request)
    {
        $request->validate([
            'id_bien'      => 'required',
            'codigo'       => 'required',
            'nombre'       => 'required',
            'id_unidad'    => 'required',
            'id_categoria' => 'required',
            'stock_min'    => 'required|numeric',
            'stock_max'    => 'required|numeric',
        ]);

        $bien = Bien::findOrFail($request->id_bien);
        $bien->update($request->all());

        return redirect()->route('bienes.index')
            ->with('success', 'Bien actualizado correctamente');
    }

    // ==========================
    // ELIMINAR
    // ==========================
    public function eliminar($id)
    {
        $bien = Bien::findOrFail($id);
        $bien->delete();

        return redirect()->route('bienes.index')
            ->with('success', 'Bien eliminado correctamente');
    }
}
