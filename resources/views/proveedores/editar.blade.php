@extends('layouts.app')

@section('titulo')
<h4 class="text-primary-sin text-center">Editar Proveedor</h4>
@endsection

@section('panel')
<form action="{{ route('proveedores.editar', $proveedor->id) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nombre</label>
    <input type="text" name="nombre" value="{{ $proveedor->nombre }}" class="form-control">

    <label>Contacto</label>
    <input type="text" name="contacto" value="{{ $proveedor->contacto }}" class="form-control">

    <label>Teléfono</label>
    <input type="text" name="telefono" value="{{ $proveedor->telefono }}" class="form-control">

    <button class="btn btn-primary ">Actualizar</button>
</form>
@endsection
