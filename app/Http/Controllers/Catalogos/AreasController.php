<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreasController extends Controller
{
    // LISTADO CON BÚSQUEDA Y PAGINACIÓN
    public function index(Request $request)
    {
        $term = $request->get('area', '');

        $areas = DB::table('tcareas')
            ->where('nombre', 'like', "%{$term}%")
            ->orderBy('id_areas', 'desc')
            ->paginate(10);

        return view('areas.index', compact('areas', 'term'));
    }

    // FORM NUEVA ÁREA (PANTALLA) - tu ruta existe, entonces lo dejamos
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

        // Validar duplicado (opcional pero recomendado)
        $existe = DB::table('tcareas')
            ->where('nombre', $request->nombre)
            ->count();

        if ($existe > 0) {
            return redirect()->route('areas.index')
                ->with('danger', 'YA EXISTE un Área con este Nombre. Verifique.');
        }

        DB::table('tcareas')->insert([
            'nombre' => $request->nombre,
            'estatus' => 1
        ]);

        return redirect()->route('areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    // EDITAR ÁREA (PANTALLA) - tu ruta existe, la dejamos
    public function editar_area($id_areas)
    {
        $area = DB::table('tcareas')->where('id_areas', $id_areas)->first();

        if (!$area) {
            return redirect()->route('areas.index')->with('danger', 'No existe.');
        }

        return view('areas.editar', compact('area'));
    }

    // ACTUALIZAR ÁREA (POST /areas/actualizar)
    public function actualizar_area(Request $request)
    {
        $request->validate([
            'id_areas' => 'required|integer',
            'nombre'   => 'required|string|max:255',
        ]);

        // Validar duplicado en otro id (opcional pero recomendado)
        $existe = DB::table('tcareas')
            ->where('nombre', $request->nombre)
            ->where('id_areas', '!=', $request->id_areas)
            ->count();

        if ($existe > 0) {
            return redirect()->route('areas.index')
                ->with('danger', 'YA EXISTE un Área con este Nombre. Verifique.');
        }

        DB::table('tcareas')
            ->where('id_areas', $request->id_areas)
            ->update([
                'nombre' => $request->nombre
            ]);

        return redirect()->route('areas.index')->with('success', 'Área actualizada correctamente.');
    }

    // CONFIRMAR INHABILITAR (PANTALLA) - tu ruta existe
    public function confirmainhabilitar_area($id_areas)
    {
        $area = DB::table('tcareas')->where('id_areas', $id_areas)->first();

        if (!$area) {
            return redirect()->route('areas.index')->with('danger', 'No existe.');
        }

        return view('areas.inhabilitar', compact('area'));
    }

    // DATOS ÁREA (PANTALLA) - tu ruta existe
    public function datos_area($id)
    {
        $area = DB::table('tcareas')->where('id_areas', $id)->first();

        if (!$area) {
            return redirect()->route('areas.index')->with('danger', 'No existe.');
        }

        return view('areas.datos', compact('area'));
    }

    // ELIMINAR (DELETE /areas/{id_areas})
    public function eliminar($id_areas)
    {
        DB::table('tcareas')->where('id_areas', $id_areas)->delete();

        return redirect()->route('areas.index')->with('success', 'Área eliminada correctamente.');
    }
}
