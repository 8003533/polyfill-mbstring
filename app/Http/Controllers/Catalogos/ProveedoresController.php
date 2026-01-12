<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogos\Proveedor;

class ProveedoresController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->get('nombre','');

        $proveedores = DB::table('tcproveedores')
            ->where('nombre', 'like', "%{$term}%")
            ->orderBy('id_proveedor', 'desc')
            ->paginate(10);

        return view('proveedores.index', compact('proveedores', 'term'));
    }

    public function nuevo()
    {
        return view('proveedores.nuevo');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500'
        ]);

        Proveedor::create($request->only(['nombre','contacto','telefono','direccion']));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function editar($id_proveedor)
    {
        $proveedor = Proveedor::find($id_proveedor);
        if (!$proveedor) return redirect()->route('proveedores.index')->with('error', 'Proveedor no encontrado.');

        return view('proveedores.editar', compact('proveedor'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'contacto' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:500'
        ]);

        $proveedor = Proveedor::find($request->id_proveedor);
        if (!$proveedor) return redirect()->route('proveedores.index')->with('error', 'Proveedor no encontrado.');

        $proveedor->update($request->only(['nombre','contacto','telefono','direccion']));

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function eliminar($id_proveedor)
    {
        DB::table('tcproveedores')->where('id_proveedor', $id_proveedor)->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
