<?php
namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Bien;
use App\Models\Catalogos\Unidad;
use App\Models\Catalogos\Categoria;

class BienesController extends Controller
{
    // Listado de bienes
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $bienes = Bien::with(['unidad', 'categoria'])
            ->when($buscar, function($query, $buscar) {
                $query->where('nombre', 'like', "%$buscar%");
            })
            ->paginate(10);

        $unidades = Unidad::all();
        $categorias = Categoria::all();

        return view('bienes.index', compact('bienes', 'unidades', 'categorias'));
    }

    // Mostrar formulario de nuevo bien
    public function nuevo_bien()
    {
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        return view('bienes.nuevo', compact('unidades', 'categorias'));
    }

    // Guardar un bien nuevo
    public function guardar(Request $request)
    {
        $request->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'id_unidad' => 'required|exists:tcunidades,id_unidad',
            'id_categoria' => 'required|exists:tcategorias,id_categoria',
            'stock_minimo' => 'required|numeric',
            'stock_maximo' => 'required|numeric',
        ]);

        Bien::create($request->all());

        return redirect()->route('bienes.index')->with('success', 'Bien creado correctamente.');
    }

    // Mostrar formulario de edición de un bien
    public function editar($id)
    {
        $bien = Bien::findOrFail($id);
        $unidades = Unidad::all();
        $categorias = Categoria::all();
        return view('bienes.editar', compact('bien', 'unidades', 'categorias'));
    }

    // Actualizar un bien
    public function actualizar(Request $request)
    {
        $request->validate([
            'id_bien' => 'required|exists:bienes,id_bien',
            'codigo' => 'required',
            'nombre' => 'required',
            'id_unidad' => 'required|exists:tcunidades,id_unidad',
            'id_categoria' => 'required|exists:tcategorias,id_categoria',
            'stock_minimo' => 'required|numeric',
            'stock_maximo' => 'required|numeric',
        ]);

        $bien = Bien::findOrFail($request->id_bien);
        $bien->update($request->all());

        return redirect()->route('bienes.index')->with('success', 'Bien actualizado correctamente.');
    }

    // Eliminar un bien
    public function eliminar($id)
    {
        $bien = Bien::findOrFail($id);
        $bien->delete();

        return redirect()->route('bienes.inhabilitar')->with('success', 'Bien eliminado correctamente.');
    }
}
