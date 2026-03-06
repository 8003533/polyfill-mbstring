<?php

namespace App\Http\Controllers\Suministros;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuministrosController extends Controller
{

public function index()
{

$suministros = DB::table('tcbienes as b')
->leftJoin('tcunidades as u','u.id_unidad','=','b.id_unidad')
->select(
'b.id_bien',
'b.codigo',
'b.descripcion',
'b.existencia_local',
'b.stock_minimo',
'b.stock_maximo',
'b.ultima_entrada',
'b.ultima_salida',
'u.nombre as unidad_nombre'
)
->orderByDesc('b.id_bien')
->get();

$unidades = DB::table('tcunidades')->get();

return view('suministros.index',compact('suministros','unidades'));

}


public function store(Request $request)
{

$request->validate([
'codigo'=>'required',
'descripcion'=>'required',
'id_unidad'=>'required',
'existencia_local'=>'required',
'stock_minimo'=>'required',
'stock_maximo'=>'required'
]);

DB::table('tcbienes')->insert([

'codigo'=>$request->codigo,
'descripcion'=>$request->descripcion,
'id_unidad'=>$request->id_unidad,
'id_categoria'=>1,
'existencia_local'=>$request->existencia_local,
'stock_minimo'=>$request->stock_minimo,
'stock_maximo'=>$request->stock_maximo,
'ultima_entrada'=>now(),
'ultima_salida'=>$request->ultima_salida,
'created_at'=>now(),
'updated_at'=>now()

]);

return redirect()->route('suministros.index')
->with('success','Suministro agregado correctamente');

}


public function edit($id)
{

$suministro = DB::table('tcbienes')
->where('id_bien',$id)
->first();

$unidades = DB::table('tcunidades')->get();

return view('suministros.edit',compact('suministro','unidades'));

}


public function update(Request $request,$id)
{

DB::table('tcbienes')
->where('id_bien',$id)
->update([

'codigo'=>$request->codigo,
'descripcion'=>$request->descripcion,
'id_unidad'=>$request->id_unidad,
'existencia_local'=>$request->existencia_local,
'stock_minimo'=>$request->stock_minimo,
'stock_maximo'=>$request->stock_maximo,
'ultima_salida'=>$request->ultima_salida,
'updated_at'=>now()

]);

return redirect()->route('suministros.index')
->with('success','Suministro actualizado');

}


public function destroy($id)
{

DB::table('tcbienes')
->where('id_bien',$id)
->delete();

return redirect()->route('suministros.index')
->with('success','Suministro eliminado');

}

}
