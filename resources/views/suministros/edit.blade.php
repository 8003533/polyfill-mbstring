@extends('layouts.app')

@section('panel')

<div class="container">

<h4 class="mb-4">Editar Suministro</h4>

<form method="POST"
action="{{ route('suministros.update',$suministro->id_bien) }}">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6">

<label>Clave</label>

<input type="text"
name="codigo"
class="form-control"
value="{{ $suministro->codigo }}">

</div>

<div class="col-md-6">

<label>Descripción</label>

<input type="text"
name="descripcion"
class="form-control"
value="{{ $suministro->descripcion }}">

</div>

</div>


<div class="row mt-3">

<div class="col-md-4">

<label>Existencia</label>

<input type="number"
name="existencia_local"
class="form-control"
value="{{ $suministro->existencia_local }}">

</div>

<div class="col-md-4">

<label>Stock Min</label>

<input type="number"
name="stock_minimo"
class="form-control"
value="{{ $suministro->stock_minimo }}">

</div>

<div class="col-md-4">

<label>Stock Max</label>

<input type="number"
name="stock_maximo"
class="form-control"
value="{{ $suministro->stock_maximo }}">

</div>

</div>


<div class="row mt-3">

<div class="col-md-6">

<label>Unidad</label>

<select name="id_unidad" class="form-control">

@foreach($unidades as $u)

<option value="{{ $u->id_unidad }}"
@if($suministro->id_unidad == $u->id_unidad) selected @endif>

{{ $u->nombre }}

</option>

@endforeach

</select>

</div>

<div class="col-md-6">

<label>Última salida</label>

<input type="date"
name="ultima_salida"
class="form-control"
value="{{ $suministro->ultima_salida }}">

</div>

</div>

<div class="mt-4">

<button class="btn btn-primary">
Actualizar
</button>

<a href="{{ route('suministros.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</div>

</form>

</div>

@endsection
