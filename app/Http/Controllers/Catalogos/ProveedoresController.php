<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Catalogos\Proveedor;

class ProveedoresController extends Controller
{
    public function index()
    {
        // Igual a Áreas: paginado
        $proveedores = Proveedor::orderByDesc('id_proveedor')->paginate(10);

        return view('proveedores.index', compact('proveedores'));
    }

    public function guardar(Request $request)
    {
        $data = $request->validate([
            'nombre'    => ['required', 'string', 'max:255'],
            'contacto'  => ['nullable', 'string', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono'  => ['nullable', 'string', 'max:50'],
        ], [
            'nombre.required' => 'El nombre del proveedor es obligatorio.',
        ]);

        // Igual Áreas: Activo al crear
        $data['estatus'] = 1;

        Proveedor::create($data);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor guardado correctamente.');
    }

    public function actualizar(Request $request)
    {
        $data = $request->validate([
            'id_proveedor' => ['required', 'integer'],
            'nombre'       => ['required', 'string', 'max:255'],
            'contacto'     => ['nullable', 'string', 'max:255'],
            'direccion'    => ['nullable', 'string', 'max:255'],
            'telefono'     => ['nullable', 'string', 'max:50'],
        ], [
            'id_proveedor.required' => 'Falta el ID del proveedor.',
            'nombre.required'       => 'El nombre del proveedor es obligatorio.',
        ]);

        $prov = Proveedor::findOrFail($data['id_proveedor']);

        $prov->update([
            'nombre'    => $data['nombre'],
            'contacto'  => $data['contacto'] ?? null,
            'direccion' => $data['direccion'] ?? null,
            'telefono'  => $data['telefono'] ?? null,
        ]);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $prov = Proveedor::findOrFail($id);

        try {
            $prov->delete();
            return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Throwable $e) {
            return redirect()->route('proveedores.index')->with(
                'danger',
                'No se puede eliminar: el proveedor está relacionado con entradas u otros registros.'
            );
        }
    }
}
