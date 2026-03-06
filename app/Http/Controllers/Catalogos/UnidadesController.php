<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogos\Unidad;

class UnidadesController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('nombre','');

        $unidades = DB::table('tcunidades')
            ->where('nombre', 'like', "%{$term}%")
            ->orderBy('id_unidad', 'desc')
            ->paginate(10);

        return view('unidades.index', compact('unidades','term'));
    }

    public function nuevo()
    {
        return view('unidades.nuevo');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
         //   'abreviatura' => 'nullable|string|max:50',
          //  'descripcion' => 'nullable|string|max:1000'
        ]);

        Unidad::create($request->only(['nombre','abreviatura','descripcion']));

        return redirect()->route('unidades.index')->with('success','Unidad creada.');
    }

    public function editar($id_unidad)
    {
        $unidad = Unidad::find($id_unidad);
        if (!$unidad) return redirect()->route('unidades.index')->with('error','No existe.');
        return view('unidades.editar', compact('unidad'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_unidad' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'abreviatura' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string|max:1000'
        ]);

        $unidad = Unidad::find($request->id_unidad);
        if (!$unidad) return redirect()->route('unidades.index')->with('error','No existe.');

        $unidad->update($request->only(['nombre','abreviatura','descripcion']));

        return redirect()->route('unidades.index')->with('success','Unidad actualizada.');
    }

    public function eliminar($id_unidad)
    {
        DB::table('tcunidades')->where('id_unidad',$id_unidad)->delete();
        return redirect()->route('unidades.index')->with('success','Unidad eliminada.');
    }
}
