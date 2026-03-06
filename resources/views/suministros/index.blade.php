@extends('layouts.app')

@section('panel')

<div class="container">

<h4 class="mb-4 text-center">Listado de Suministros</h4>


{{-- BOTON AGREGAR --}}
<div class="mb-3 text-right">

<button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregar">
+ Agregar
</button>

</div>

{{-- TABLA --}}
<table class="table table-bordered table-striped">

<thead class="thead-light">

<tr>

<th>Clave</th>
<th>Descripción</th>
<th>Existencia</th>
<th>Unidad</th>
<th>Stock Min</th>
<th>Stock Max</th>
<th>Última Entrada</th>
<th>Última Salida</th>
<th>Acciones</th>

</tr>

</thead>

<tbody>

@foreach($suministros as $s)

<tr>

<td>{{ $s->codigo }}</td>
<td>{{ $s->descripcion }}</td>
<td>{{ $s->existencia_local }}</td>
<td>{{ $s->unidad_nombre }}</td>
<td>{{ $s->stock_minimo }}</td>
<td>{{ $s->stock_maximo }}</td>
<td>{{ $s->ultima_entrada }}</td>
<td>{{ $s->ultima_salida }}</td>

<td>

<a href="{{ route('suministros.edit',$s->id_bien) }}"
class="btn btn-light">

<img src="http://127.0.0.1:8000/bootstrap-icons-1.5.0/pencil-fill.svg" width="18" height="18">

</a>

<form action="{{ route('suministros.destroy',$s->id_bien) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-light">


<img src="http://127.0.0.1:8000/bootstrap-icons-1.5.0/trash-fill.svg" width="16" height="16">

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>


{{-- MODAL AGREGAR --}}

<div class="modal fade" id="modalAgregar">

<div class="modal-dialog modal-lg">

<div class="modal-content">

<div class="modal-header">

<h5>Agregar Suministro</h5>

<button class="close" data-dismiss="modal">
<span>&times;</span>
</button>

</div>


<form method="POST" action="{{ route('suministros.store') }}">

@csrf

<div class="modal-body">

<div class="row">

<div class="col-md-6">

<label>Clave</label>

<input type="text" name="codigo" class="form-control">

</div>

<div class="col-md-6">

<label>Descripción</label>

<input type="text" name="descripcion" class="form-control">

</div>

</div>

<div class="row mt-3">

<div class="col-md-4">

<label>Existencia</label>

<input type="number" name="existencia_local" class="form-control">

</div>

<div class="col-md-4">

<label>Stock Min</label>

<input type="number" name="stock_minimo" class="form-control">

</div>

<div class="col-md-4">

<label>Stock Max</label>

<input type="number" name="stock_maximo" class="form-control">

</div>

</div>

<div class="row mt-3">

<div class="col-md-6">

<label>Unidad</label>

<select name="id_unidad" class="form-control">

@foreach($unidades as $u)

<option value="{{ $u->id_unidad }}">
{{ $u->nombre }}
</option>

@endforeach

</select>

</div>

<div class="col-md-6">

<label>Última salida</label>

<input type="date" name="ultima_salida" class="form-control">

</div>

</div>

</div>

<div class="modal-footer">

<button class="btn btn-primary">
Guardar
</button>

<button class="btn btn-secondary" data-dismiss="modal">
Cancelar
</button>

</div>

</form>

</div>

</div>

</div>

@endsection
