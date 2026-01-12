<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Categoria;
use App\Models\Servicios\Bitacora;
use Illuminate\Support\Facades\Auth;

class CategoriasController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $categoria = $request->categoria ?? '';

        if ($categoria !== '') {
            $data['categorias'] = Categoria::where('cdescripcion_categoria', 'like', '%' . $categoria . '%')
                ->where('iestatus', 1)
                ->orderBy('cdescripcion_categoria')
                ->get();
        } else {
            $data['categorias'] = Categoria::where('iestatus', 1)
                ->orderBy('cdescripcion_categoria')
                ->latest()
                ->take(200)
                ->get();
        }

        return view('categorias.index', $data);
    }

    public function nuevo_categoria()
    {
        $categoria = new Categoria();
        $noeditar = '';
        return view('categorias.nuevo', compact('categoria', 'noeditar'));
    }

    public function guardar_categoria(Request $request)
    {
        $request->validate([
            'descripcion_categoria' => 'required|string|max:255',
        ]);

        $descripcion = $request->descripcion_categoria;

        $existe = Categoria::where('cdescripcion_categoria', $descripcion)
            ->where('iestatus', 1)
            ->exists();

        if ($existe) {
            return redirect()->route('categorias.nuevo')
                ->with('danger', 'YA EXISTE una Categoria con este Nombre.');
        }

        $categoria = new Categoria();
        $jsonBefore = 'NEW INSERT CATEGORIA';
        $categoria->cdescripcion_categoria = $descripcion;
        $categoria->iestatus = 1;
        $categoria->iid_usuario = Auth::id();
        $categoria->save();

        $jsonAfter = json_encode($categoria);
        $this->bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('categorias.editar', $categoria->iid_categoria)
            ->with('success', 'Categoria guardada satisfactoriamente');
    }

    public function editar_categoria($id)
    {
        $categoria = Categoria::where('iid_categoria', $id)->firstOrFail();
        $noeditar = '';
        return view('categorias.editar', compact('categoria', 'noeditar'));
    }

    public function actualizar_categoria(Request $request)
    {
        $categoria = Categoria::where('iid_categoria', $request->id_categoria)->firstOrFail();
        $jsonBefore = json_encode($categoria);

        if ($request->noeditar === "disabled") {
            $operacion = ($categoria->iestatus == 0) ? "RECUPERADO" : "BORRADO";
            $categoria->iestatus = ($categoria->iestatus == 0) ? 1 : 0;
        } else {
            $request->validate([
                'descripcion_categoria' => 'required|string|max:255',
            ]);
            $operacion = "ACTUALIZADO";
            $categoria->cdescripcion_categoria = $request->descripcion_categoria;
            $categoria->iestatus = 1;
        }

        $categoria->iid_usuario = Auth::id();
        $categoria->save();

        $jsonAfter = $operacion . ' ' . json_encode($categoria);
        $this->bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria ' . $operacion . ' satisfactoriamente');
    }

    public function confirmainhabilitar_categoria($id)
    {
        $categoria = Categoria::where('iid_categoria', $id)->firstOrFail();
        $noeditar = 'disabled';
        return view('categorias.inhabilitar', compact('categoria', 'noeditar'));
    }

    public function bitacora(string $jsonBefore, string $jsonAfter)
    {
        $userId = Auth::id();
        if (!$userId) {
            return;
        }

        $bitacora = new Bitacora();
        $bitacora->cjson_antes = $jsonBefore ?? 'NEW INSERT';
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario = $userId;
        $bitacora->save();
    }

    public function buscaCategoria(Request $request)
    {
        $ba = $request->ba;

        $lista = Categoria::where('cdescripcion_categoria', 'like', '%' . $ba . '%')
            ->where('iestatus', 1)
            ->get();

        if (!$lista->isEmpty()) {
            return response()->json(['lista' => $lista, 'exito' => 1]);
        } else {
            return response()->json(['lista' => null, 'exito' => 0]);
        }
    }
}
