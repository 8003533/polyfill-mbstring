@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">Nuevo Proveedor</h3>
@endsection

@section('panel')
<div class="container">
    <form action="{{ route('proveedores.guardar') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nombre:</label>
            <input name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>
        <div class="mb-3">
            <label>Contacto: </label>
            <input name="contacto" type="email" class="form-control" value="{{ old('contacto') }}">
        </div>
        <div class="mb-3">
            <label>Teléfono:</label>
            <input name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="mb-3">
            <label>Dirección:</label>
            <input name="direccion" class="form-control" value="{{ old('direccion') }}">
        </div>


        <div class="d-flex justify-content-between">
            <a href="{{ route('proveedores.index') }}" class="btn btn-primary">Cancelar</a>
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>
    </form>
</div>
@endsection
