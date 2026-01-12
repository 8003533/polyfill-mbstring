<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogos\Usuario;
use App\Models\Servicios\Bitacora;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    public function index(Request $request)
    {
        $usuario = $request->usuario ?? '';

        if ($usuario != '') {
            $data['usuarios'] = Usuario::where('cdescripcion_usuario', 'like', '%' . $usuario . '%')
                ->where('iestatus', 1)
                ->orderBy('cdescripcion_usuario')
                ->get();
        } else {
            $data['usuarios'] = Usuario::where('iestatus', 1)
                ->orderBy('cdescripcion_usuario')
                ->latest()
                ->take(200)
                ->get();
        }

        return view('usuarios.index', $data);
    }

    public function nuevo_usuario()
    {
        $usuario = new Usuario();
        $noeditar = '';
        return view('usuarios.nuevo', compact('usuario', 'noeditar'));
    }

    public function guardar_usuario(Request $request)
    {
        $request->validate([
            'descripcion_usuario' => 'required|string|max:255',
        ]);

        $descripcion = $request->descripcion_usuario;

        $existe = Usuario::where('cdescripcion_usuario', $descripcion)
            ->where('iestatus', 1)
            ->count();

        if ($existe > 0) {
            return redirect()->route('usuarios.nuevo')
                ->with('danger', 'YA EXISTE un Usuario con este Nombre.');
        }

        $usuario = new Usuario();
        $jsonBefore = 'NEW INSERT USUARIO';
        $usuario->cdescripcion_usuario = $descripcion;
        $usuario->iestatus = 1;
        $usuario->iid_usuario = Auth::id(); // ID del usuario que crea el registro
        $usuario->save();

        $jsonAfter = json_encode($usuario);
        $this->bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('usuarios.editar', $usuario->iid_usuario)
            ->with('success', 'Usuario guardado satisfactoriamente');
    }

    public function editar_usuario($id)
    {
        $usuario = Usuario::where('iid_usuario', $id)->firstOrFail();
        $noeditar = '';
        return view('usuarios.editar', compact('usuario', 'noeditar'));
    }

    public function actualizar_usuario(Request $request)
    {
        $usuario = Usuario::where('iid_usuario', $request->id_usuario)->firstOrFail();
        $jsonBefore = json_encode($usuario);

        if ($request->noeditar === "disabled") {
            $operacion = ($usuario->iestatus == 0) ? "RECUPERADO" : "BORRADO";
            $usuario->iestatus = ($usuario->iestatus == 0) ? 1 : 0;
        } else {
            $request->validate([
                'descripcion_usuario' => 'required|string|max:255',
            ]);
            $operacion = "ACTUALIZADO";
            $usuario->cdescripcion_usuario = $request->descripcion_usuario;
            $usuario->iestatus = 1;
        }

        $usuario->iid_usuario = Auth::id(); // quien hizo el cambio
        $usuario->save();

        $jsonAfter = $operacion . ' ' . json_encode($usuario);
        $this->bitacora($jsonBefore, $jsonAfter);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario ' . $operacion . ' satisfactoriamente');
    }

    public function confirmainhabilitar_usuario($id)
    {
        $usuario = Usuario::where('iid_usuario', $id)->firstOrFail();
        $noeditar = 'disabled';
        return view('usuarios.inhabilitar', compact('usuario', 'noeditar'));
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

    public function buscaUsuario(Request $request)
    {
        $ba = $request->ba;

        $lista = Usuario::where('cdescripcion_usuario', 'like', '%' . $ba . '%')
            ->where('iestatus', 1)
            ->get();

        if (!$lista->isEmpty()) {
            return response()->json(['lista' => $lista, 'exito' => 1]);
        } else {
            return response()->json(['lista' => null, 'exito' => 0]);
        }
    }
}