@extends('layouts.app')

@section('titulo')
<h3 class="text-success text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18" height="18">
    Datos del Área
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ route('areas.guardar') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Área:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus:</label>
            <select id="estatus" name="estatus" class="form-control">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection
