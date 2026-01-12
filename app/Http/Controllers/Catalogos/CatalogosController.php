<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicios\Bitacora;
use Illuminate\Support\Facades\Auth;

use App\Models\Catalogos\Area;
use App\Models\Catalogos\Proveedor;
use App\Models\Catalogos\Unidad;
use App\Models\Catalogos\Usuario;
use App\Models\Catalogos\Entrada;
use App\Models\Catalogos\Salida;
use App\Models\Catalogos\Categoria;
use App\Models\Catalogos\Bien;

class CatalogosController extends Controller
{
    protected $dateFormat = 'Y-m-d H:i:s';

    // Vista principal de catálogos con totales de cada uno
    public function index()
    {
        $catalogos = [
            'total_areas'       => Area::where('iestatus', 1)->count(),
            'total_proveedores' => Proveedor::where('iestatus', 1)->count(),
            'total_unidades'    => Unidad::where('iestatus', 1)->count(),
            'total_usuarios'    => Usuario::where('iestatus', 1)->count(),
            'total_entradas'    => Entrada::where('iestatus', 1)->count(),
            'total_salidas'     => Salida::where('iestatus', 1)->count(),
            'total_categorias'  => Categoria::where('iestatus', 1)->count(),
            'total_bienes'      => Bien::where('iestatus', 1)->count(),
        ];

        return view('catalogos.index', $catalogos);
    }

    // Método genérico para registrar en bitácora
    public static function bitacora(string $jsonBefore, string $jsonAfter): void
    {
        $userId = Auth::id();
        if (!$userId) {
            // Opcional: lanzar excepción o solo retornar si no hay usuario autenticado
            return;
        }

        $bitacora = new Bitacora();
        $bitacora->cjson_antes   = $jsonBefore ?? 'NEW INSERT';
        $bitacora->cjson_despues = $jsonAfter;
        $bitacora->iid_usuario   = $userId;
        $bitacora->save();
    }

    // Redirecciona a la ruta correspondiente según catálogo solicitado
    public function irCatalogo(string $catalogo)
    {
        $catalogo = strtolower($catalogo);

        $rutas = [
            'areas'      => 'areas.index',
            'proveedores'=> 'proveedores.index',
            'unidades'   => 'unidades.index',
            'usuarios'   => 'usuarios.index',
            'entradas'   => 'entradas.index',
            'salidas'    => 'salidas.index',
            'categorias' => 'categorias.index',
            'bienes'     => 'bienes.index',
        ];

        if (array_key_exists($catalogo, $rutas)) {
            return redirect()->route($rutas[$catalogo]);
        }

        return redirect()->route('catalogos.index')
                         ->with('danger', 'Catálogo no encontrado');
    }
}
