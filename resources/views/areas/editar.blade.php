@extends('layouts.app')

@section('titulo')
<h3 class="text-warning text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
    Editar Área
</h3>
@endsection

@section('panel')
<div class="container mt-4">

    <form action="{{ route('areas.actualizar') }}" method="POST">
        @csrf

        <input type="hidden" name="id_areas" value="{{ $area->id_areas }}">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Área:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" 
                   value="{{ $area->nombre }}" required>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>

    </form>

</div>
@endsection
