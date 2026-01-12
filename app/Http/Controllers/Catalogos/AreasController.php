<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
{
    // LISTADO DE ÁREAS CON BÚSQUEDA Y PAGINACIÓN
    public function index(Request $request)
    {
        $term = $request->get('area', '');

        $areas = DB::table('tcareas')
            ->where('nombre', 'like', "%{$term}%")
            ->paginate(10);

        return view('areas.index', compact('areas', 'term'));
    }

    // FORMULARIO NUEVA ÁREA
    public function nuevo_area()
    {
        return view('areas.nuevo');
    }

    // GUARDAR ÁREA
    public function guardar_area(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        DB::table('tcareas')->insert([
            'nombre' => $request->nombre,
            'estatus' => 1 // Activo por defecto
        ]);

        return redirect()->route('areas.index')->with('success', 'Área creada correctamente.');
    }

    // FORMULARIO EDITAR ÁREA
    public function editar_area($id_areas)
    {
        $area = DB::table('tcareas')->where('id_areas', $id_areas)->first();

        if (!$area) {
            return redirect()->route('areas.index')->with('error', 'No existe.');
        }

        return view('areas.editar', compact('area'));
    }

    // ACTUALIZAR ÁREA (SIN ESTATUS)
    public function actualizar_area(Request $request)
    {
        $request->validate([
            'id_areas' => 'required|integer',
            'nombre' => 'required|string|max:255',
        ]);

        DB::table('tcareas')
            ->where('id_areas', $request->id_areas)
            ->update([
                'nombre' => $request->nombre
            ]);

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    // ELIMINAR ÁREA
    public function eliminar($id_areas)
    {
        DB::table('tcareas')->where('id_areas', $id_areas)->delete();

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
